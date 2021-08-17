@extends('frontend.layouts.master')

@section('css')
@endsection

@section('main-content')
    <header class="header-2" style="position:fixed; top:0; width:100%;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-top">
                        <div class="logo-area">
                            <a href="{{route('welcome')}}"><img src="{{asset('/public/asset/images/logo-2.png')}}" alt=""></a>
                        </div>
                        <div class="header-top-toggler">
                            <div class="header-top-toggler-button"></div>
                        </div>
                        <div class="top-nav">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="headerSeparator"></div>

    <div class="alice-bg padding-top-60 section-padding-bottom">
        <div class="section-padding-bottom alice-bg">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <ul class="nav nav-tabs job-tab" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link " id="recent-tab" data-toggle="tab" href="#recent" role="tab" aria-controls="recent" aria-selected="true">{{__('Searched Result')}}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="recent" role="tabpanel" aria-labelledby="recent-tab">
                                <div class="row">
                                    @if (count($total_jobs) <= 0 )
                                            <h4 style="margin-left: 470px">{{__('No Jobs Found')}}</h4>
                                    @else
                                        @foreach($total_jobs as $total_job)
                                            <div class="col-lg-6">
                                                @php
                                                    $jobUser = DB::table('users')
                                                    ->select('avatar','companyname')
                                                    ->where('id',$total_job->user_id)
                                                    ->first();
                                                    $jobLocation = DB::table('countries')
                                                    ->where('id', $total_job->job_location)
                                                    ->first();
                                                @endphp
                                                <div class="job-list half-grid">
                                                    <div class="thumb">
                                                        <a href="{{route('jobDetails', $total_job->slug)}}">
                                                            <img src="{{ asset('/public/images/'.$jobUser->avatar) }}" class="img-fluid" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="body">
                                                        <div class="content">
                                                            <h4><a href="{{route('jobDetails', $total_job->slug)}}">{{(session()->has('language')) ? $total_job->title_ar : $total_job->title}}</a></h4>
                                                            <div class="info">
                                                                <span class="company"><a href="{{route('jobDetails', $total_job->slug)}}"><i data-feather="briefcase"></i>{{$jobUser->companyname}}</a></span>
                                                                <span class="office-location"><a href="{{route('jobDetails', $total_job->slug)}}"><i data-feather="map-pin"></i>{{(session()->has('language')) ? $jobLocation->name_ar : $jobLocation->name}}</a></span>
                                                                <span class="job-type temporary"><a href="{{route('jobDetails', $total_job->slug)}}"><i data-feather="clock"></i> @php $jobType = DB::table('job_types_tables')->find($total_job->type); @endphp @if(isset($jobType)) {{(session()->has('language')) ? $jobType->name_ar : $jobType->name }} @endif </a></span>
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <div class="buttons">
                                                                @guest()
                                                                    <a data-toggle="modal" data-target="#loginModal" class="button">{{__('Apply Now')}}</a>
                                                                @endguest
                                                                @auth()
                                                                    @if(Auth::user()->hasRole('Candidate'))
                                                                        @php
                                                                            $dataCheck = DB::table('candidate_applied_jobs')->select()->where('user_id', Auth::user()->id)->where('job_id', $total_job->id)->first();
                                                                        @endphp
                                                                        @if(isset($dataCheck))
                                                                            <a class="apply">{{__('Applied')}}</a>
                                                                        @else
                                                                            <a class="apply" href="{{route('jobApply', ['id'=> $job->id, 'user_id'=>Auth::user()->id])}}">{{__('Apply Online')}}</a>
                                                                        @endif
                                                                    @endif
                                                                @endauth
                                                            </div>
                                                            <p class="deadline">{{__('Deadline:')}} {{\Carbon\Carbon::parse($total_job->endingDate)->format('M d Y')}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
