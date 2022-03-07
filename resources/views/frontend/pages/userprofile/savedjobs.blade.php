@extends('frontend.layouts.master')
@section('content')
<section class="recent">
    <div class="container">
        <h5>Your Saved Jobs</h5>
        @if (count(user()->saved_jobs) > 0)
            <div class="recent-content">
                <div class="row">
                    @foreach(user()->saved_jobs as $job)
                    
                        <div class="col-lg-4">
                            <div class="recent-box">
                                <div class="recent-img">
                                <img src="{{ $job->user->get_image() }}" alt="" /> 
                                </div>
                                <div class="recent-description">
                                    <div class="recent-header">
                                    <a href="{{ route('jobDetails',$job->slug) }}"><h4>{{ $job->title ? $job->title :'N/A'}}</h4></a> 
                                    <a href="javascript:void(0)" onclick="savejob('{{ $job->id }}')"><i class="fas fa-star {{ user()->isSavedJob($job->id) ? 'icon-color' : ''  }}" id="save-job-{{ $job->id }}"></i></a>
                                    </div>
                                    <div class="recent-main">
                                        <p>{{ $job->user->first_name }} {{ $job->user->last_name  }}</p>
                                        <p>{{$job->user->street_address ? $job->user->street_address :'N/A'  }}</p>
                                    </div>
                                    <div class="recent-footer" style="column-gap:1rem; align-items:flex-start;">
                                        <i class="far fa-clock" style="font-size:1.9rem;"></i>
                                        <p style="font-size: 1.3rem;">From {{ \Carbon\Carbon::parse($job->user->job_schedual_from)->format('h:i A') }} - {{ \Carbon\Carbon::parse($job->user->job_schedual_to)->format('g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection