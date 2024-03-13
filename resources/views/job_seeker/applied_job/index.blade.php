@extends('job_seeker.layouts.master')
@section('title', 'Applied Jobs')
@section("content")
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Applied Jobs</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route("job_seeker.dashboard") }}">Dashboard</a></div>
                    <div class="breadcrumb-item active">Applied Jobs</div>
                </div>
            </div>

            {!! session('message') !!}

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush