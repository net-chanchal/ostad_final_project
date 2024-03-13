<div class="blog-item mt_30">
    @if (!empty($blog->image) && file_exists(public_path("storage/uploads/blogs/$blog->image")))
        <div class="blog-image"
             style="background-image: url('{{ asset("storage/uploads/blogs/$blog->image") }}')"></div>
    @else
        <div class="blog-image"
             style="background-image: url('{{ asset('assets/img/example-image.jpg') }}')"></div>
    @endif

    <div class="blog-text">
        <h3>{{ $blog->title }}</h3>
        <ul class="d-flex justify-content-between">
            <li><i class="fa fa-user"></i>
                {{ ucwords($blog->posted_by) }}
                <small class="text-muted">{{ $blog->account->name ?? '' }}</small>
            </li>
            <li>
                <i class="fa fa-calendar-o"></i>{{ CoreHelper::timeAgo($blog->posted_on) }}
            </li>
        </ul>
        <p>{{ CoreHelper::readMore($blog->short_description) }}</p>
        <a href="{{ route('blogs.detail', $blog->slug) }}">Read More</a>
    </div>
</div>