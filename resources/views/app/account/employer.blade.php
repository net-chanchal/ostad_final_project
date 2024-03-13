@extends('app.layouts.master')
@section('title', 'Employers')

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
    @include('app.components.banner', ['title' => 'Employers'])
    <!--Banner End-->

    <div class="pop-servicearea pt_70 pb_70">
        <div class="container">
            <div class="row ov_hidden mt_30">
                @foreach($companies as $company)
                    @include('app.components.company.company_item')
                @endforeach
            </div>
        </div>
    </div>
@endsection