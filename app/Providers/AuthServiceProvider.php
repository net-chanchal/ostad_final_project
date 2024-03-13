<?php

namespace App\Providers;

use App\Helpers\ConstantHelper;
use App\Models\Blog;
use App\Models\JobPost;
use App\Policies\Employer\JobPolicy AS EmployerJobPolicy;
use App\Policies\Employer\BlogPolicy AS EmployerBlogPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        JobPost::class => EmployerJobPolicy::class,
        Blog::class => EmployerBlogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('employer.blogs', function () {
            $account = Auth::guard('account')->user();
            $plugins = explode(',', $account->__get('plugins'));

            $BLOG_PLUGIN = ConstantHelper::PLUGINS[0]; // 0 index is 'Blog' Plugin

            return in_array($BLOG_PLUGIN, $plugins);
        });
    }
}
