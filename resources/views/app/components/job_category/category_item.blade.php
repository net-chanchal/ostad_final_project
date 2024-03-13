<div class="col-xl-3 col-lg-4 col-md-6">
    <div class="categorie-item mt_30">
        <div class="categorie-icon">
            <i class="{{ $category->icon }} fa-3x"></i>
            <h4 class="mt-2"><a href="">{{ $category->name }}</a></h4>
        </div>
        <div class="categorie-text">
            <p>{{ number_format($category->jobs_count) }} Jobs</p>
        </div>
    </div>
</div>