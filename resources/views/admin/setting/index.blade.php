@extends("admin.layouts.master")
@section("title", "Settings")
@section("content")
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Settings</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route("admin.dashboard") }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Settings</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="h-75 card card-large-icons">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="card-body">
                                <h4>General</h4>
                                <p>General settings such as, site title, description and etc.</p>
                                <a href="{{ route("admin.settings.general") }}" class="card-cta">Change Setting <i
                                            class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="h-75 card card-large-icons">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="card-body">
                                <h4>Google Ads</h4>
                                <p>Google ads code</p>
                                <a href="{{ route("admin.settings.google_ads") }}" class="card-cta">Change Setting <i
                                            class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="h-75 card card-large-icons">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="card-body">
                                <h4>Social URLs</h4>
                                <p>Facebook, Youtube, Linkedin, Twitter, ...</p>
                                <a href="{{ route("admin.settings.social_urls") }}" class="card-cta">Change Setting <i
                                            class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="h-75 card card-large-icons">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="card-body">
                                <h4>Email Config</h4>
                                <p>Mail, SMTP, Email.</p>
                                <a href="{{ route("admin.settings.email_config") }}" class="card-cta">Change Setting <i
                                            class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
