<?php

namespace App\Repositories;

use App\Models\Setting;
use Laracasts\Flash\Flash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserRepository
 */
class SettingRepository extends BaseRepository
{
    public $fieldSearchable = [
        'app_name',
    ];

    /**
     * {@inheritDoc}
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * {@inheritDoc}
     */
    public function model()
    {
        return Setting::class;
    }

    /**
     * @return Builder|Builder[]|Collection|Model
     */
    public function update($input, $userId)
    {
        if (in_array($input, ['timezone_method'])) {
            $timezone = $input['timezone_method'];

            Setting::updateOrCreate(['key' => 'timezone_method'], ['value' => $timezone]);
            Config::set('app.timezone', $timezone);
        }

        if (in_array($input, ['prefix_code'])) {
            $input['prefix_code'] = '+' . $input['prefix_code'];
        }
        if (isset($input['affiliation_amount'])) {
            $input['affiliation_amount'] = round($input['affiliation_amount'], 2);
        }

        $inputArr = Arr::except($input, ['_token']);
        if (! isset($input['front_cms_form'])) {

            if (! isset($inputArr['currency_after_amount'])) {
                $setting = Setting::where('key', 'currency_after_amount')->first();
                $setting->update(['value' => '0']);
            }

            if (! isset($inputArr['mobile_validation'])) {
                $setting = Setting::where('key', 'mobile_validation')->first();
                $setting->update(['value' => '0']);
            }

            if (! isset($inputArr['url_alias'])) {
                $setting = Setting::where('key', 'url_alias')->first();
                $setting->update(['value' => '0']);
            }

            if (! isset($inputArr['hide_decimal_values'])) {
                $setting = Setting::where('key', 'hide_decimal_values')->first();
                $setting->update(['value' => '0']);
            }

            if (! isset($inputArr['nfc_logo_required'])) {
                $setting = Setting::where('key', 'nfc_logo_required')->first();
                $setting->update(['value' => '0']);
            }
        }

        if (isset($input['custom_css'])) {
            Setting::updateOrCreate(
                ['key' => 'custom_css'],
                ['value' => $input['custom_css']]
            );
        }

        foreach ($inputArr as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if (! $setting) {
                continue;
            }

            if (in_array($key, ['app_logo', 'favicon', 'register_image', 'dashboard_logo'])) {
                $this->fileUpload($setting, $value);

                continue;
            }
            if (in_array($key, ['home_page_banner'])) {
                $setting->clearMediaCollection(Setting::FRONTPATH);
                $media = $setting->addMedia($input['home_page_banner'])->toMediaCollection(
                    Setting::FRONTPATH,
                    config('app.media_disc')
                );
                $setting->update(['value' => $media->getFullUrl()]);

                continue;
            }

            if (in_array($key, ['block_email_domains'])) {

                $cleanedDomain = str_replace(["\r\n", "\n", "\r"], ',', $value);
                $domains = explode(',', $cleanedDomain);

                $validDomains = [];
                foreach ($domains as $domain) {
                    $domain = trim($domain);

                    if (!preg_match('/^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $domain)) {
                        continue;
                    }

                    $domain = strtolower($domain);
                    if (!in_array($domain, $validDomains)) {
                        $validDomains[] = $domain;
                    }
                }

                $value = implode(',', $validDomains);
            }

            $setting->update(['value' => $value]);
        }

        return $setting;
    }

    public function homePageUpdate($input, $userId)
    {
        $inputArr = Arr::except($input, ['_token']);
        if (! isset($input['front_cms_form'])) {

            if (! isset($inputArr['is_front_page'])) {
                $setting = Setting::where('key', 'is_front_page')->first();
                $setting->update(['value' => '0']);
            }

            if (! isset($inputArr['is_cookie_banner'])) {
                $setting = Setting::where('key', 'is_cookie_banner')->first();
                $setting->update(['value' => '0']);
            }

            if (! isset($inputArr['register_enable'])) {
                $setting = Setting::where('key', 'register_enable')->first();
                $setting->update(['value' => '0']);
            }

            if (! isset($inputArr['user_verified_email'])) {
                $setting = Setting::where('key', 'user_verified_email')->first();
                $setting->update(['value' => '0']);
            }

            if (! isset($inputArr['captcha_enable'])) {
                $setting = Setting::where('key', 'captcha_enable')->first();
                $setting->update(['value' => '0']);
            }
            if (! isset($inputArr['register_mail'])) {
                $setting = Setting::where('key', 'register_mail')->first();
                $setting->update(['value' => '0']);
            }
            if (! isset($inputArr['phone_number_required'])) {
                $setting = Setting::where('key', 'phone_number_required')->first();
                $setting->update(['value' => '0']);
            }
            if (! isset($inputArr['url_alias'])) {
                $setting = Setting::where('key', 'url_alias')->first();
                $setting->update(['value' => '0']);
            }
            if (! isset($inputArr['show_referral_code'])) {
                $setting = Setting::where('key', 'show_referral_code')->first();
                $setting->update(['value' => '0']);
            }
        }


        foreach ($inputArr as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if (! $setting) {
                continue;
            }

            if (in_array($key, ['app_logo', 'favicon', 'register_image', 'dashboard_logo'])) {
                $this->fileUpload($setting, $value);

                continue;
            }
            if (in_array($key, ['home_page_banner'])) {
                $setting->clearMediaCollection(Setting::FRONTPATH);
                $media = $setting->addMedia($input['home_page_banner'])->toMediaCollection(
                    Setting::FRONTPATH,
                    config('app.media_disc')
                );
                $setting->update(['value' => $media->getFullUrl()]);

                continue;
            }

            $setting->update(['value' => $value]);
        }

        return $setting;
    }

    public function fileUpload($setting, $file)
    {
        $setting->clearMediaCollection(Setting::PATH);
        $media = $setting->addMedia($file)->toMediaCollection(Setting::PATH, config('app.media_disc'));
        $setting->update(['value' => $media->getFullUrl()]);
    }

    public function updateBanner(array $requestData)
    {
        Setting::updateOrCreate(['key' => 'banner_enable'], ['value' => $requestData['banner_enable'] ?? 0]);
        Setting::updateOrCreate(['key' => 'banner_url'], ['value' => $requestData['banner_url'] ?? null]);
        Setting::updateOrCreate(['key' => 'banner_title'], ['value' => $requestData['banner_title'] ?? null]);
        Setting::updateOrCreate(['key' => 'banner_description'], ['value' => $requestData['banner_description'] ?? null]);
        Setting::updateOrCreate(['key' => 'banner_button'], ['value' => $requestData['banner_button'] ?? null]);
    }

    public function updateAppUrl(array $requestData)
    {
        Setting::updateOrCreate(['key' => 'mobile_app_enable'], ['value' => $requestData['mobile_app_enable'] ?? 0]);
        Setting::updateOrCreate(['key' => 'play_store_link'], ['value' => $requestData['play_store_link'] ?? null]);
        Setting::updateOrCreate(['key' => 'app_store_link'], ['value' => $requestData['app_store_link'] ?? null]);
    }

    public function updateOurMission(array $requestData)
    {
        Setting::updateOrCreate(['key' => 'our_mission_title'], ['value' => $requestData['our_mission_title']]);
        Setting::updateOrCreate(['key' => 'our_mission_description1'], ['value' => $requestData['our_mission_description1'] ?? null]);
        Setting::updateOrCreate(['key' => 'our_mission_description2'], ['value' => $requestData['our_mission_description2'] ?? null]);
    }
}
