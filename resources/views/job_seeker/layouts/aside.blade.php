<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('job_seeker.dashboard') }}"><img
                        src="{{ asset('storage/uploads/' .  CoreHelper::getSetting('SETTING_SITE_LOGO')) }}" width="120"
                        alt="Logo"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('job_seeker.dashboard') }}">JP</a>
        </div>
        <ul class="sidebar-menu">
            <li class={{ CoreHelper::menuActive('job_seeker.dashboard') }}>
                <a class="nav-link" href="{{ route('job_seeker.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class={{ CoreHelper::menuActive('job_seeker.profile.index') }}>
                <a class="nav-link" href="{{ route('job_seeker.profile.index') }}"><i class="fas fa-user"></i>
                    <span>Profile Update</span></a>
            </li>

            <li class={{ CoreHelper::menuActive('job_seeker.applied_jobs.index') }}>
                <a class="nav-link" href="{{ route('job_seeker.applied_jobs.index') }}"><i class="fas fa-newspaper"></i>
                    <span>Applied Jobs</span></a>
            </li>

            <li>
                <a class="nav-link" target="_blank" href="{{ route('home') }}"><i class="fas fa-globe"></i>
                    <span>Website</span></a>
            </li>
        </ul>
    </aside>
</div>