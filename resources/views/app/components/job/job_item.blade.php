@php use App\Helpers\ConstantHelper;use Carbon\Carbon; @endphp
<div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
    <div class="job-item">
        <div class="job-item-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="job-img">
                        @if (!empty($job->account->avatar_image) && file_exists(public_path("storage/uploads/accounts/{$job->account->avatar_image}")))
                            <img src="{{ asset("storage/uploads/accounts/{$job->account->avatar_image}") }}"
                                 width="200"
                                 alt="">
                        @else
                            <img src="{{ asset('assets/img/example-image.jpg') }}"
                                 width="200"
                                 alt="">
                        @endif
                    </div>
                    <div class="job-wrapper-text">
                        <h4>{{ $job->title }}</h4>
                        <p>{{ $job->account->name }}</p>
                        <ul>
                            <li>
                                <i class="fa fa-money"></i>
                                {{ ConstantHelper::CURRENCY_SYMBOL . number_format($job->salary->min_salary) . ($job->salary->min_salary ? ' - ' . number_format($job->salary->min_salary ): '') }}
                            </li>
                            <li>
                                <i class="fa fa-map-marker-alt"></i>
                                {{ $job->location->city ? $job->location->city->name . ', ' : '' }}
                                {{ $job->location->state ? $job->location->state->name . ', ' : '' }}
                                {{ $job->location->country ? $job->location->country->name : '' }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="job-item-btn">
                        <ul>
                            <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                            <li><a href="{{ route('jobs.detail', $job->slug) }}">Job Detail</a></li>

                            @if($job->deadline <= Carbon::now())
                                <li><a href="javascript:void(0);" class="disabled">Job Closed</a></li>
                            @else
                                @if (in_array($job->id, $applies))
                                    <li><a href="javascript:void(0);" class="disabled applied">Applied</a></li>
                                @else
                                    @auth('account')
                                        <li>
                                            <form action="{{ route('jobs.apply') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="redirect" value="{{ route('jobs.detail', $job->slug) }}">
                                                <input type="hidden" name="job_post_id" value="{{ $job->id }}">
                                                <button type="submit">Apply</button>
                                            </form>
                                        </li>
                                    @else
                                        <li><a href="{{ route('login') }}" target="_blank">Apply</a></li>
                                    @endauth
                                @endif
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="job-item-keyword">
            <ul>
                <li><i class="fa fa-tags"></i>Keywords: {{ $job->attributeOther->tags ?? '' }}</li>
            </ul>
        </div>
    </div>
</div>