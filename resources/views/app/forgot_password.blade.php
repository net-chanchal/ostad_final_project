@extends('app.layouts.master')
@section('title', 'Forgot Password')

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

    @include('app.components.banner', ['title' => 'Forgot Password'])


    <div class="login-area bg-area pt_60 pb_70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    {!! session('message') !!}

                    <div class="login-form">
                        <form action="{{ route('forgot_password') }}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group mt_25">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control" autofocus>
                                    @error('email')
                                    <div class="text-danger text-right">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt_25">
                                    <button type="submit" class="btn">Forgot Password</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="forgot-link">
                                    <a href="{{ route('login') }}">Login?</a>
                                </div>
                            </div>
                            <div class="col-md-6 align-right">
                                <div class="forgot-link">
                                    <a href="{{ route('register') }}">Don't have an account, sign up!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection