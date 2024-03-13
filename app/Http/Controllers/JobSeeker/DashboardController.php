<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\JobApply;
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
        $jobAppliesTotal = JobApply::query()
            ->where('account_id', '=', $this->accountId)
            ->count();

        $jobHiredTotal = JobApply::query()
            ->where('account_id', '=', $this->accountId)
            ->where('status', '=', 'Hired')->count();

        $jobRejectedTotal = JobApply::query()
            ->where('account_id', '=', $this->accountId)
            ->where('status', '=', 'Rejected')->count();

        $jobUnderReviewTotal = JobApply::query()
            ->where('account_id', '=', $this->accountId)
            ->where('status', '=', 'Under Review')->count();

        return view('job_seeker.index', compact(
            'jobAppliesTotal',
            'jobHiredTotal',
            'jobRejectedTotal',
            'jobUnderReviewTotal',
        ));
    }
}
