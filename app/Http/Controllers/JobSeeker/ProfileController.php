<?php

namespace App\Http\Controllers\JobSeeker;

use App\Helpers\CoreHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobSeeker\UpdateAccountRequest;
use App\Models\Account;
use App\Models\Address;
use App\Models\Education;
use App\Models\Experience;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private int $accountId;
    private Authenticatable|null $account;

    public function __construct()
    {
        $this->middleware(function($request, $next) {
            $this->accountId = Auth::guard('account')->id();
            $this->account = Auth::guard('account')->user();
            return $next($request);
        });
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $account = Account::query()
            ->where('id', $this->accountId)
            ->first();
        $account = $account->load(['address', 'educations', 'experiences']);

        return view('job_seeker.account.edit', compact('account'));
    }

    public function update(UpdateAccountRequest $request)
    {
        $request->validated();

        try {
            DB::beginTransaction();

            // Delete Address
            Address::query()
                ->where('account_id', $this->accountId)
                ->delete();

            // Delete Educations
            Education::query()
                ->where('account_id', $this->accountId)
                ->delete();

            // Delete Experience
            Experience::query()
                ->where('account_id', $this->accountId)
                ->delete();

            // Account Update
            $data = [
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'phone' => $request->input('phone'),
                'gender' => $request->input('gender'),
                'date_of_birth' => $request->input('date_of_birth'),
                'is_public_profile' => $request->input('is_public_profile'),
                'description' => $request->input('description'),
            ];

            // Change New Password
            if (!empty($request->input('password'))) {
                $data['password'] = Hash::make($request->input('password'));
            }

            // Avatar Image Upload
            if ($request->hasFile('avatar_image')) {
                // Check if the old image exists and unlink it
                $oldImagePath = $this->account->__get('avatar_image');

                if ($oldImagePath && Storage::exists('public/uploads/accounts/' . $oldImagePath)) {
                    Storage::delete('public/uploads/accounts/' . $oldImagePath);
                }

                $image = $request->file('avatar_image');
                $imageName = time() . '_avatar.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/accounts', $imageName);
                $data['avatar_image'] = $imageName;
            }

            // Cover Image Upload
            if ($request->hasFile('cover_image')) {
                // Check if the old image exists and unlink it
                $oldImagePath = $this->account->__get('cover_image');

                if ($oldImagePath && Storage::exists('public/uploads/accounts/' . $oldImagePath)) {
                    Storage::delete('public/uploads/accounts/' . $oldImagePath);
                }

                $image = $request->file('cover_image');
                $imageName = time() . '_cover.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/accounts', $imageName);
                $data['cover_image'] = $imageName;
            }

            Account::query()
                ->where('id', $this->accountId)
                ->update($data);

            // Address Create
            $address = new Address();
            $address->fill([
                'account_id' => $this->accountId,
                'country_id' => $request->input('country_id'),
                'state_id' => $request->input('state_id'),
                'city_id' => $request->input('city_id'),
                'address' => $request->input('address'),
            ]);
            $address->save();

            // Experience Create
            $experiences = $request->input('experiences');
            if (!empty($experiences)) {
                foreach ($experiences as $experienceItem) {
                    $experience = new Experience();
                    $experience->fill([
                        'account_id' => $this->accountId,
                        'company' => $experienceItem['company'],
                        'position' => $experienceItem['position'],
                        'from' => $experienceItem['from'],
                        'to' => $experienceItem['to'],
                        'description' => $experienceItem['description'],
                        'status' => $experienceItem['status'] ?? 0,
                    ]);
                    $experience->save();
                }
            }

            // Education Create
            $educations = $request->input('educations');
            if (!empty($educations)) {
                foreach ($educations as $educationItem) {
                    $education = new Education();
                    $education->fill([
                        'account_id' => $this->accountId,
                        'school' => $educationItem['school'],
                        'degree' => $educationItem['degree'],
                        'from' => $educationItem['from'],
                        'to' => $educationItem['to'],
                        'description' => $educationItem['description'],
                        'status' => $educationItem['status'] ?? 0,
                    ]);
                    $education->save();
                }
            }

            DB::commit();
            return redirect()
                ->back()
                ->with('message', CoreHelper::success('Profile has been updated successfully!'));
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('message', CoreHelper::error($exception->getMessage()));
        }
    }

    /**
     * Logout
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::guard('account')->logout();
        return redirect()->route('login');
    }
}
