@extends('app.layouts.master')
@section('title', 'About Us')

@section('content')
    @include('app.components.header')

    <!--Header-Bar Start-->
    <div id="strickymenu" class="header-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-menu">
                        @include('app.components.menu')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Header-Bar End-->


    <!--Banner Start-->
    @include('app.components.banner', ['title' => 'Contact Us'])
    <!--Banner End-->
    <!--Contact Start-->
    <div class="contact-area mt_60 mb_70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    {!! session('message') !!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="contact-form mt_30">
                        <h4>Get in Touch</h4>
                        <form action="{{ route('contact_us') }}" method="post">
                            @csrf
                            <div class="form-row row mt_35">

                                <div class="form-group col-md-6">
                                    <label class="d-block">
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                               placeholder="Name" autofocus>
                                    </label>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="d-block">
                                        <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                                               placeholder="Email Address">
                                    </label>
                                </div>

                                <div class="form-group col-12">
                                    <label class="d-block">
                                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-control"
                                               placeholder="Subject">
                                    </label>
                                </div>

                                <div class="form-group col-12">
                                    <label class="d-block">
                                        <textarea class="form-control" name="message"
                                                  placeholder="Massage">{{ old('message') }}</textarea>
                                    </label>
                                </div>

                                <div class="form-group col-12">
                                    <button type="submit" class="btn btn-primary">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info contact-form mt_30">
                        <h4>Contact Info</h4>
                        <div class="contact-info-item mt_35">
                            <h5>Phone Number</h5>
                            {!! CoreHelper::getSetting('SETTING_CONTACT_PAGE_PHONE') !!}
                        </div>
                        <div class="contact-info-item mt_35">
                            <h5>E-Mail</h5>
                            {!! CoreHelper::getSetting('SETTING_CONTACT_PAGE_EMAIL') !!}
                        </div>
                        <div class="contact-info-item mt_35">
                            <h5>Address</h5>
                            {!! CoreHelper::getSetting('SETTING_CONTACT_PAGE_ADDRESS') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Contact End-->
@endsection