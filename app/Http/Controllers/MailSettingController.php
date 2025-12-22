<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMailSettingRequest;
use App\Models\MailSetting;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class MailSettingController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMailSettingRequest $request)
    {
        $input = $request->all();

        $mailSetting = MailSetting::first();
        if ($mailSetting) {
            $mailSetting->update($input);
        } else {
            MailSetting::create($input);
        }

        $envFilePath = base_path('.env');
        $envFileContent = file_get_contents($envFilePath);
        $envFileContent = preg_replace('/^MAIL_MAILER=.*/m', 'MAIL_MAILER=' . strtolower(MailSetting::TYPE[$request->mail_protocol]), $envFileContent);
        $envFileContent = preg_replace('/^MAIL_HOST=.*/m', "MAIL_HOST={$request['mail_host']}", $envFileContent);
        $envFileContent = preg_replace('/^MAIL_PORT=.*/m', "MAIL_PORT={$request['mail_port']}", $envFileContent);
        $envFileContent = preg_replace('/^MAIL_USERNAME=.*/m', "MAIL_USERNAME={$request['mail_username']}", $envFileContent);
        $envFileContent = preg_replace('/^MAIL_PASSWORD=.*/m', "MAIL_PASSWORD={$request['mail_password']}", $envFileContent);
        $envFileContent = preg_replace('/^MAIL_ENCRYPTION=.*/m', 'MAIL_ENCRYPTION=' . strtolower(MailSetting::ENCRYPTION_TYPE[$request->mail_encryption]), $envFileContent);
        $envFileContent = preg_replace('/^MAIL_FROM_ADDRESS=.*/m', "MAIL_FROM_ADDRESS={$request['sender_email_address']}", $envFileContent);

        file_put_contents($envFilePath, $envFileContent);

        Flash::success(__('messages.vcard.mail_settings') . ' ' . __('messages.flash.vcard_update'));
        return Redirect::back();
    }
}
