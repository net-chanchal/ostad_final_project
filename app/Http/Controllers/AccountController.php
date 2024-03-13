<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\JobApply;
use App\Models\JobPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * @return View
     */
    public function employer(): View
    {
        $companies = Account::query()->withCount('jobs')
            ->where('status', '=', 'Approved')
            ->where('account_type', 'Employer')
            ->orderByDesc('jobs_count')
            ->get();

        return view('app.account.employer', compact('companies'));
    }

    /**
     * @param string $id
     * @return View
     */
    public function detail(string $id): View
    {
        $employer = Account::with(['address', 'educations', 'experiences', 'jobs'])
            ->where('status', '=', 'Approved')
            ->where('account_type', '=', 'Employer')
            ->where('id', '=', $id)
            ->firstOrFail();

        $jobs = JobPost::with([
            'category',
            'account',
            'attributes',
            'attributeOther',
            'location',
            'salary'
        ])
            ->orderByDesc('created_at')
            ->where('account_id', '=', $id)
            ->where('status', '=', 'Publish')
            ->get();

        $applies = [];

        $accountId = Auth::guard('account')->id();
        if ($accountId) {
            // JobSeeker Applies Job Posts
            $applies = JobApply::query()
                ->where('account_id', $accountId)
                ->pluck('job_post_id')->toArray();
        }

        return view('app.account.employer_detail', compact('employer', 'jobs', 'applies'));
    }
}
