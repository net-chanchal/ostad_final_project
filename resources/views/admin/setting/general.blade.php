@extends("admin.layouts.master")
@section("title", "General Settings")
@section("content")
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('admin.settings.general') }}" class="btn btn-icon"><i
                                class="fas fa-arrow-left"></i></a>
                </div>
                <h1>General Settings</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route("admin.dashboard") }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route("admin.settings") }}">Settings</a></div>
                    <div class="breadcrumb-item">General</div>
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
                        <form action="{{ route("admin.settings.general") }}" method="POST" class="needs-validation"
                              id="setting-form" novalidate="" enctype="multipart/form-data">
                            @csrf
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h4>General Settings</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row align-items-center">
                                        <label for="SETTING_SITE_TITLE" class="form-control-label col-sm-3 text-md-right">Site
                                            Title *</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" name="SETTING_SITE_TITLE"
                                                   value="{{ $settings["SETTING_SITE_TITLE"] }}" class="form-control"
                                                   id="SETTING_SITE_TITLE" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <label for="SETTING_SITE_DESCRIPTION"
                                               class="form-control-label col-sm-3 text-md-right">Site Description</label>
                                        <div class="col-sm-6 col-md-9">
                                        <textarea class="form-control" name="SETTING_SITE_DESCRIPTION"
                                                  id="SETTING_SITE_DESCRIPTION">{{ $settings["SETTING_SITE_DESCRIPTION"] }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Site Logo &
                                            Favicon</label>
                                        <div class="col-sm-6 col-md-9">
                                            <div id="logo-preview" class="image-preview image-preview-custom float-lg-left"
                                                 style="background-image: url('{{ asset('storage/uploads/' . $settings["SETTING_SITE_LOGO"]) }}'); background-size: cover; background-position: center center">
                                                <label for="SETTING_SITE_LOGO" id="logo-label">Logo Light</label>
                                                <input type="file" name="SETTING_SITE_LOGO" id="SETTING_SITE_LOGO"
                                                       accept="image/*"/>
                                            </div>

                                            <div id="favicon-preview"
                                                 class="image-preview image-preview-custom float-lg-right"
                                                 style="background-image: url('{{ asset('storage/uploads/' . $settings["SETTING_SITE_FAVICON"]) }}'); background-size: cover; background-position: center center">
                                                <label for="SETTING_SITE_FAVICON" id="logo-label">Choose Favicon</label>
                                                <input type="file" name="SETTING_SITE_FAVICON" id="SETTING_SITE_FAVICON"
                                                       accept="image/*"/>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label for="SETTING_SITE_COPYRIGHT"
                                               class="form-control-label col-sm-3 text-md-right">Copyright</label>
                                        <div class="col-sm-6 col-md-9">
                                            <input type="text" name="SETTING_SITE_COPYRIGHT" class="form-control"
                                                   value="{{ $settings["SETTING_SITE_COPYRIGHT"] }}"
                                                   id="SETTING_SITE_COPYRIGHT">
                                        </div>
                                    </div>

                                    <div class="d-none form-group row align-items-center">
                                        <label for="SETTING_SITE_TIMEZONE"
                                               class="form-control-label col-sm-3 text-md-right">Timezone</label>
                                        <div class="col-sm-6 col-md-9">
                                            <select class="form-control select2" id="SETTING_SITE_TIMEZONE"
                                                    name="SETTING_SITE_TIMEZONE">
                                                <option
                                                        value="Asia/Dhaka" {{ ($settings["SETTING_SITE_TIMEZONE"] === "Asia/Dhaka"? "selected": "") }}>
                                                    Asia/Dhaka
                                                </option>
                                                <option
                                                        value="Asia/Dili" {{ ($settings["SETTING_SITE_TIMEZONE"] === "Asia/Dili"? "selected": "") }}>
                                                    Asia/Dili
                                                </option>
                                                <option
                                                        value="Asia/Dubai" {{ ($settings["SETTING_SITE_TIMEZONE"] === "Asia/Dubai"? "selected": "") }}>
                                                    Asia/Dubai
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-none form-group row align-items-center">
                                        <label for="SETTING_SITE_CURRENCY"
                                               class="form-control-label col-sm-3 text-md-right">Currency</label>
                                        <div class="col-sm-6 col-md-9">
                                            <select class="form-control" id="SETTING_SITE_CURRENCY"
                                                    name="SETTING_SITE_CURRENCY">
                                                <option
                                                        value="USD" {{ ($settings["SETTING_SITE_CURRENCY"] === "USD"? "selected": "") }}>
                                                    USD
                                                </option>
                                                <option
                                                        value="BDT" {{ ($settings["SETTING_SITE_CURRENCY"] === "BDT"? "selected": "") }}>
                                                    BDT
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-none form-group row align-items-center">
                                        <label for="SETTING_SITE_PRELOADING"
                                               class="form-control-label col-sm-3 text-md-right">Preloader Status</label>
                                        <div class="col-sm-6 col-md-9">
                                            <div class="selectgroup w-100">
                                                <label for="active" class="selectgroup-item">
                                                    <input type="radio" name="SETTING_SITE_PRELOADING" id="active" value="YES"
                                                           class="selectgroup-input" {{ ($settings["SETTING_SITE_PRELOADING"] === "YES" ? "checked" : "") }}>
                                                    <span class="selectgroup-button">Active</span>
                                                </label>
                                                <label for="inactive" class="selectgroup-item">
                                                    <input type="radio" name="SETTING_SITE_PRELOADING" id="inactive"
                                                           value="NO"
                                                           class="selectgroup-input" {{ ($settings["SETTING_SITE_PRELOADING"] === "NO" ? "checked" : "") }}>
                                                    <span class="selectgroup-button">Inactive</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="d-none form-group row align-items-center">
                                        <label class="form-control-label col-sm-3 text-md-right">
                                            Date Time Format
                                        </label>
                                        <div class="col-sm-6 col-md-5">

                                            <label for="SETTING_SITE_DATE_FORMAT" class="d-inline"></label>
                                            <select class="form-control" id="SETTING_SITE_DATE_FORMAT"
                                                    name="SETTING_SITE_DATE_FORMAT">
                                                <option
                                                        value="YYYY-MM-DD" {{ ($settings["SETTING_SITE_DATE_FORMAT"] === "YYYY-MM-DD"? "selected": "") }}>
                                                    YYYY-MM-DD
                                                </option>
                                                <option
                                                        value="DD-MM-YYYY" {{ ($settings["SETTING_SITE_DATE_FORMAT"] === "DD-MM-YYYY"? "selected": "") }}>
                                                    DD-MM-YYYY
                                                </option>
                                                <option
                                                        value="MM-DD-YYYY" {{ ($settings["SETTING_SITE_DATE_FORMAT"] === "MM-DD-YYYY"? "selected": "") }}>
                                                    MM-DD-YYYY
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <label for="SETTING_SITE_TIME_FORMAT" class="d-inline"></label>
                                            <select class="form-control" id="SETTING_SITE_TIME_FORMAT"
                                                    name="SETTING_SITE_TIME_FORMAT">
                                                <option
                                                        value="HH:MM:SS" {{ ($settings["SETTING_SITE_TIME_FORMAT"] === "HH:MM:SS"? "selected": "") }}>
                                                    HH:MM:SS
                                                </option>
                                                <option
                                                        value="HH:MM:SS tt" {{ ($settings["SETTING_SITE_TIME_FORMAT"] === "HH:MM:SS tt"? "selected": "") }}>
                                                    HH:MM:SS tt
                                                </option>
                                                <option
                                                        value="HH:MM" {{ ($settings["SETTING_SITE_TIME_FORMAT"] === "HH:MM"? "selected": "") }}>
                                                    HH:MM
                                                </option>
                                                <option
                                                        value="HH:MM tt" {{ ($settings["SETTING_SITE_TIME_FORMAT"] === "HH:MM tt"? "selected": "") }}>
                                                    HH:MM tt
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-none form-group row">
                                        <label for="SETTING_GOOGLE_ANALYTICS_CODE"
                                               class="form-control-label col-sm-3 mt-3 text-md-right">Google Analytics
                                            Code</label>
                                        <div class="col-sm-6 col-md-9">
                                        <textarea class="form-control editor" name="SETTING_GOOGLE_ANALYTICS_CODE"
                                                  id="SETTING_GOOGLE_ANALYTICS_CODE">{{ $settings["SETTING_GOOGLE_ANALYTICS_CODE"] }}</textarea>
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
    <link rel="stylesheet" href="{{ asset("assets/modules/summernote/summernote-bs4.css") }}">
@endpush

@push("js-libraries")
    <script src="{{ asset("assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js") }}"></script>
    <script src="{{ asset("assets/modules/codemirror/lib/codemirror.js") }}"></script>
    <script src="{{ asset("assets/modules/codemirror/mode/javascript/javascript.js") }}"></script>
    <script src="{{ asset("assets/modules/summernote/summernote-bs4.js") }}"></script>
@endpush

@push("scripts")
    <script>
        "use strict";

        // Google Analytics Code
        jQuery(".editor").each(function () {
            const editor = CodeMirror.fromTextArea(this, {
                lineNumbers: true,
                theme: "duotone-dark",
                mode: "javascript",
                height: 200
            });
            editor.setSize("100%", 200);
        });

        // Logo
        jQuery.uploadPreview({
            input_field: "#SETTING_SITE_LOGO",
            preview_box: "#logo-preview",
            label_field: "#logo-label",
            label_default: "Choose Logo Light",
            label_selected: "Change Logo Light",
            no_label: false,
            success_callback: null
        });

        // Favicon
        jQuery.uploadPreview({
            input_field: "#SETTING_SITE_FAVICON",
            preview_box: "#favicon-preview",
            label_field: "#favicon-label",
            label_default: "Choose Favicon",
            label_selected: "Change Favicon",
            no_label: false,
            success_callback: null
        });

        // jQuery("#SETTING_SITE_DESCRIPTION").summernote({
        //     dialogsInBody: true,
        //     height: 150,
        //     toolbar: [
        //         ['style', ['bold', 'italic', 'underline', 'clear', 'list']],
        //         ['font', ['strikethrough']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //         ['insert', ['link']],
        //     ]
        // });
    </script>
@endpush
