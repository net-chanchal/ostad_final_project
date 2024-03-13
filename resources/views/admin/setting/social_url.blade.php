@extends("admin.layouts.master")
@section("title", "Social URLs")
@section("content")
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route("admin.settings") }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Social URLs</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route("admin.dashboard") }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route("admin.settings") }}">Settings</a></div>
                    <div class="breadcrumb-item">Social URLs</div>
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
                        <form action="{{ route("admin.settings.social_urls") }}" method="POST" class="needs-validation"
                              id="setting-form" novalidate="" enctype="multipart/form-data">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h4>Social URLs</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row align-items-center">
                                        <label for="SETTING_SOCIAL_FACEBOOK"
                                               class="form-control-label col-sm-3 text-md-right">Facebook URL</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" name="SETTING_SOCIAL_FACEBOOK"
                                                   value="{{ $settings["SETTING_SOCIAL_FACEBOOK"] }}" class="form-control"
                                                   id="SETTING_SOCIAL_FACEBOOK" autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label for="SETTING_SOCIAL_YOUTUBE"
                                               class="form-control-label col-sm-3 text-md-right">Youtube URL</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" name="SETTING_SOCIAL_YOUTUBE"
                                                   value="{{ $settings["SETTING_SOCIAL_YOUTUBE"] }}" class="form-control"
                                                   id="SETTING_SOCIAL_YOUTUBE" autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label for="SETTING_SOCIAL_INSTAGRAM"
                                               class="form-control-label col-sm-3 text-md-right">Instagram URL</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" name="SETTING_SOCIAL_INSTAGRAM"
                                                   value="{{ $settings["SETTING_SOCIAL_INSTAGRAM"] }}" class="form-control"
                                                   id="SETTING_SOCIAL_INSTAGRAM" autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label for="SETTING_SOCIAL_LINKEDIN"
                                               class="form-control-label col-sm-3 text-md-right">Linkedin URL</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" name="SETTING_SOCIAL_LINKEDIN"
                                                   value="{{ $settings["SETTING_SOCIAL_LINKEDIN"] }}" class="form-control"
                                                   id="SETTING_SOCIAL_LINKEDIN" autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label for="SETTING_SOCIAL_TWITTER"
                                               class="form-control-label col-sm-3 text-md-right">Twitter URL</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" name="SETTING_SOCIAL_TWITTER"
                                                   value="{{ $settings["SETTING_SOCIAL_TWITTER"] }}" class="form-control"
                                                   id="SETTING_SOCIAL_TWITTER" autofocus>
                                        </div>
                                    </div>
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
