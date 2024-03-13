<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CoreHelper;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File as ValidationRulesFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SettingController extends Controller
{
    private array $settings;

    public function __construct()
    {
        $this->settings = Setting::query()->pluck('value', 'setting_name')->toArray();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.setting.index');
    }

    /**
     * @return View
     */
    public function general(): View
    {
        $settings = $this->settings;

        return view('admin.setting.general', compact('settings'));
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function generalUpdate(Request $request): RedirectResponse
    {
        // Validation
        $errors = Validator::make($request->all(), [
            'SETTING_SITE_LOGO' => ValidationRulesFile::image()->max(1024),
            'SETTING_SITE_FAVICON' => ValidationRulesFile::image()->max(1024),
        ], [
            'SETTING_SITE_LOGO.image' => 'The logo field must be an image.',
            'SETTING_SITE_LOGO.max' => 'The logo size must not exceed 1024 KB.',
            'SETTING_SITE_FAVICON.image' => 'The favicon field must be an image.',
            'SETTING_SITE_FAVICON.max' => 'The favicon size must not exceed 1024 KB.',
        ])->errors();


        if ($errors->isNotEmpty()) {
            $errorText = '&#x2022; ' . implode('<br>&#x2022; ', $errors->all());

            return redirect(route('admin.settings.general'))
                ->with("message", CoreHelper::error($errorText));
        }

        // SETTING_SITE_TITLE
        Setting::query()->where('setting_name', 'SETTING_SITE_TITLE')
            ->update(['value' => $request->input('SETTING_SITE_TITLE')]);

        // SETTING_SITE_DESCRIPTION
        Setting::query()->where('setting_name', 'SETTING_SITE_DESCRIPTION')
            ->update(['value' => $request->input('SETTING_SITE_DESCRIPTION')]);

        // SETTING_SITE_LOGO
        if ($request->hasFile('SETTING_SITE_LOGO')) {
            // Delete previous file
            $filename = $this->settings['SETTING_SITE_LOGO'];

            if ($filename && Storage::exists('public/uploads/' . $filename)) {
                Storage::delete('public/uploads/' . $filename);
            }

            // Handle file upload
            $image = $request->file('SETTING_SITE_LOGO');
            $imageName = 'logo.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads', $imageName);

            Setting::query()->where('setting_name', 'SETTING_SITE_LOGO')
                ->update(['value' => $imageName]);
        }

        // SETTING_SITE_FAVICON
        if ($request->hasFile('SETTING_SITE_FAVICON')) {
            // Delete previous file
            $filename = $this->settings['SETTING_SITE_FAVICON'];

            if ($filename && Storage::exists('public/uploads/' . $filename)) {
                Storage::delete('public/uploads/' . $filename);
            }

            // Handle file upload
            $image = $request->file('SETTING_SITE_FAVICON');
            $imageName = 'favicon.' . $image->getClientOriginalExtension();
            $image->storeAs('public/uploads', $imageName);

            Setting::query()->where('setting_name', 'SETTING_SITE_FAVICON')
                ->update(['value' => $imageName]);
        }

        // SETTING_SITE_COPYRIGHT
        Setting::query()->where('setting_name', 'SETTING_SITE_COPYRIGHT')
            ->update(['value' => $request->input('SETTING_SITE_COPYRIGHT')]);

        // SETTING_SITE_TIMEZONE
        Setting::query()->where('setting_name', 'SETTING_SITE_TIMEZONE')
            ->update(['value' => $request->input('SETTING_SITE_TIMEZONE')]);

        // SETTING_SITE_CURRENCY
        Setting::query()->where('setting_name', 'SETTING_SITE_CURRENCY')
            ->update(['value' => $request->input('SETTING_SITE_CURRENCY')]);

        // SETTING_SITE_PRELOADING
        Setting::query()->where('setting_name', 'SETTING_SITE_PRELOADING')
            ->update(['value' => $request->input('SETTING_SITE_PRELOADING')]);

        // SETTING_SITE_DATE_FORMAT
        Setting::query()->where('setting_name', 'SETTING_SITE_DATE_FORMAT')
            ->update(['value' => $request->input('SETTING_SITE_DATE_FORMAT')]);

        // SETTING_SITE_TIME_FORMAT
        Setting::query()->where('setting_name', 'SETTING_SITE_TIME_FORMAT')
            ->update(['value' => $request->input('SETTING_SITE_TIME_FORMAT')]);

        // SETTING_GOOGLE_ANALYTICS_CODE
        Setting::query()->where('setting_name', 'SETTING_GOOGLE_ANALYTICS_CODE')
            ->update(['value' => $request->input('SETTING_GOOGLE_ANALYTICS_CODE')]);

        return redirect(route('admin.settings.general'))
            ->with('message', CoreHelper::success('General settings has been updated successfully!'));
    }

    /**
     * @return View
     */
    public function googleAds(): View
    {
        $settings = $this->settings;

        return view('admin.setting.google_ads', compact('settings'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function googleAdsUpdate(Request $request): RedirectResponse
    {
        // SETTING_GOOGLE_ADS_CODE
        Setting::query()->where('setting_name', 'SETTING_GOOGLE_ADS_CODE')
            ->update(['value' => $request->input('SETTING_GOOGLE_ADS_CODE')]);

        return redirect(route('admin.settings.google_ads'))
            ->with('message', CoreHelper::success(__('messages.setting_google_ads_update')));
    }

    /**
     * @return View
     */
    public function socialUrls(): View
    {
        $settings = $this->settings;

        return view('admin.setting.social_url', compact('settings'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function socialUrlsUpdate(Request $request): RedirectResponse
    {
        // SETTING_SOCIAL_FACEBOOK
        Setting::query()->where('setting_name', 'SETTING_SOCIAL_FACEBOOK')
            ->update(['value' => $request->input('SETTING_SOCIAL_FACEBOOK')]);

        // SETTING_SOCIAL_YOUTUBE
        Setting::query()->where('setting_name', 'SETTING_SOCIAL_YOUTUBE')
            ->update(['value' => $request->input('SETTING_SOCIAL_YOUTUBE')]);

        // SETTING_SOCIAL_INSTAGRAM
        Setting::query()->where('setting_name', 'SETTING_SOCIAL_INSTAGRAM')
            ->update(['value' => $request->input('SETTING_SOCIAL_INSTAGRAM')]);

        // SETTING_SOCIAL_LINKEDIN
        Setting::query()->where('setting_name', 'SETTING_SOCIAL_LINKEDIN')
            ->update(['value' => $request->input('SETTING_SOCIAL_LINKEDIN')]);

        // SETTING_SOCIAL_TWITTER
        Setting::query()->where('setting_name', 'SETTING_SOCIAL_TWITTER')
            ->update(['value' => $request->input('SETTING_SOCIAL_TWITTER')]);

        return redirect(route('admin.settings.social_urls'))
            ->with("message", CoreHelper::success('Social settings has been updated successfully!'));
    }

    /**
     * @return View
     */
    public function emailConfig(): View
    {
        $settings = $this->settings;

        return view('admin.setting.email_config', compact('settings'));
    }

    public function emailConfigUpdate(Request $request): RedirectResponse
    {
        // SETTING_EMAIL_CONFIG_EMAIL_ADDRESS
        Setting::query()->where('setting_name', 'SETTING_EMAIL_CONFIG_EMAIL_ADDRESS')
            ->update(['value' => $request->input('SETTING_EMAIL_CONFIG_EMAIL_ADDRESS')]);

        return redirect(route('admin.settings.contact_address'))
            ->with('message', CoreHelper::success('Contact settings has been updated successfully!'));
    }
}