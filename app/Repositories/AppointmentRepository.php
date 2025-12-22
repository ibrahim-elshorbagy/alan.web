<?php

namespace App\Repositories;

use App\Mail\AppointmentMail;
use App\Mail\UserAppointmentMail;
use App\Models\Appointment;
use App\Models\ScheduleAppointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Razorpay\Api\Api;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class AppointmentRepository
 */
class AppointmentRepository extends BaseRepository
{
    public function model(): string
    {
        return ScheduleAppointment::class;
    }

    public function getFieldsSearchable()
    {
        //
    }

    /**
     * @param $appointment
     */
    public function userCreateSession($userId, $vcard, $input): array
    {
        try {
            setUserStripeApiKey($userId);

            $successUrl = route('user.payment-success');
            $cancelUrl = route('user.failed-payment');

            $session = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => $input['email'],
                'line_items' => [
                    [
                        'price_data' => [
                            'product_data' => [
                                'name' => $vcard->name,
                            ],
                            'unit_amount' => $input['amount'] * 100,
                            'currency' => $input['currency_code'],
                        ],
                        'quantity' => 1,
                    ],
                ],
                'client_reference_id' => $vcard->id,
                'mode' => 'payment',
                'success_url' => url($successUrl) . '?session_id={CHECKOUT_SESSION_ID}&vcard_id=' . $vcard->id,
                'cancel_url' => url($cancelUrl . '?error=payment_cancelled&vcard_id=' . $vcard->id),
            ]);

            session()->put([
                'appointment_details' => $input,
                'vcard_id' => $vcard->id,
            ]);
            session()->put('appointment_vcard_data', [
                'vcard_id' => $vcard->id,
                'default_language' => $vcard->default_language,
                'url_alias' => $vcard->url_alias,
            ]);

            $result = [
                'sessionId' => $session['id'],
            ];

            return $result;
        } catch (\Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function appointmentStoreOrEmail($input, $vcardUserEmail, $defaultLanguage = null, $urlAlias = null)
    {
        $appointment = ScheduleAppointment::create($input);
        $input['date'] = Carbon::parse($input['date'])->format('d M, Y');

        Mail::to($input['email'])
            ->send(new AppointmentMail(
                'emails.appointment_mail',
                __('messages.mail.book_appointment'),
                $input,
                $defaultLanguage,
                $urlAlias
            ));

        Mail::to($vcardUserEmail)
            ->send(new UserAppointmentMail(
                'emails.user_appointment_mail',
                __('messages.mail.book_appointment'),
                $input,
                $defaultLanguage,
                $urlAlias
            ));

        return $appointment;
    }

    public function userCreateRazorPaySession($input, $userId)
    {
        $api = new Api(getUserSettingValue('razorpay_key', $userId), getUserSettingValue('razorpay_secret', $userId));
        $orderData = [
            'receipt' => 1,
            'amount' => $input['amount'] * 100,
            'currency' => $input['currency_code'],
            'notes' => [
                'email' => $input['email'],
                'name' => $input['name'],
                'phone' => $input['phone'],
                'amountToPay' => $input['amount'],
                'payment_type' => Appointment::RAZORPAY,
            ],
        ];
        $razorpayOrder = $api->order->create($orderData);
        $data['id'] = $razorpayOrder->id;
        $data['amount'] = $input['amount'] * 100;
        $data['name'] = $input['name'];
        $data['email'] = $input['email'];
        $data['contact'] = $input['phone'];

        return $data;
    }
}
