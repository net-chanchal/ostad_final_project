<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\AuthController as AccountAuthController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\Employer\BlogController as EmployerBlogController;
use App\Http\Controllers\Employer\PluginController as EmployerPluginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobAttributeController;
use App\Http\Controllers\Admin\JobCategoryController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Employer\JobController as EmployerJobController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Employer\AccountController as EmployerAccountController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\JobSeeker\AppliedJob;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;
use App\Http\Controllers\JobSeeker\ProfileController as JobSeekerProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// HomeController
Route::get('/', HomeController::class)->name('home');
Route::get('/about-us', AboutUsController::class)->name('about_us');
Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact_us');
Route::post('/contact-us', [ContactUsController::class, 'formSubmit'])->name('contact_us');

// RegisterController
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// LoginController
Route::get('/login', [AccountAuthController::class, 'index'])->name('login');
Route::post('/login', [AccountAuthController::class, 'login'])->name('login');

Route::get('/forgot-password', [AccountAuthController::class, 'forgotPassword'])->name('forgot_password');
Route::post('/forgot-password', [AccountAuthController::class, 'sendResetLinkEmail'])->name('forgot_password');
Route::get('/new-password/{token}', [AccountAuthController::class, 'newPassword'])->name('new_password');
Route::put('/new-password/{token}', [AccountAuthController::class, 'newPasswordSave'])->name('new_password');

// BlogController
Route::get('/blogs', [\App\Http\Controllers\BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug?}', [\App\Http\Controllers\BlogController::class, 'detail'])->name('blogs.detail');

// JobController
Route::get('/jobs', [\App\Http\Controllers\JobController::class, 'index'])->name('jobs.index');
Route::post('/jobs/apply', [\App\Http\Controllers\JobController::class, 'apply'])->name('jobs.apply');
Route::get('/jobs/{slug?}', [\App\Http\Controllers\JobController::class, 'detail'])->name('jobs.detail');

// AccountController
Route::get('/employers', [\App\Http\Controllers\AccountController::class, 'employer'])->name('account.employer');
Route::get('/employers/{id?}', [\App\Http\Controllers\AccountController::class, 'detail'])->name('account.employer');

// JobCategoryController
Route::get('/job-categories', [\App\Http\Controllers\JobCategoryController::class, 'index'])->name('job_category.index');


// AuthController
Route::get('/admin/login', [AuthController::class, 'index'])->name('admin.auth.index');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.auth.login');

// Admin Route Group
Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // AuthController
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // DashboardController
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // AccountController
    Route::get('/accounts/jobs/{account}', [AccountController::class, 'jobs'])->name('accounts.jobs');
    Route::resource('/accounts', AccountController::class);

    // JobAttributeController
    Route::resource('/job-attributes', JobAttributeController::class);

    // JobCategoryController
    Route::resource('/job-categories', JobCategoryController::class);

    // JobController
    Route::get('/jobs/applies/{job_post}', [JobController::class, 'applies'])->name('jobs.applies');
    Route::resource('/jobs', JobController::class)->parameters([
        'jobs' => 'job_post'
    ]);

    // BlogCategoryController
    Route::resource('/blog-categories', BlogCategoryController::class);

    // BlogController
    Route::resource('/blogs', BlogController::class);

    // SettingsController
    Route::get('settings', [SettingController::class, 'index'])->name('settings');

    Route::get('settings/general', [SettingController::class, 'general'])->name('settings.general');
    Route::post('settings/general', [SettingController::class, 'generalUpdate'])->name('settings.general');

    Route::get('settings/google-ads', [SettingController::class, 'googleAds'])->name('settings.google_ads');
    Route::post('settings/google-ads', [SettingController::class, 'googleAdsUpdate'])->name('settings.google_ads');

    Route::get('settings/social-urls', [SettingController::class, 'socialUrls'])->name('settings.social_urls');
    Route::post('settings/social-urls', [SettingController::class, 'socialUrlsUpdate'])->name('settings.social_urls');

    Route::get('settings/email-config', [SettingController::class, 'emailConfig'])->name('settings.email_config');
    Route::post('settings/email-config', [SettingController::class, 'emailConfigUpdate'])->name('settings.email_config');

    // PageController
    Route::get('pages/contact-us', [PageController::class, 'contactUs'])->name('pages.contact_us');
    Route::put('pages/contact-us', [PageController::class, 'contactUsUpdate'])->name('pages.contact_us');

    Route::get('pages/about-us', [PageController::class, 'aboutUs'])->name('pages.about_us');
    Route::put('pages/about-us', [PageController::class, 'aboutUsUpdate'])->name('pages.about_us');
});

// Employer Route Group
Route::group(['middleware' => 'auth.account', 'prefix' => 'employer', 'as' => 'employer.'], function () {
    // DashboardController
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');

    // AccountController
    Route::get('/logout', [EmployerAccountController::class, 'logout'])->name('account.logout');
    Route::get('/account', [EmployerAccountController::class, 'index'])->name('account.index');
    Route::put('/account', [EmployerAccountController::class, 'update'])->name('account.update');

    // JobController
    Route::put('/jobs/applies/update', [EmployerJobController::class, 'applyUpdate'])->name('jobs.applies.update');
    Route::get('/jobs/applies/{job_post}', [EmployerJobController::class, 'applies'])->name('jobs.applies');
    Route::get('/jobs/job-seeker/{account}', [EmployerJobController::class, 'jobSeeker'])->name('jobs.job_seeker');
    Route::resource('/jobs', EmployerJobController::class)->parameters([
        'jobs' => 'job_post'
    ]);

    // BlogController
    Route::resource('/blogs', EmployerBlogController::class);

    Route::get('/plugins', [EmployerPluginController::class, 'index'])->name('plugins.index');
    Route::put('/plugins', [EmployerPluginController::class, 'update'])->name('plugins.update');

});


// Job Seeker Route Group
Route::group(['middleware' => 'auth.account', 'prefix' => 'job-seeker', 'as' => 'job_seeker.'], function () {
    // DashboardController
    Route::get('/dashboard', [JobSeekerDashboardController::class, 'index'])->name('dashboard');

    // AuthController
    Route::get('/logout', [JobSeekerProfileController::class, 'logout'])->name('profile.logout');
    Route::get('/profile', [JobSeekerProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [JobSeekerProfileController::class, 'update'])->name('profile.update');

    // AppliedJob
    Route::get('/applied-jobs', [AppliedJob::class, 'index'])->name('applied_jobs.index');
});