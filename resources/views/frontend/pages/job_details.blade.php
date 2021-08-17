@extends('frontend.layouts.master')

@section('css')
    <style>
        .apply{
            cursor: pointer !important;
            color: white !important;
        }
    </style>
@endsection

@section('main-content')
    <header class="header-2" style="position:fixed; top:0; width:100%;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-top">
                        <div class="logo-area">
                            <a href="{{route('welcome')}}"><img src="{{asset('/publlic/asset/images/logo-2.png')}}" alt=""></a>
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
        <div class="container">
            <div class="row">
                <div class="col">
                    @if($message = Session::get('warning'))
                        <div class="alert alert-warning alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if($message = Session::get('success'))
                        <div class="alert alert-warning alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <div class="job-listing-details">
                        <div class="job-title-and-info">
                            <div class="title">
                                <div class="thumb">
                                    @php
                                        $avatar = DB::table('users')
                                        ->select('avatar')
                                        ->where('id',$job->user_id)
                                        ->first();
                                    @endphp
                                    <img src="{{ asset('/publlic/images/'.$avatar->avatar) }}" class="img-fluid" alt="">
                                </div>
                                <div class="title-body">
                                    <h4>{{(session()->has('language')) ? $job->title_ar : $job->title}}</h4>
                                    <div class="info">
                                        @php
                                            $jobLocation = DB::table('countries')
                                            ->where('id', $job->job_location)
                                            ->first();
                                        @endphp
                                        <span class="company"><a href="{{route('jobDetails', $job->slug)}}"><i class="fa fa-briefcase"></i> {{($user->companyname)}}</a></span>
                                        <span class="office-location"><a href="{{route('jobDetails', $job->slug)}}"><i class="fa fa-map-pin"></i> {{(session()->has('language')) ? $jobLocation->name_ar : $jobLocation->name}}</a></span>
                                        <span class="job-type full-time"><a href="{{route('jobDetails', $job->slug)}}"><i class="fa fa-clock"></i> @php $jobType = DB::table('job_types_tables')->find($job->type); @endphp @if(isset($jobType)) {{(session()->has('language')) ? $jobType->name_ar : $jobType->name }} @endif</a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="buttons">
                                @guest()
                                    <a class="apply" style="cursor: pointer" data-toggle="modal" data-target="#loginModal">{{__('Apply Online')}}</a>
                                @endguest
                                @auth()
                                    @php
                                        $userCandidate = DB::table('model_has_roles')
                                        ->where('model_id', Auth::user()->id)
                                        ->where('role_id', 3)
                                        ->first();
                                    @endphp
                                    @if (isset($userCandidate))
                                        @php
                                            $dataCheck = DB::table('candidate_applied_jobs')->select()->where('user_id', Auth::user()->id)->where('job_id', $job->id)->first();
                                        @endphp
                                        @if(isset($dataCheck))
                                            <a class="apply">{{__('Applied')}}</a>
                                        @else
                                            <a class="apply" href="{{route('jobApply', ['id'=> $job->id, 'user_id'=>Auth::user()->id])}}">{{__('Apply Online')}}</a>
                                        @endif
                                    @endif
                                @endauth
                            </div>
                        </div>

                        <div class="details-information section-padding-60">
                            <div class="row">
                                <div class="col-xl-7 col-lg-8">
                                    <div class="description details-section">
                                        <h4><i data-feather="align-left"></i>{{__('Job Description')}}</h4>
                                        <p>{!! htmlspecialchars_decode($job->description) !!}</p>
                                    </div>
                                    <div class="responsibilities details-section">
                                        <h4><i data-feather="zap"></i>{{__('Responsibilities')}}</h4>
                                        <ul>
                                            {!! htmlspecialchars_decode($job->responsibilities) !!}
                                        </ul>
                                    </div>
                                    <div class="edication-and-experience details-section">
                                        <h4><i data-feather="book"></i>{{__('Education + Experience')}}</h4>
                                        <ul>
                                            {!! htmlspecialchars_decode($job->education) !!}
                                        </ul>
                                    </div>
                                    <div class="job-apply-buttons">
                                        @guest()
                                            <a class="apply" style="cursor: pointer;color:white" data-toggle="modal" data-target="#loginModal">{{__('Apply Online')}}</a>
                                        @endguest
                                        @auth()
                                            @php
                                                $userCandidate = DB::table('model_has_roles')
                                                ->where('model_id', Auth::user()->id)
                                                ->where('role_id', 3)
                                                ->first();
                                            @endphp
                                            @if (isset($userCandidate))
                                                    @php
                                                        $dataCheck = DB::table('candidate_applied_jobs')->select()->where('user_id', Auth::user()->id)->where('job_id', $job->id)->first();
                                                    @endphp
                                                    @if(isset($dataCheck))
                                                        <a class="apply">{{__('Applied')}}</a>
                                                    @else
                                                        <a class="apply" href="{{route('jobApply', ['id'=> $job->id, 'user_id'=>Auth::user()->id])}}">Apply Online</a>
                                                    @endif
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                                <div class="col-xl-4 offset-xl-1 col-lg-4">
                                    <div class="information-and-share">
                                        <div class="job-summary">
                                            <h4>{{__('Job Summary')}}</h4>
                                            <ul>
                                                <li><span>{{__('Published on:')}}</span> {{\Carbon\Carbon::parse($job->date)->format('M d Y')}}</li>
                                                <li><span>{{__('Application Deadline:')}}</span> {{\Carbon\Carbon::parse($job->endingDate)->format('M d Y')}}</li>
                                                <li><span>{{__('Posted by:')}}</span> {{$user->name}}</li>
                                                <li><span>{{__('Employment Status:')}}</span> @php $jobType = DB::table('job_types_tables')->find($job->type); @endphp @if(isset($jobType)) {{(session()->has('language')) ? $jobType->name_ar : $jobType->name }} @endif</li>
                                                <li>
                                                    <span>{{__('Experience:')}}</span>
                                                    @if ($job->experience == 1)
                                                        {{__('Min 1 Year')}}
                                                    @elseif ($job->experience == 2)
                                                        {{__('Less than one year')}}
                                                    @elseif($job->experience == 3)
                                                        {{__('1 Year')}}
                                                    @elseif($job->experience == 4)
                                                        {{__('2 Years')}}
                                                    @elseif($job->experience == 5)
                                                        {{__('3 Years')}}
                                                    @elseif($job->experience == 6)
                                                        {{__('4 Years')}}
                                                    @elseif($job->experience == 7)
                                                        {{__('5+ Years')}}
                                                    @else
                                                        {{__('No Experience')}}
                                                    @endif
                                                </li>
                                                <li><span>{{__('Job Location:')}}</span> {{(session()->has('language')) ? $jobLocation->name_ar : $jobLocation->name}}</li>
                                                <li><span>{{__('Salary:')}}</span> {{($job->salary)}}</li>
                                                <li><span>{{__('Gender:')}}</span> {{($job->gender)}}</li>
                                            </ul>
                                        </div>
                                        <div class="share-job-post">
                                            <span class="share"><i class="fas fa-share-alt"></i>{{__('Share:')}}</span>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{route('jobDetails', $job->slug)}}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                            <a href="https://twitter.com/intent/tweet?url={{route('jobDetails', $job->slug)}}" target="_blank"><i class="fab fa-twitter"></i></a>
                                            <a href="whatsapp://send?text={{route('jobDetails', $job->slug)}}" target="_blank" data-action="share/whatsapp/share"><i class="fab fa-whatsapp"></i></a>
                                        </div>
                                        <div class="buttons d-block">
                                            <a onclick="window.print()" class="button print w-100"><i data-feather="printer"></i>{{__('Print Job')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-7 col-lg-8">
                                <div class="company-information details-section">
                                    <h4><i data-feather="briefcase"></i>{{__('About the Company')}}</h4>
                                    <ul>
                                        @if($user->companyname != null)
                                            <li><span>{{__('Company Name:')}}</span> {{($user->companyname)}}</li>
                                        @endif
                                        @if($user->address != null)
                                            <li><span>{{__('Address:')}}</span> {{$user->address}}</li>
                                        @endif
                                        @if($user->companyWebAddress != null)
                                            <li><span>{{__('Website:')}}</span> <a href="{{$user->companyWebAddress}}">{{__('Link')}}</a></li>
                                        @endif
                                        @if($user->twitter != null)
                                            <li><span>{{__('Twitter:')}}</span> <a href="{{$user->twitter}}">{{__('Profile')}}</a></li>
                                        @endif
                                        @if($user->linkedin != null)
                                            <li><span>{{__('Linkedin:')}}</span> <a href="{{$user->linkedin}}">{{__('Profile')}}</a></li>
                                        @endif
                                        @if($user->instagram != null)
                                            <li><span>{{__('Instagram:')}}</span> <a href="{{$user->instagram}}">{{__('Profile')}}</a></li>
                                        @endif
                                        @if($user->aboutus != null)
                                            <li><span>{{__('About Us:')}}</span> {{($user->aboutus)}}</li>
                                        @endif
                                    </ul>
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
