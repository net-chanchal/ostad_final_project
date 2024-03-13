<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('app.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:accounts,email',
            'password' => [
                'required',
                'string',
                Password::min(6),
                'confirmed',
            ],
            'password_confirmation' => 'required',
        ]);

        if ($request->input('account_type') === 'Job Seeker') {
            $accountType = 'Job Seeker';
        } else {
            $accountType = 'Employer';
        }

        try {
            DB::beginTransaction();

            // New Account Create
            $account = new Account();
            $account->fill([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'account_type' => $accountType,
                'password' => Hash::make($request->input('password')),
            ]);

            $account->save();

            $accountId = $account->__get('id');

            // Address Create
            $address = new Address();
            $address->fill([
                'account_id' => $accountId,
            ]);
            $address->save();


            DB::commit();

            sleep(1);
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];

            if (Auth::guard('account')->attempt($credentials)) {
                if ($accountType === 'Employer') {
                    // Redirect Employer Dashboard
                    return redirect()->route('employer.dashboard');
                }

                // Redirect Job Seeker Dashboard
                return redirect()->route('job_seeker.dashboard');
            }

            return redirect()
                ->back()
                ->withInput();
        } catch (Exception $exception) {
            DB::rollBack();

            $message = <<<HTML
                            <div class="alert alert-danger rounded-0">{$exception->getMessage()}</div>
                        HTML;

            return redirect()
                ->back()
                ->withInput()
                ->with('message', $message);
        }
    }
}
