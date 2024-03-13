@extends('app.layouts.master')
@section('title', 'Register')

@section('content')
    @include('app.components.header')

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

    @include('app.components.banner', ['title' => 'Register'])

    <div class="login-area pt_50 pb_70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    {!! session('message') !!}
                    <div class="login-form mt_30">
                        <form action="{{ route('register') }}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group mt_25">
                                    <div class="register-account-type">
                                        <input type="radio" id="job_seeker" name="account_type" value="Job Seeker"
                                               class="account-type" @checked(old('account_type', 'Job Seeker'))>
                                        <label for="job_seeker">Job Seeker</label>

                                        <input type="radio" id="employer" name="account_type" value="Employer"
                                               class="account-type">
                                        <label for="employer">Employer</label>
                                    </div>

                                </div>
                                <div class="form-group mt_25">
                                    <label for="name">Your Name *</label>
                                    <input type="text" name="name" value="{{ old('name') }}" id="name"
                                           class="form-control" autofocus>
                                    @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mt_25">
                                    <label for="email">Email Address *</label>
                                    <input type="email" name="email" value="{{ old('email') }}" id="email"
                                           class="form-control">
                                    @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mt_25">
                                    <label for="password">Password *</label>
                                    <input type="password" name="password" value="" id="password"
                                           class="form-control">
                                    @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mt_25">
                                    <label for="password_confirmation">Confirm Password *</label>
                                    <input type="password" name="password_confirmation" value="" id="password_confirmation"
                                           class="form-control">
                                    @error('password_confirmation')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mt_25">
                                    <button type="submit" class="btn">Register</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="forgot-link center">
                                    <a href="{{ route('login') }}">Already have an account, login here!</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning rounded-0 mt-4">
                        Cannot use the same email to Job Seekers and Employer account.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.account-type').on('change', function() {
           const accountType = $(this).val();

           if (accountType === 'Employer') {
               $('label[for="name"]').text('Company Name');
           } else {
               $('label[for="name"]').text('Your Name');
           }
        });
    </script>
@endpush