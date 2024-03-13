<?php

namespace App\Http\Controllers\JobSeeker;

use App\DataTables\JobSeeker\AppliedJobDataTable;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AppliedJob extends Controller
{
    /**
     * @param AppliedJobDataTable $dataTable
     * @return mixed
     */
    public function index(AppliedJobDataTable $dataTable): mixed
    {
        return $dataTable->render('job_seeker.applied_job.index');
    }
}
