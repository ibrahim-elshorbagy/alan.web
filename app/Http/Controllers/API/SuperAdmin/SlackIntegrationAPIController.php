<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\AppBaseController;
use Modules\SlackIntegration\Http\Requests\CreateSlackIntegrationRequest;
use Modules\SlackIntegration\Entities\SlackIntegration;
use Laracasts\Flash\Flash;

class SlackIntegrationAPIController extends AppBaseController
{

    public function edit()
    {
        if (!moduleExists('SlackIntegration')) {
            return $this->sendError('Slack Integration module not found.');
        }

        $slackIntegrationData = SlackIntegration::first();

        if (!$slackIntegrationData) {
            return $this->sendError('No Slack Integration data found.');
        }

        $data = [
            'webhook_url' => $slackIntegrationData->webhook_url,
            'new_user_registration_notification' => $slackIntegrationData->new_user_registration_notification,
            'user_plan_purchase_notification' => $slackIntegrationData->user_plan_purchase_notification,
            'user_create_vcard_notification' => $slackIntegrationData->user_create_vcard_notification,
            'user_order_nfc_card_notification' => $slackIntegrationData->user_order_nfc_card_notification,
        ];

        return $this->sendResponse($data, 'Slack Integration Data retrieved successfully.');
    }

    public function update(CreateSlackIntegrationRequest $request)
    {
        $slackIntegration = SlackIntegration::first();

        if (!$slackIntegration) {
            return $this->sendError('Slack Integration data not found.');
        }

        $validatedData = $request->validate([
            'webhook_url' => 'nullable|url',
            'new_user_registration_notification' => 'boolean',
            'user_plan_purchase_notification' => 'boolean',
            'user_create_vcard_notification' => 'boolean',
            'user_order_nfc_card_notification' => 'boolean',
        ]);

        $slackIntegration->update($validatedData);

        $data = [
            'webhook_url' => $slackIntegration->webhook_url,
            'new_user_registration_notification' => $slackIntegration->new_user_registration_notification,
            'user_plan_purchase_notification' => $slackIntegration->user_plan_purchase_notification,
            'user_create_vcard_notification' => $slackIntegration->user_create_vcard_notification,
            'user_order_nfc_card_notification' => $slackIntegration->user_order_nfc_card_notification,
        ];

        return $this->sendResponse($data, 'Slack Integration updated successfully.');
    }
}
