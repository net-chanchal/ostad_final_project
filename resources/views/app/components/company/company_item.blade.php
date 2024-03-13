<div class="col-lg-3 col-md-4 col-sm-6 wow fadeInDown" data-wow-delay="0.2s">
    <div class="pop-service-item">
        <a href="{{ route('account.employer', $company->id) }}">
            @if (!empty($company->avatar_image) && file_exists(public_path("storage/uploads/accounts/$company->avatar_image")))
                <img src="{{ asset("storage/uploads/accounts/$company->avatar_image") }}"
                     alt="">
            @else
                <img src="{{ asset('assets/img/example-image.jpg') }}"
                     alt="">
            @endif
            <div class="pop-service-text flex">
                <span class="up-arrow"></span>
                <h5>{{ $company->name }}</h5>
                <p>{{ number_format($company->jobs_count) }} Jobs</p>
            </div>
        </a>
    </div>
</div>