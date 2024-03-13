<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\JobPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private int $accountId;

    public function __construct()
    {
        $this->middleware(function($request, $next) {
            $this->accountId = Auth::guard('account')->id();
            return $next($request);
        });
    }
    /**
     * @return View
     */
    public function index(): View
    {
        $jobsTotal = JobPost::query()->where('account_id', '=', $this->accountId)->count();
        $jobAppliesTotal = JobPost::query()->withCount('jobApplies')
            ->where('account_id', '=', $this->accountId)->pluck('job_applies_count')->sum();

        $blogCategoriesTotal = BlogCategory::query()->count();
        $blogsTotal = Blog::query()->where('account_id', '=', $this->accountId)->count();


        return view('employer.index', compact(
            'jobsTotal',
            'jobAppliesTotal',
            'blogCategoriesTotal',
            'blogsTotal'
        ));
    }
}
