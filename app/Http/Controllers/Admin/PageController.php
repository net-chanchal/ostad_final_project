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

class PageController extends Controller
{
    private array $settings;

    public function __construct()
    {
        $this->settings = Setting::query()->pluck('value', 'setting_name')->toArray();
    }

    /**
     * @return View
     */
    public function contactUs(): View
    {
        $settings = $this->settings;

        return view('admin.page.contact_us', compact('settings'));
    }

    public function contactUsUpdate(Request $request): RedirectResponse
    {
        // SETTING_CONTACT_PAGE_PHONE
        Setting::query()->where('setting_name', 'SETTING_CONTACT_PAGE_PHONE')
            ->update(['value' => $request->input('SETTING_CONTACT_PAGE_PHONE')]);

        // SETTING_CONTACT_PAGE_EMAIL
        Setting::query()->where('setting_name', 'SETTING_CONTACT_PAGE_EMAIL')
            ->update(['value' => $request->input('SETTING_CONTACT_PAGE_EMAIL')]);

        // SETTING_CONTACT_PAGE_ADDRESS
        Setting::query()->where('setting_name', 'SETTING_CONTACT_PAGE_ADDRESS')
            ->update(['value' => $request->input('SETTING_CONTACT_PAGE_ADDRESS')]);

        return redirect(route('admin.pages.contact_us'))
            ->with('message', CoreHelper::success('Contact us page has been updated successfully!'));
    }

    /**
     * @return View
     */
    public function aboutUs(): View
    {
        $settings = $this->settings;

        return view('admin.page.about_us', compact('settings'));
    }

    public function aboutUsUpdate(Request $request): RedirectResponse
    {
        // SETTING_ABOUT_US_PAGE_TITLE
        Setting::query()->where('setting_name', 'SETTING_ABOUT_US_PAGE_TITLE')
            ->update(['value' => $request->input('SETTING_ABOUT_US_PAGE_TITLE')]);

        // SETTING_ABOUT_US_PAGE_DETAIL
        Setting::query()->where('setting_name', 'SETTING_ABOUT_US_PAGE_DETAIL')
            ->update(['value' => $request->input('SETTING_ABOUT_US_PAGE_DETAIL')]);


        return redirect(route('admin.pages.about_us'))
            ->with('message', CoreHelper::success('About us page has been updated successfully!'));
    }
}