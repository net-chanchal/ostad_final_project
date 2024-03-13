<?php

namespace App\Http\Controllers;

use App\Helpers\CoreHelper;
use App\Models\Account;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('app.login');
    }

    /**
     * Check the login credentials and go to the dashboard.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::guard('account')->attempt($credentials)) {
            $user = Auth::guard('account')->user();

            if ($user->__get('account_type') === 'Employer') {
                // Redirect Employer Dashboard
                return redirect()->route('employer.dashboard');
            }

            // Redirect Job Seeker Dashboard
            return redirect()->route('job_seeker.dashboard');
        } else {
            return back()
                ->withInput()
                ->with('error', 'Email or Password is not valid.');
        }
    }

    /**
     * @return View
     */
    public function forgotPassword(): View
    {
        return view('app.forgot_password');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:accounts,email'
        ], [
            'email.exists' => 'The email address does not exist.',
        ]);

        try {
            $token = Str::random(64);

            DB::table('password_reset_tokens')
                ->where('email', $request->input('email'))
                ->delete();

            DB::table('password_reset_tokens')->insert([
                'email' => $request->input('email'),
                'token' => $token,
                'created_at' => now()
            ]);

            $account = Account::query()
                ->where('email', $request->input('email'))
                ->first();

            Mail::send('app.email_templates.forgot_password',
                ['token' => $token, 'account' => $account],
                function ($message) use ($request) {
                    $message->to($request->input('email'));
                    $message->subject('Reset Password');
                });

            return back()->with('message', CoreHelper::success('We have e-mailed your password reset link!'));
        } catch (Exception $exception) {
            return redirect()
                ->back()
                ->withInput()
                ->with('message', CoreHelper::error($exception->getMessage()));
        }
    }

    /**
     * @param string $token
     * @return View
     */
    public function newPassword(string $token): View
    {
        $exist = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$exist) {
            abort(403);
        }

        return view('app.new_password', compact('token'));
    }

    /**
     * @param Request $request
     * @param string $token
     * @return RedirectResponse
     */
    public function newPasswordSave(Request $request, string $token): RedirectResponse
    {
        $request->validate([
            'password' => [
                'required',
                'string',
                Password::min(6),
                'confirmed',
            ],
        ]);

        $exist = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$exist) {
            abort(403);
        }

        try {
            DB::beginTransaction();
            Account::query()
                ->where('email', $exist->email)
                ->update([
                    'password' => Hash::make($request->input('password'))
                ]);

            DB::table('password_reset_tokens')
                ->where('token', $token)
                ->delete();

            DB::commit();
            return redirect()
                ->route('login')
                ->with('message', CoreHelper::success('Your password has been successfully changed. Please try to login.'));
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('message', CoreHelper::error($exception->getMessage()));
        }
    }
}
