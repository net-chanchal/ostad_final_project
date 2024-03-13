<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use Illuminate\View\View;

class JobCategoryController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $categories = JobCategory::query()->withCount('jobs')
            ->where('status', '=', 1)
            ->orderByDesc('name')
            ->get();

        return view('app.job_category.index', compact('categories'));
    }
}
