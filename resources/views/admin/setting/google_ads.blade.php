@extends("admin.layouts.master")
@section("title", "Google Ads")
@section("content")
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route("admin.settings") }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Google Ads</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route("admin.dashboard") }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route("admin.settings") }}">Settings</a></div>
                    <div class="breadcrumb-item">Google Ads</div>
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
                        <form action="{{ route("admin.settings.google_ads") }}" method="post" class="needs-validation" id="setting-form" novalidate="" enctype="multipart/form-data">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h4>Google Ads</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="SETTING_GOOGLE_ADS_CODE" class="form-control-label col-sm-3 mt-3 text-md-right">Google Ads Code</label>
                                        <div class="col-sm-6 col-md-9">
                                            <textarea class="form-control editor" name="SETTING_GOOGLE_ADS_CODE" id="SETTING_GOOGLE_ADS_CODE" autofocus>{{ $settings["SETTING_GOOGLE_ADS_CODE"] }}</textarea>
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

@push("css-libraries")
    <link rel="stylesheet" href="{{ asset("assets/modules/codemirror/lib/codemirror.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/modules/codemirror/theme/duotone-dark.css") }}">
@endpush

@push("js-libraries")
    <script src="{{ asset("assets/modules/codemirror/lib/codemirror.js") }}"></script>
    <script src="{{ asset("assets/modules/codemirror/mode/javascript/javascript.js") }}"></script>
@endpush

@push("scripts")
    <script>
        "use strict";
        jQuery(".editor").each(function() {
            const editor = CodeMirror.fromTextArea(this, {
                lineNumbers: true,
                theme: "duotone-dark",
                mode: "javascript",
                height: 200
            });
            editor.setSize("100%", 200);
        });
    </script>
@endpush
