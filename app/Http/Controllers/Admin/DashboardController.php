<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\JobApply;
use App\Models\JobCategory;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $jobSeekersTotal = Account::query()->where('account_type', 'Job Seeker')->count();
        $employersTotal = Account::query()->where('account_type', 'Employer')->count();
        $jobCategoriesTotal = JobCategory::query()->count();
        $jobsTotal = JobPost::query()->count();
        $jobAppliesTotal = JobApply::query()->count();
        $blogCategoriesTotal = BlogCategory::query()->count();
        $blogsTotal = Blog::query()->count();
        $usersTotal = User::query()->count();

        return view('admin.index', compact(
            'jobSeekersTotal',
            'employersTotal',
            'jobCategoriesTotal',
            'jobsTotal',
            'jobAppliesTotal',
            'blogCategoriesTotal',
            'blogsTotal',
            'usersTotal',
        ));
    }
}
