<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\JobDataTable;
use App\Helpers\CoreHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreJobRequest;
use App\Http\Requests\Admin\UpdateJobRequest;
use App\Models\Account;
use App\Models\JobAttribute;
use App\Models\JobCategory;
use App\Models\JobPost;
use App\Models\JobPostAttribute;
use App\Models\JobPostAttributeOther;
use App\Models\JobPostLocation;
use App\Models\JobPostSalary;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * @return array
     */
    private function compactData(): array
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
    /**
     * Display a listing of the resource.
     */
    public function index(JobDataTable $dataTable)
    {
        return $dataTable->render('admin.job.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.job.create', $this->compactData());
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
                'account_id' => $request->input('account_id'),
                'job_category_id' => $request->input('job_category_id'),
                'title' => $request->input('title'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description'),
                'vacancy' => $request->input('vacancy'),
                'deadline' => $request->input('deadline'),
                'status' => $request->input('status'),
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
     * Display the specified resource.
     *
     * @param JobPost $jobPost
     * @return View
     */
    public function show(JobPost $jobPost): View
    {
        $data = $this->compactData();

        $data['jobPost'] = $jobPost->load([
            'category',
            'account',
            'attributes',
            'attributeOther',
            'location',
            'salary'
        ]);

        return view('admin.job.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param JobPost $jobPost
     * @return View
     */
    public function edit(JobPost $jobPost): View
    {
        $data = $this->compactData();

        $data['jobPost'] = $jobPost->load([
            'category',
            'account',
            'attributes',
            'attributeOther',
            'location',
            'salary'
        ]);

        return view('admin.job.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateJobRequest $request
     * @param JobPost $jobPost
     * @return RedirectResponse
     */
    public function update(UpdateJobRequest $request, JobPost $jobPost): RedirectResponse
    {
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
                'account_id' => $request->input('account_id'),
                'job_category_id' => $request->input('job_category_id'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'vacancy' => $request->input('vacancy'),
                'deadline' => $request->input('deadline'),
                'status' => $request->input('status'),
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
     * Remove the specified resource from storage.
     *
     * @param JobPost $jobPost
     * @return RedirectResponse
     */
    public function destroy(JobPost $jobPost): RedirectResponse
    {
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
     * @return View
     */
    public function applies(JobPost $jobPost): View
    {
        $data = $this->compactData();

        $data['jobPost'] = $jobPost->load([
            'category',
            'account',
            'attributes',
            'attributeOther',
            'location',
            'salary',
            'jobApplies',
        ]);

        return view('admin.job.applies', $data);
    }
}
