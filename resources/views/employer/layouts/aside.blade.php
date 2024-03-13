<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('employer.dashboard') }}"><img
                        src="{{ asset('storage/uploads/' .  CoreHelper::getSetting('SETTING_SITE_LOGO')) }}" width="120"
                        alt="Logo"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('employer.dashboard') }}">JP</a>
        </div>
        <ul class="sidebar-menu">
            <li class={{ CoreHelper::menuActive('employer.dashboard') }}>
                <a class="nav-link" href="{{ route('employer.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class={{ CoreHelper::menuActive('employer.account.index') }}>
                <a class="nav-link" href="{{ route('employer.account.index') }}"><i class="fas fa-user"></i>
                    <span>Account Update</span></a>
            </li>

            <li class={{ CoreHelper::menuActive([
                                        'employer.jobs.index',
                                        'employer.jobs.create',
                                        'employer.jobs.show',
                                        'employer.jobs.edit',

                                        'employer.jobs.applies',
                                        'employer.jobs.job_seeker',
                                    ]) }}>
                <a class="nav-link" href="{{ route('employer.jobs.index') }}"><i class="fas fa-list"></i>
                    <span>Jobs</span></a>
            </li>

            @can('employer.blogs')
            <li class={{ CoreHelper::menuActive([
                                        'employer.blogs.index',
                                        'employer.blogs.create',
                                        'employer.blogs.show',
                                        'employer.blogs.edit',
                                    ]) }}>
                <a class="nav-link" href="{{ route('employer.blogs.index') }}"><i class="fas fa-newspaper"></i>
                    <span>Blogs</span></a>
            </li>
            @endcan

            <li class={{ CoreHelper::menuActive([
                                        'employer.plugins.index',
                                    ]) }}>
                <a class="nav-link" href="{{ route('employer.plugins.index') }}"><i class="fas fa-plug"></i>
                    <span>Plugins</span></a>
            </li>

            <li>
                <a class="nav-link" target="_blank" href="{{ route('home') }}"><i class="fas fa-globe"></i>
                    <span>Website</span></a>
            </li>
        </ul>
    </aside>
</div>