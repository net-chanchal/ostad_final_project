<?php

namespace App\Http\Controllers;

use App\Helpers\CoreHelper;
use App\Models\JobApply;
use App\Models\JobAttribute;
use App\Models\JobCategory;
use App\Models\JobPost;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $jobs = JobPost::with([
            'category',
            'account',
            'attributes',
            'attributeOther',
            'location',
            'salary'
        ]);

        // Filter Jobs
        if (!empty($request->all())) {

            // Filter by title and tags
            $search = $request->input('search');
            if ($search) {
                $jobs->where('title', 'like', "%$search%");

                $jobs->orWhereHas('attributeOther', function ($query) use ($search) {
                    $query->where('tags', 'like', "%$search%");
                });
            }

            // Filter by location
            $location = $request->input('location');
            if ($location) {
                $jobs->orWhereHas('location', function ($query) use ($location) {
                    $query->where('address', 'like', "%$location%");
                });

                $jobs->orWhereHas('location.country', function ($query) use ($location) {
                    $query->where('name', 'like', "%$location%");
                });

                $jobs->orWhereHas('location.state', function ($query) use ($location) {
                    $query->where('name', 'like', "%$location%");
                });

                $jobs->orWhereHas('location.city', function ($query) use ($location) {
                    $query->where('name', 'like', "%$location%");
                });
            }

            // Filter by Attribute
            $job_type = $request->input('job_type');
            $salary_type = $request->input('salary_type');
            $experience = $request->input('experience');
            $job_role = $request->input('job_role');

            $jobs->whereHas('attributes.attribute', function ($query) use ($job_type) {
                if ($job_type) {
                    $query->where('name', '=', $job_type);
                }
            });

            $jobs->whereHas('attributes.attribute', function ($query) use ($salary_type) {
                if ($salary_type) {
                    $query->where('name', '=', $salary_type);
                }
            });

            $jobs->whereHas('attributes.attribute', function ($query) use ($experience) {
                if ($experience) {
                    $query->where('name', '=', $experience);
                }
            });

            $jobs->whereHas('attributes.attribute', function ($query) use ($job_role) {
                if ($job_role) {
                    $query->where('name', '=', $job_role);
                }
            });

            // Filter By Category
            $category = $request->input('category');
            if ($category) {
                $jobs->whereHas('category', function ($query) use ($category) {
                    $query->where('name', '=', $category);
                });
            }
        }

        $jobs->orderByDesc('created_at');
        $jobs = $jobs->paginate(10);

        $categories = $this->jobCategories();
        $applies = $this->applies();
        $jobAttributes = $this->jobAttributes();

        return view('app.job.index', compact('jobs', 'categories', 'applies', 'jobAttributes'));
    }

    /**
     * @param string $slug
     * @return View
     */
    public function detail(string $slug): View
    {
        $job = JobPost::with([
            'category',
            'account',
            'attributes',
            'attributeOther',
            'location',
            'salary'
        ])->where('slug', $slug)->firstOrFail();

        $accountId = Auth::guard('account')->id();

        $applies = [];

        if ($accountId) {
            // JobSeeker Applies Job Posts
            $applies = JobApply::query()
                ->where('account_id', $accountId)
                ->pluck('job_post_id')->toArray();
        }

        return view('app.job.detail', compact('job', 'applies'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function apply(Request $request): RedirectResponse
    {
        $accountId = Auth::guard('account')->id();

        if ($accountId == null) {
            abort(401);
        }

        // Employer apply not allowed
        if (Auth::guard('account')->user()->__get('account_type') == 'Employer') {
            abort(401);
        }

        try {
            JobApply::query()
                ->insert([
                    'account_id' => $accountId,
                    'job_post_id' => $request->input('job_post_id'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            $message = CoreHelper::success('Your application has been successfully submitted!');
        } catch (Exception $exception) {
            $message = CoreHelper::error($exception->getMessage());
        }

        return redirect($request->input('redirect'))
            ->with('message', $message);
    }

    /**
     * @return Builder[]|Collection
     */
    private function jobCategories(): Builder|Collection
    {
        return JobCategory::query()
            ->withCount('jobs')
            ->where('status', '=', 1)
            ->orderBy('name')
            ->get();
    }

    /**
     * @return array
     */
    private function applies(): array
    {
        $accountId = Auth::guard('account')->id();

        if ($accountId) {
            // JobSeeker Applies Job Posts
            return JobApply::query()
                ->where('account_id', $accountId)
                ->pluck('job_post_id')->toArray();
        }

        return [];
    }

    /**
     * @return Builder[]|Collection
     */
    private function jobAttributes(): Builder|Collection
    {
        return JobAttribute::query()
            ->where('status', '=', 1)
            ->orderBy('type')
            ->orderBy('name')
            ->get();
    }
}