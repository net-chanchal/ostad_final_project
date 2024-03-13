<?php

namespace App\Http\Controllers;

use App\Helpers\CoreHelper;
use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactUs;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactUsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return View
     */
    public function index(): View
    {
        return view('app.contact_us');
    }

    public function formSubmit(ContactFormRequest $request)
    {
        $request->validated();

        $email = CoreHelper::getSetting('SETTING_EMAIL_CONFIG_EMAIL_ADDRESS');
        $siteTitle = CoreHelper::getSetting('SETTING_SITE_TITLE');

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'siteTitle' => $siteTitle,
        ];

        try {
            Mail::to($email)->send(new ContactUs($data));

            return redirect()
                ->back()
                ->with('message', CoreHelper::success('Your contact form has been submitted.'));
        } catch (Exception $exception) {
            return redirect()
                ->back()
                ->withInput()
                ->with('message', CoreHelper::error($exception->getMessage()));
        }
    }
}
