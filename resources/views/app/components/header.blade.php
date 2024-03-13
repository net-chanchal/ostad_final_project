@php use Illuminate\Support\Facades\Auth; @endphp
<div class="header-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="logo">
                    <h1>
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('storage/uploads/' .  CoreHelper::getSetting('SETTING_SITE_LOGO')) }}"
                                 width="150"
                                 alt="">
                        </a>
                    </h1>
                </div>
            </div>
            <div class="col-lg-6">
                <form action="{{ route('jobs.index') }}" method="get">
                    <div class="row search-box-page plr-15">
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
                </form>
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