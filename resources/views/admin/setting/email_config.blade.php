@extends("admin.layouts.master")
@section("title", "Contact Address")
@section("content")
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route("admin.settings") }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Contact Address</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route("admin.dashboard") }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route("admin.settings") }}">Settings</a></div>
                    <div class="breadcrumb-item">Contact Address</div>
                </div>
            </div>

            {!! session("message") !!}

            <div class="section-body">
                <div id="output-status"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Jump To</h4>
                            </div>
                            <div class="card-body">
                                @include("admin.setting.nav")
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <form action="{{ route("admin.settings.email_config") }}" method="POST" class="needs-validation"
                              id="setting-form" novalidate="" enctype="multipart/form-data">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h4>Email Config</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row align-items-center">
                                        <label for="SETTING_EMAIL_CONFIG_EMAIL_ADDRESS"
                                               class="form-control-label col-sm-3 text-md-right">Email Address</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" name="SETTING_EMAIL_CONFIG_EMAIL_ADDRESS"
                                                   value="{{ $settings["SETTING_EMAIL_CONFIG_EMAIL_ADDRESS"] }}"
                                                   class="form-control"
                                                   id="SETTING_EMAIL_CONFIG_EMAIL_ADDRESS" autofocus>
                                            <small class="text-muted mt-2">Mail From and Received Address</small>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="form-group row align-items-center">
                                        <label for=""
                                               class="form-control-label col-sm-3 text-md-right">SMTP Host</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" class="form-control" id="" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label for=""
                                               class="form-control-label col-sm-3 text-md-right">SMTP Username</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" class="form-control" id="" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label for=""
                                               class="form-control-label col-sm-3 text-md-right">SMTP Password</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" class="form-control" id="" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label for=""
                                               class="form-control-label col-sm-3 text-md-right">SMTP Port</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="number" class="form-control" id="" disabled>
                                        </div>
                                    </div>

                                    <div class="alert alert-warning rounded-0">Currently only SMTP is allowed in <strong>.env</strong></div>
                                </div>

                                <div class="card-footer bg-whitesmoke text-md-right">
                                    <button class="btn btn-primary" id="save-btn">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
