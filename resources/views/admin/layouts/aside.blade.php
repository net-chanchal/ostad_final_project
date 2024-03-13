<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('storage/uploads/' .  CoreHelper::getSetting('SETTING_SITE_LOGO')) }}" width="120" alt="Logo"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">JP</a>
        </div>
        <ul class="sidebar-menu">
            <li class={{ CoreHelper::menuActive('admin.dashboard') }}>
                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="{{ CoreHelper::menuActive([
                                'admin.settings',
                                'admin.settings.general',
                                'admin.settings.google_ads',
                                'admin.settings.social_urls',
                                'admin.settings.contact_address',
                            ]) }}">
                <a class="nav-link" href="{{ route('admin.settings') }}"><i class="fas fa-cogs"></i> <span>Settings</span></a>
            </li>
            <li class="dropdown {{ CoreHelper::menuActive([
                                        'admin.accounts.index',
                                        'admin.accounts.create',
                                        'admin.accounts.edit',
                                        'admin.accounts.show',

                                        'admin.job-attributes.index',
                                        'admin.job-attributes.create',
                                        'admin.job-attributes.edit',
                                        'admin.job-attributes.show',

                                        'admin.job-categories.index',
                                        'admin.job-categories.create',
                                        'admin.job-categories.edit',
                                        'admin.job-categories.show',

                                        'admin.jobs.index',
                                        'admin.jobs.create',
                                        'admin.jobs.edit',
                                        'admin.jobs.show',

                                        'admin.accounts.jobs',
                                        'admin.jobs.applies',
                                    ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Job Board</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ CoreHelper::menuActive([
                                        'admin.accounts.index',
                                        'admin.accounts.create',
                                        'admin.accounts.edit',
                                        'admin.accounts.show',

                                        'admin.accounts.jobs',
                                    ]) }}">
                        <a class="nav-link" href="{{ route('admin.accounts.index') }}">Accounts</a>
                    </li>
                    <li class="{{ CoreHelper::menuActive([
                                        'admin.job-attributes.index',
                                        'admin.job-attributes.create',
                                        'admin.job-attributes.edit',
                                        'admin.job-attributes.show',
                                    ]) }}">
                        <a class="nav-link" href="{{ route('admin.job-attributes.index') }}">Job Attributes</a>
                    </li>
                    <li class="{{ CoreHelper::menuActive([
                                        'admin.job-categories.index',
                                        'admin.job-categories.create',
                                        'admin.job-categories.edit',
                                        'admin.job-categories.show',
                                    ]) }}">
                        <a class="nav-link" href="{{ route('admin.job-categories.index') }}">Job Categories</a>
                    </li>
                    <li class="{{ CoreHelper::menuActive([
                                        'admin.jobs.index',
                                        'admin.jobs.create',
                                        'admin.jobs.edit',
                                        'admin.jobs.show',

                                        'admin.jobs.applies',
                                    ]) }}">
                        <a class="nav-link" href="{{ route('admin.jobs.index') }}">Jobs</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown {{ CoreHelper::menuActive([
                                        'admin.blog-categories.index',
                                        'admin.blog-categories.create',
                                        'admin.blog-categories.edit',
                                        'admin.blog-categories.show',

                                        'admin.blogs.index',
                                        'admin.blogs.create',
                                        'admin.blogs.edit',
                                        'admin.blogs.show',
                                    ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-newspaper"></i> <span>Blogs</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ CoreHelper::menuActive([
                                        'admin.blog-categories.index',
                                        'admin.blog-categories.create',
                                        'admin.blog-categories.edit',
                                        'admin.blog-categories.show',
                                    ]) }}">
                        <a class="nav-link" href="{{ route('admin.blog-categories.index') }}">Categories</a>
                    </li>
                    <li class="{{ CoreHelper::menuActive([
                                        'admin.blogs.index',
                                        'admin.blogs.create',
                                        'admin.blogs.edit',
                                        'admin.blogs.show',
                                    ]) }}">
                        <a class="nav-link" href="{{ route('admin.blogs.index') }}">Posts</a>
                    </li>
                </ul>
            </li>

            <li class="{{ CoreHelper::menuActive([
                                'admin.pages.contact_us',
                                'admin.pages.about_us',
                            ]) }}">
                <a class="nav-link" href="{{ route('admin.pages.contact_us') }}"><i class="fas fa-file"></i> <span>Pages</span></a>
            </li>
        </ul>
    </aside>
</div>