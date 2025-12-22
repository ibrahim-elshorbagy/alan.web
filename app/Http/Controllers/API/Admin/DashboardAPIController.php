<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Role;
use App\Models\ScheduleAppointment;
use App\Models\User;
use App\Models\Vcard;
use App\Repositories\DashboardRepository;
use App\Repositories\VcardRepository;
use AWS\CRT\HTTP\Request;
use Carbon\Carbon;
use Illuminate\Http\Request as RequestAlias;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class DashboardAPIController extends AppBaseController
{
    /* @var DashboardRepository */
    private DashboardRepository $dashboardRepository;

    private VcardRepository $vcardRepository;

    public function __construct(DashboardRepository $dashboardRepo , VcardRepository $vcardRepo)
    {
        $this->dashboardRepository = $dashboardRepo;

        $this->vcardRepository = $vcardRepo;
    }

    public function index()
    {
        $data['activeVcard'] = Vcard::whereTenantId(auth()->user()->tenant_id)->whereStatus(1)->count();

        $data['deActiveVcard'] = Vcard::whereTenantId(auth()->user()->tenant_id)->whereStatus(0)->count();

        $data['enquiry'] = $this->dashboardRepository->getEnquiryCountAttribute();

        $data['appointment'] = $this->dashboardRepository->getAppointmentCountAttribute();

        return $this->sendResponse($data, 'Admin Dashboard retrieve Successfully.');
    }

    public function todayAppointment()
    {
        $vcardIds = Vcard::toBase()->whereTenantId(getLogInTenantId())->pluck('id')->toArray();

        $today = Carbon::now()->format('Y-m-d');

        $appointments = ScheduleAppointment::with('vcard')->whereIn('vcard_id', $vcardIds)
            ->whereDate('date', $today)
            ->orderBy('created_at', 'DESC')
            ->get();

        $data = [];

        foreach ($appointments as $appointment) {
            $data[] = [
                'id' => $appointment->id,
                'vcard_name' => $appointment->vcard->name,
                'name' => $appointment->name,
                'phone' => $appointment->phone,
                'email' => $appointment->email,
                'date' => $appointment->date,
                'from_time' => $appointment->from_time,
                'to_time' => $appointment->to_time,
                'status' => $appointment->status,
                'paid_amount' => $appointment->paid_amount,
            ];
        }
        return $this->sendResponse($data, 'Admin Today Appointment data retrieve Successfully.');
    }

    public function incomeChartData(RequestAlias $request)
    {
        try {
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

            $input = [
                'start_date' => $startDate ?? Carbon::now()->subDays(7)->format("Y-m-d H:i:s"),
                'end_date' => $endDate ?? Carbon::now()->format("Y-m-d H:i:s"),
            ];

            $data = $this->vcardRepository->dashboardChartDataAPI($input);

            return $this->sendResponse($data, 'Data fetch successfully.');
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
