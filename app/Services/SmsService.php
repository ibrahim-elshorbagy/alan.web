<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
  protected $apiToken;
  protected $apiUrl;
  protected $senderId;

  public function __construct()
  {
    $this->apiToken = config('services.webmaster_sms.api_token');
    $this->apiUrl = config('services.webmaster_sms.api_url', 'https://www.sms-jo.com/api/http/sms/send');
    $this->senderId = config('services.webmaster_sms.sender_id', 'nfcjo.com');
  }

  /**
   * Send SMS to a single recipient
   *
   * @param string $recipient Phone number with country code
   * @param string $message SMS message content
   * @param string|null $scheduleTime Optional schedule time in Y-m-d H:i format
   * @return array Response from SMS API
   */
  public function sendSms(string $recipient, string $message, ?string $scheduleTime = null): array
  {
    try {
      // Format recipient: remove leading zeros and ensure proper format
      $recipient = preg_replace('/^00/', '', $recipient); // Remove 00 prefix if exists
      $recipient = preg_replace('/^\+/', '', $recipient); // Remove + prefix if exists
      
      // Ensure Jordan numbers start with 962
      if (!preg_match('/^962/', $recipient)) {
        $recipient = '962' . ltrim($recipient, '0');
      }

      $payload = [
        'api_token' => $this->apiToken,
        'recipient' => $recipient,
        'sender_id' => $this->senderId,
        'type' => 'plain',
        'message' => $message,
      ];

      if ($scheduleTime) {
        $payload['schedule_time'] = $scheduleTime;
      }

      $response = Http::acceptJson()
        ->contentType('application/json')
        ->post($this->apiUrl, $payload);

      $result = $response->json();

      if ($response->successful() && isset($result['status']) && $result['status'] === 'success') {
        Log::info('SMS sent successfully', ['recipient' => $recipient]);
        return [
          'success' => true,
          'data' => $result['data'] ?? null,
          'message' => 'SMS sent successfully'
        ];
      }

      Log::error('SMS sending failed', [
        'recipient' => $recipient,
        'response' => $result
      ]);

      return [
        'success' => false,
        'message' => $result['message'] ?? 'Failed to send SMS'
      ];
    } catch (\Exception $e) {
      Log::error('SMS service exception', [
        'recipient' => $recipient,
        'error' => $e->getMessage()
      ]);

      return [
        'success' => false,
        'message' => 'SMS service error: ' . $e->getMessage()
      ];
    }
  }

  /**
   * Send SMS to multiple recipients
   *
   * @param array $recipients Array of phone numbers
   * @param string $message SMS message content
   * @param string|null $scheduleTime Optional schedule time
   * @return array Response from SMS API
   */
  public function sendBulkSms(array $recipients, string $message, ?string $scheduleTime = null): array
  {
    $recipientString = implode(',', $recipients);
    return $this->sendSms($recipientString, $message, $scheduleTime);
  }

  /**
   * Send verification code via SMS
   *
   * @param string $phone Phone number with country code
   * @param string $code Verification code
   * @return array Response from SMS API
   */
  public function sendVerificationCode(string $phone, string $code): array
  {
    $message = __('messages.verify_phone.sms_message', ['code' => $code]);
    return $this->sendSms($phone, $message);
  }

  /**
   * Generate a random verification code
   *
   * @param int $length Length of the code (default 6)
   * @return string Verification code
   */
  public function generateVerificationCode(int $length = 6): string
  {
    return str_pad((string) random_int(0, (10 ** $length) - 1), $length, '0', STR_PAD_LEFT);
  }
}
