@php use Illuminate\Support\Facades\Auth; @endphp
@extends('app.layouts.master')
@section('title', CoreHelper::getSetting('SETTING_SITE_TITLE'))

@section('content')
    <!--Header-area Start-->
    <div class="header-area" style="background-image: url('{{ asset('app/img/slider-1.jpg') }}')">
        <div class="bg-slider"></div>
        <!--Menu-area Start-->
        <div id="strickymenu" class="menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="logo">
                            <h1>
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('storage/uploads/' .  CoreHelper::getSetting('SETTING_SITE_LOGO')) }}"
                                         width="146"
                                         alt="">
                                </a>
                            </h1>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="main-menu">
                            @include('app.components.menu')
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="header-right">
                            <ul>
                                @auth('account')
                                    <li class="ml-5">
                                        @php
                                            $user = Auth::guard('account')->user();
                                            $avatar = $user->__get('avatar_image');
                                            $avatarPath = 'storage/uploads/accounts/' . $avatar;
                                            $avatarUrl = asset($avatarPath);
                                        @endphp
                                        <a href="{{ $user->__get('account_type') == 'Employer' ? route('employer.dashboard') : route('job_seeker.dashboard') }}">
                                            <img alt="image"
                                                 src="{{ (!empty($avatar) && file_exists(public_path($avatarPath))) ? $avatarUrl : asset('assets/img/avatar/avatar-1.png') }}"
                                                 class="rounded-circle mr-1" width="35">
                                            {{ $user->__get('name') }}
                                        </a>
                                    </li>
                                @else
                                    <li><a href="{{ route('register') }}">Register</a></li>
                                    <li class="sign"><a href="{{ route('login') }}">Sign In</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-form">
            <form action="{{ route('jobs.index') }}" method="get">
                <div class="container">
                    <div class="row plr-15">
                        <div class="col-5 col-md-6 plr-0">
                            <div class="search-bar">
                                <label class="d-block">
                                    <input type="text" name="search" value="{{ request()->input('search') }}" placeholder="Job Title, Keyword" class="form-control">
                                </label>
                            </div>
                        </div>
                        <div class="col-5 col-md-5 plr-0">
                            <div class="search-bar">
                                <label class="d-block">
                                    <input type="text" name="location" value="{{ request()->input('location') }}" placeholder="Location" class="form-control">
                                </label>
                            </div>
                        </div>
                        <div class="col-2 col-md-1 plr-0">
                            <div class="search-button">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--Menu-area End-->

    <!--Company Start-->
    <div class="pop-servicearea pt_70 pb_70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headline">
                        <h2>Best Employers</h2>
                        <a href="{{ route('account.employer') }}">See All Employers</a>
                    </div>
                </div>
            </div>
            <div class="row ov_hidden mt_30">
                @foreach($topCompanies as $company)
                    @include('app.components.company.company_item')
                @endforeach
            </div>
        </div>
    </div>
    <!--Company End-->

    <!-- Popular-Business Start-->
    <div class="business-area bg-area pb_90 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headline">
                        <h2>New & Top Jobs</h2>
                        <a href="{{ route('jobs.index') }}">See More Jobs</a>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($topJobs as $job)
                    @include('app.components.job.job_item')
                @endforeach
            </div>
        </div>
    </div>
    <!-- Popular-Business End-->

    <!--Categories Start-->
    <div class="categorie-area pt_90 pb_90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headline">
                        <h2>Top Categories</h2>
                        <a href="{{ route('job_category.index') }}">View all categories</a>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($topCategories as $category)
                    @include('app.components.job_category.category_item')
                @endforeach
            </div>
        </div>
    </div>
    <!--Categories End-->

    <!--Blog Start-->
    <div class="blog-area pt_90 pb_90">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headline">
                        <h2>Recent News</h2>
                        <a href="{{ route('blogs.index') }}">View all Post</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="blog-carousel owl-carousel">
                        @foreach($blogs as $blog)
                            @include('app.components.blog.blog_item')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Blog End-->
@endsection