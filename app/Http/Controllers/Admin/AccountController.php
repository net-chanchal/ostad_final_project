<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AccountDataTable;
use App\DataTables\Admin\AccountJobDataTable;
use App\Helpers\CoreHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAccountRequest;
use App\Http\Requests\Admin\UpdateAccountRequest;
use App\Models\Account;
use App\Models\Address;
use App\Models\Education;
use App\Models\Experience;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AccountDataTable $dataTable
     * @return mixed
     */
    public function index(AccountDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.account.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  View
     */
    public function create(): View
    {
        return view('admin.account.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAccountRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAccountRequest $request): RedirectResponse
    {
        $request->validated();

        try {
            DB::beginTransaction();

            // New Account Create
            $account = new Account();
            $account->fill([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'account_type' => $request->input('account_type'),
                'is_public_profile' => $request->input('is_public_profile'),
                'password' => Hash::make($request->input('password')),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
            ]);

            if ($request->input('account_type') == 'Job Seeker') {
                $account->setAttribute('gender', $request->input('gender'));
                $account->setAttribute('date_of_birth', $request->input('date_of_birth'));
            }

            if ($request->input('account_type') == 'Employer') {
                $account->setAttribute('plugins', $request->input('plugins') ? implode(',', $request->input('plugins')) : null);
            }

            // Avatar Image Upload
            if ($request->hasFile('avatar_image')) {
                $image = $request->file('avatar_image');
                $imageName = time() . '_avatar.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/accounts', $imageName);
                $account->setAttribute('avatar_image', $imageName);
            }

            // Cover Image Upload
            if ($request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                $imageName = time() . '_cover.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/accounts', $imageName);
                $account->setAttribute('cover_image', $imageName);
            }

            $account->save();
            $accountId = $account->__get('id');

            // Address Create
            $address = new Address();
            $address->fill([
                'account_id' => $accountId,
                'country_id' => $request->input('country_id'),
                'state_id' => $request->input('state_id'),
                'city_id' => $request->input('city_id'),
                'address' => $request->input('address'),
            ]);
            $address->save();

            // Experience and Education only for Job Seeker
            if ($request->input('account_type') === 'Job Seeker') {
                // Experience Create
                $experiences = $request->input('experiences');
                if (!empty($experiences)) {
                    foreach ($experiences as $experienceItem) {
                        $experience = new Experience();
                        $experience->fill([
                            'account_id' => $accountId,
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
                            'account_id' => $accountId,
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
            }

            DB::commit();
            return redirect()
                ->back()
                ->with('message', CoreHelper::success('Account has been created successfully!'));
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('message', CoreHelper::error($exception->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @return View
     */
    public function show(Account $account): View
    {
        $account = $account->load(['address', 'educations', 'experiences']);

        return view('admin.account.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Account $account
     * @return View
     */
    public function edit(Account $account): View
    {
        $account = $account->load(['address', 'educations', 'experiences']);

        return view('admin.account.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAccountRequest $request
     * @param Account $account
     * @return RedirectResponse
     */
    public function update(UpdateAccountRequest $request, Account $account): RedirectResponse
    {
        $request->validated();

        try {
            DB::beginTransaction();

            // Delete Address
            Address::query()
                ->where('account_id', $account->__get('id'))
                ->delete();

            // Delete Educations
            Education::query()
                ->where('account_id', $account->__get('id'))
                ->delete();

            // Delete Experience
            Experience::query()
                ->where('account_id', $account->__get('id'))
                ->delete();

            // Account Update
            $account->fill([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'account_type' => $request->input('account_type'),
                'is_public_profile' => $request->input('is_public_profile'),
                'password' => Hash::make($request->input('password')),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
            ]);

            if ($request->input('account_type') == 'Job Seeker') {
                $account->setAttribute('gender', $request->input('gender'));
                $account->setAttribute('date_of_birth', $request->input('date_of_birth'));
            }

            if ($request->input('account_type') == 'Employer') {
                $account->setAttribute('plugins', $request->input('plugins') ? implode(',', $request->input('plugins')) : null);
            }

            // Change New Password
            if (!empty($request->input('password'))) {
                $account->setAttribute('password', Hash::make($request->input('password')));
            }

            // Avatar Image Upload
            if ($request->hasFile('avatar_image')) {
                // Check if the old image exists and unlink it
                $oldImagePath = $account->__get('avatar_image');

                if ($oldImagePath && Storage::exists('public/uploads/accounts/' . $oldImagePath)) {
                    Storage::delete('public/uploads/accounts/' . $oldImagePath);
                }

                $image = $request->file('avatar_image');
                $imageName = time() . '_avatar.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/accounts', $imageName);
                $account->setAttribute('avatar_image', $imageName);
            }

            // Cover Image Upload
            if ($request->hasFile('cover_image')) {
                // Check if the old image exists and unlink it
                $oldImagePath = $account->__get('cover_image');

                if ($oldImagePath && Storage::exists('public/uploads/accounts/' . $oldImagePath)) {
                    Storage::delete('public/uploads/accounts/' . $oldImagePath);
                }

                $image = $request->file('cover_image');
                $imageName = time() . '_cover.' . $image->getClientOriginalExtension();
                $image->storeAs('public/uploads/accounts', $imageName);
                $account->setAttribute('cover_image', $imageName);
            }

            $account->save();
            $accountId = $account->__get('id');

            // Address Create
            $address = new Address();
            $address->fill([
                'account_id' => $accountId,
                'country_id' => $request->input('country_id'),
                'state_id' => $request->input('state_id'),
                'city_id' => $request->input('city_id'),
                'address' => $request->input('address'),
            ]);
            $address->save();

            // Experience and Education only for Job Seeker
            if ($request->input('account_type') === 'Job Seeker') {
                // Experience Create
                $experiences = $request->input('experiences');
                if (!empty($experiences)) {
                    foreach ($experiences as $experienceItem) {
                        $experience = new Experience();
                        $experience->fill([
                            'account_id' => $accountId,
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
                            'account_id' => $accountId,
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
            }

            DB::commit();
            return redirect()
                ->back()
                ->with('message', CoreHelper::success('Account has been updated successfully!'));
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('message', CoreHelper::error($exception->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Account $account
     * @return RedirectResponse
     */
    public function destroy(Account $account): RedirectResponse
    {
        try {
            // avatar_image
            $imagePath = $account->__get('avatar_image');

            if ($imagePath && Storage::exists('public/uploads/accounts/' . $imagePath)) {
                Storage::delete('public/uploads/accounts/' . $imagePath);
            }

            // cover_image
            $imagePath = $account->__get('cover_image');

            if ($imagePath && Storage::exists('public/uploads/accounts/' . $imagePath)) {
                Storage::delete('public/uploads/accounts/' . $imagePath);
            }

            $account->delete();

            return redirect()->back()->with('message', CoreHelper::success('Account has been deleted successfully!'));
        } catch (Exception $exception) {
            return redirect()
                ->back()
                ->with('message', CoreHelper::error($exception->getMessage()));
        }
    }

    public function jobs(Account $account)
    {
        $dataTable = new AccountJobDataTable($account->__get('id'));

        return $dataTable->render('admin.account.jobs', compact('account'));
    }
}
