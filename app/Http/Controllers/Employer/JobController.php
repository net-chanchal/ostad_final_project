<?php

namespace App\Http\Controllers\Employer;

use App\DataTables\Employer\JobApplyDataTable;
use App\DataTables\Employer\JobDataTable;
use App\Helpers\CoreHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\StoreJobRequest;
use App\Http\Requests\Employer\UpdateJobRequest;
use App\Models\Account;
use App\Models\JobApply;
use App\Models\JobAttribute;
use App\Models\JobCategory;
use App\Models\JobPost;
use App\Models\JobPostAttribute;
use App\Models\JobPostAttributeOther;
use App\Models\JobPostLocation;
use App\Models\JobPostSalary;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class JobController extends Controller
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
     * Display a listing of the resource.
     */
    public function index(JobDataTable $dataTable)
    {
        return $dataTable->render('employer.job.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('employer.job.create', $this->compactData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)
    {
        $request->validated();

        try {
            DB::beginTransaction();

            // Table job_posts
            $jobPost = new JobPost();
            $jobPost->fill([
                'account_id' => $this->accountId,
                'job_category_id' => $request->input('job_category_id'),
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description'),
                'vacancy' => $request->input('vacancy'),
                'deadline' => $request->input('deadline'),
                'status' => 'Pending',
            ]);
            $jobPost->save();

            $jobPostId = $jobPost->__get('id');

            // Table job_post_locations
            $jobPostLocation = new JobPostLocation();
            $jobPostLocation->fill([
                'job_post_id' => $jobPostId,
                'country_id' => $request->input('country_id'),
                'state_id' => $request->input('state_id'),
                'city_id' => $request->input('city_id'),
                'address' => $request->input('address'),
            ]);
            $jobPostLocation->save();

            // Table job_post_salaries
            $jobPostSalary = new JobPostSalary();
            $jobPostSalary->fill([
                'job_post_id' => $jobPostId,
                'min_salary' => $request->input('min_salary'),
                'max_salary' => $request->input('max_salary'),
            ]);
            $jobPostSalary->save();

            $jobAttributes = $request->input('job_attributes');
            if (!empty($jobAttributes)) {
                foreach ($jobAttributes as $jobAttributeId) {
                    // Table job_post_attributes
                    $jobPostAttribute = new JobPostAttribute();
                    $jobPostAttribute->fill([
                        'job_post_id' => $jobPostId,
                        'job_attribute_id' => $jobAttributeId
                    ]);
                    $jobPostAttribute->save();
                }
            }

            // Table job_post_attribute_others
            $jobPostAttributeOther= new JobPostAttributeOther();
            $jobPostAttributeOther->fill([
                'job_post_id' => $jobPostId,
                'tags' => $request->input('tags'),
                'benefits' => $request->input('benefits'),
                'skills' => $request->input('skills'),
            ]);
            $jobPostAttributeOther->save();

            DB::commit();

            return redirect()
                ->back()
                ->with('message', CoreHelper::success('Job post has been created successfully!'));
        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('message', CoreHelper::error($exception->getMessage()));
        }
    }

    /**
     * @param JobPost $jobPost
     * @return View
     * @throws AuthorizationException
     */
    public function show(JobPost $jobPost): View
    {
        Gate::forUser($this->account)->authorize('view', $jobPost);

        $data = $this->compactData();

        $data['jobPost'] = $jobPost->load([
            'category',
            'account',
            'attributes',
            'attributeOther',
            'location',
            'salary'
        ]);

        return view('employer.job.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param JobPost $jobPost
     * @return View
     * @throws AuthorizationException
     */
    public function edit(JobPost $jobPost): View
    {
        Gate::forUser($this->account)->authorize('update', $jobPost);

        $data = $this->compactData();

        $data['jobPost'] = $jobPost->load([
            'category',
            'account',
            'attributes',
            'attributeOther',
            'location',
            'salary'
        ]);

        return view('employer.job.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateJobRequest $request
     * @param JobPost $jobPost
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateJobRequest $request, JobPost $jobPost): RedirectResponse
    {
        Gate::forUser($this->account)->authorize('update', $jobPost);

        $request->validated();

        try {
            DB::beginTransaction();

            $jobPostId = $jobPost->__get('id');

            // Delete
            JobPostLocation::query()->where('job_post_id', $jobPostId)->delete();
            JobPostSalary::query()->where('job_post_id', $jobPostId)->delete();
            JobPostAttribute::query()->where('job_post_id', $jobPostId)->delete();
            JobPostAttributeOther::query()->where('job_post_id', $jobPostId)->delete();

            // Table job_posts
            $jobPost->fill([
                'job_category_id' => $request->input('job_category_id'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'vacancy' => $request->input('vacancy'),
                'deadline' => $request->input('deadline'),
            ]);
            $jobPost->save();

            // Table job_post_locations
            $jobPostLocation = new JobPostLocation();
            $jobPostLocation->fill([
                'job_post_id' => $jobPostId,
                'country_id' => $request->input('country_id'),
                'state_id' => $request->input('state_id'),
                'city_id' => $request->input('city_id'),
                'address' => $request->input('address'),
            ]);
            $jobPostLocation->save();

            // Table job_post_salaries
            $jobPostSalary = new JobPostSalary();
            $jobPostSalary->fill([
                'job_post_id' => $jobPostId,
                'min_salary' => $request->input('min_salary'),
                'max_salary' => $request->input('max_salary'),
            ]);
            $jobPostSalary->save();

            $jobAttributes = $request->input('job_attributes');
            if (!empty($jobAttributes)) {
                foreach ($jobAttributes as $jobAttributeId) {
                    // Table job_post_attributes
                    $jobPostAttribute = new JobPostAttribute();
                    $jobPostAttribute->fill([
                        'job_post_id' => $jobPostId,
                        'job_attribute_id' => $jobAttributeId
                    ]);
                    $jobPostAttribute->save();
                }
            }

            // Table job_post_attribute_others
            $jobPostAttributeOther= new JobPostAttributeOther();
            $jobPostAttributeOther->fill([
                'job_post_id' => $jobPostId,
                'tags' => $request->input('tags'),
                'benefits' => $request->input('benefits'),
                'skills' => $request->input('skills'),
            ]);
            $jobPostAttributeOther->save();

            DB::commit();

            return redirect()
                ->back()
                ->with('message', CoreHelper::success('Job post has been updated successfully!'));
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
     * @param JobPost $jobPost
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(JobPost $jobPost): RedirectResponse
    {
        Gate::forUser($this->account)->authorize('delete', $jobPost);

        if ($jobPost->__get('status') == 'Publish') {
            return redirect()
                ->back()
                ->with('message', CoreHelper::error('The job has already been published.'));
        }

        try {
            $jobPost->delete();
            return redirect()
                ->back()
                ->with('message', CoreHelper::success('Job post has been deleted successfully!'));
        } catch (Exception $exception) {
            return redirect()
                ->back()
                ->with('message', CoreHelper::error($exception->getMessage()));
        }
    }

    /**
     * @param JobPost $jobPost
     * @return mixed
     */
    public function applies(JobPost $jobPost): mixed
    {
        if ($jobPost->__get('account_id') !== $this->accountId) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED');
        }

        $data = $this->compactData2();

        $data['jobPost'] = $jobPost->load([
            'category',
            'account',
            'attributes',
            'attributeOther',
            'location',
            'salary',
        ]);

        // This session used to breadcrumb navigation in 'employer.job.applies' view.
        Session::put('employer.jobs.applies.job_post_id', $jobPost->__get('id'));

        $dataTable = new JobApplyDataTable($jobPost->__get('id'));

        return $dataTable->render('employer.job.applies', $data);
    }

    /**
     * @param Account $account
     * @return View
     */
    public function jobSeeker(Account $account): View
    {
        $account = $account->load(['address', 'educations', 'experiences']);

        return view('employer.job.job_seeker', compact('account'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function applyUpdate(Request $request): JsonResponse
    {
        try {
            // Check Auth Verification
            $total = JobApply::query()
                ->whereHas('jobPost', function($query) {
                    $query->where('account_id', $this->accountId);
                })
                ->where('id', $request->input('job_apply_id'))
                ->count();

            if ($total === 0) {
                throw new Exception('Invalid your request.');
            }

            // Update
            JobApply::query()
                ->where('id', $request->input('job_apply_id'))
                ->update([
                    'interview_date' => $request->input('interview_date'),
                    'status' => $request->input('status'),
                ]);

            $response = [
                'success' => true,
                'message' => CoreHelper::success('Saved successfully'),
                'error' => null,
            ];
        } catch (Exception $exception) {
            $response = [
                'success' => false,
                'message' => CoreHelper::error('Save Failed'),
                'error' => [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ],
            ];
        }

        return response()->json($response);
    }

    /**
     * @return array
     */
    private function compactData(): array
    {
        $jobCategories = JobCategory::query()
            ->where('status', '=', 1)
            ->orderBy('name')
            ->get();

        $jobAttributes = JobAttribute::query()
            ->where('status', '=', 1)
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return compact('jobCategories', 'jobAttributes');
    }

    /**
     * @return array
     */
    private function compactData2(): array
    {
        $employerAccounts = Account::query()
            ->where('account_type', '=', 'Employer')
            ->where('status', '=', 'Approved')
            ->orderBy('name')
            ->get();

        $jobCategories = JobCategory::query()
            ->where('status', '=', 1)
            ->orderBy('name')
            ->get();

        $jobAttributes = JobAttribute::query()
            ->where('status', '=', 1)
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return compact('employerAccounts', 'jobCategories', 'jobAttributes');
    }
}
