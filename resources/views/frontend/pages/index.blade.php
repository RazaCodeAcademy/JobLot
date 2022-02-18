@extends('frontend.layouts.master')

@section('css')
@endsection

@section('main-content')
    {{-- Navbar --}}
    <header>
        <nav class="navbar navbar-expand-xl absolute-nav transparent-nav cp-nav navbar-light bg-light fluid-nav">
            <a class="navbar-brand" href="{{route('welcome')}}">
                <img src="{{asset('asset/images/logo.png')}}" class="img-fluid" alt="">
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto job-browse">
                    <li class="nav-item dropdown">
                        <a title="" href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">Browse Jobs</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="search-by">
                                <h5>{{__('BY Category')}}</h5>
                                <ul>
                                    @foreach($job_categories as $job_category)
                                        @php  
                                            $count = DB::table('jobs')
                                            ->where('category', $job_category->id)
                                            ->where('status', '=' , 1)
                                            ->where('job_approval', '=' , 1)
                                            ->whereDate('date','<=', $timeCheck)
                                            ->whereDate('endingDate','>=', $timeCheck)
                                            ->count(); 
                                        @endphp
                                        <li><a href="{{route('categoryJobs', $job_category->id)}}">{{(session()->has('language')) ? $job_category->category_ar : $job_category->category}} <span>({{$count}})</span></a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="search-by">
                                <h5>{{__('BY Location')}}</h5>
                                <ul>
                                    @foreach($locations as $location)
                                        @php  
                                            $count = DB::table('jobs')
                                            ->where('job_location', $location->id)
                                            ->where('status', '=' , 1)
                                            ->where('job_approval', '=' , 1)
                                            ->whereDate('date','<=', $timeCheck)
                                            ->whereDate('endingDate','>=', $timeCheck)
                                            ->count(); 
                                        @endphp
                                        <li><a href="{{route('countryJobs', $location->id)}}">{{(session()->has('language')) ? $location->name_ar : $location->name}} <span>({{$count}})</span></a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto account-nav">
                    @auth()
                        <li class="menu-item">
                            <a  @if(Auth::user()->hasRole('Employer')) href="{{route('employerDashboard')}}"
                                @elseif( Auth::user()->hasRole('Candidate')) href="{{route('candidateDashboard')}}"
                                @elseif( Auth::user()->hasRole('Admin')) href="{{route('adminDashboard')}}"
                                @elseif( Auth::user()->hasRole('Sub Admin')) href="{{route('subAdminDashboard')}}" @endif type="button" >
                                {{__('Dashboard')}}
                            </a>
                        </li>
                    @endauth
                    @guest()
                        <li class="menu-item login-popup"><button title="Title" type="button" data-toggle="modal" data-target="#loginModal">{{__('Login')}}</button></li>
                        <li class="menu-item"><a href="{{route('candidate-register')}}">{{__('Register as Candidate')}}</a></li>
                        <li class="menu-item"><a href="{{route('employer-register')}}">{{__('Register as Employer')}}</a></li>
                    @endguest
                    <li class="menu-item"><a href="{{ (session()->has('language')) ? route('removeLanguage') : route('addLanguage') }}">{{ (session()->has('language')) ? 'English' : 'عربى' }}</a></li>
                </ul>
            </div>
        </nav>
    </header>

    {{-- Banner --}}
    <div class="banner banner-1 banner-1-bg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="banner-content">
                        <h1>{{$active_jobs}} {{__('Job(s) Listed')}}</h1>
                        <p>{{__('Create free account to find thousands Jobs, Employment & Career Opportunities around you!')}}</p>
                        @if(Auth::check())
                            @if(Auth::user()->hasRole('Candidate'))
                                <a href="{{route('resume')}}" class="button" >{{__('Upload Resume')}}</a>
                            @endif
                        @else
                            <a data-toggle="modal" data-target="#loginModal" class="button">{{__('Upload Resume')}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Job Search and FIlter By Categories --}}
    <div class="searchAndFilter-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="searchAndFilter-block">
                        <div class="searchAndFilter">
                            <form action="{{route('job_search')}}" method="GET" class="search-form" id="submitForm">
                                <input type="text" name="keyword" id="keyword" placeholder="Enter Keywords">
                                <select class="selectpicker" name="location" id="location">
                                    <option value="" selected>{{__('Location')}}</option>
                                    @foreach($locations as $location)
                                        <option value="{{$location->id}}">{{(session()->has('language')) ? $location->name_ar : $location->name}}</option>
                                    @endforeach
                                </select>
                                <select class="selectpicker" name="category" id="category">
                                    <option value="" selected>{{__('Category')}}</option>
                                    @foreach($job_categories as $job_category)
                                        <option value="{{$job_category->id}}">{{(session()->has('language')) ? $job_category->category_ar : $job_category->category}}</option>
                                    @endforeach
                                </select>
                                <button type="button" id="submitButton" class="button primary-bg"><i class="fas fa-search"></i>{{__('Search Job')}}</button>
                            </form>

                            <div class="filter-categories">
                                <h4>{{__('Job Category')}}</h4>
                                <ul>
                                    @foreach($job_categories as $job_category)
                                        @php
                                            $count = DB::table('jobs')
                                            ->where('category', $job_category->id)
                                            ->where('status', '=' , 1)
                                            ->where('approval_status', '=' , 1)
                                            ->whereDate('date','<=', $timeCheck)
                                            ->whereDate('endingDate','>=', $timeCheck)
                                            ->count();
                                        @endphp
                                        <li>
                                            <a href="{{route('categoryJobs', $job_category->id)}}">
                                                <i @if ($job_category->icon == 'bar-chart-2')  data-feather="bar-chart-2"
                                                @elseif ($job_category->icon == 'briefcase') data-feather="briefcase"
                                                @elseif ($job_category->icon == 'command') data-feather="command"
                                                @elseif ($job_category->icon == 'radio') data-feather="radio"
                                                @elseif ($job_category->icon == 'home') data-feather="home"
                                                @endif >
                                                </i>{{(session()->has('language')) ? $job_category->category_ar : $job_category->category}}
                                                <span>({{$count}})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Guest Candidate/Employer Registre Page --}}
    @guest()
        <div class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="call-to-action-box candidate-box">
                            <div class="icon">
                                <img src="{{asset('asset/images/register-box/1.png')}}" alt="">
                            </div>
                            <span>{{__('Are You')}}</span>
                            <h3>{{__('Candidate?')}}</h3>
                            <a href="{{route('candidate-register')}}">{{__('Register Now')}} <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="call-to-action-box employer-register">
                            <div class="icon">
                                <img src="{{asset('asset/images/register-box/2.png')}}" alt="">
                            </div>
                            <span>{{__('Are You')}}</span>
                            <h3>{{__('Employer?')}}</h3>
                            <a href="{{route('employer-register')}}">{{__('Register Now')}} <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endguest

    {{-- Employers --}}
    <div class="section-padding-top padding-bottom-90">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-header">
                        <h2>{{__('Top Companies')}}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="company-carousel owl-carousel">
                        @foreach($total_companies as $total_company)
                            @php
                                $user = DB::table('users')
                                ->where('id', '=',$total_company->model_id)
                                ->first();
                                $job_count = DB::table('jobs')
                                ->where('user_id', '=',$total_company->model_id)
                                ->count();
                            @endphp
                            <div class="company-wrap" >
                                <div class="thumb">
                                    <a>
                                        @if (isset($user->avatar))
                                            <img src="{{ asset('images/'.$user->avatar) }}" style="height: 100px" class="img-fluid" alt="">
                                        @else
                                            <img src="{{asset('asset/images/company/company-logo-1.png')}}" style="height: 100px" class="img-fluid" alt="">
                                        @endif
                                    </a>
                                </div>
                                <div class="body" style="height: 150px">
                                    @if (isset($user->companyname))
                                        <h4><a style="height: 60px">{{$user->companyname}}</a></h4>
                                    @else
                                        <h4><a style="height: 60px">{{__('No company name')}}</a></h4>
                                    @endif
                                    @php
                                        // $country = DB::table('countries')->find($user->country_name);
                                    @endphp
                                    @if (isset($country))
                                        <span>{{(session()->has('language')) ? $country->name_ar : $country->name}}</span>
                                    @else
                                        <span>{{__('N/A')}}</span>
                                    @endif
                                    <a class="button">{{$job_count}} {{__('Job(s) Posted')}}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Jobs --}}
    <div class="section-padding-bottom alice-bg">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul class="nav nav-tabs job-tab" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link " id="recent-tab" data-toggle="tab" href="#recent" role="tab" aria-controls="recent" aria-selected="true">{{__('Recent Job')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="recent" role="tabpanel" aria-labelledby="recent-tab">
                            <div class="row">
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
                                                    <img src="{{ asset('images/'.$jobUser->avatar) }}" class="img-fluid" alt="">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Fun Facts --}}
    <div class="padding-top-90 padding-bottom-60 fact-bg">
        <div class="container">
            <div class="row fact-items">
                <div class="col-md-3 col-sm-6">
                    <div class="fact">
                        <div class="fact-icon">
                            <i data-feather="briefcase"></i>
                        </div>
                        <p class="fact-number"><span class="count" data-form="0" data-to="{{$active_jobs}}"></span></p>
                        <p class="fact-name">{{__('Live Jobs')}}</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="fact">
                        <div class="fact-icon">
                            <i data-feather="users"></i>
                        </div>
                        <p class="fact-number"><span class="count" data-form="0" data-to="{{$total_candidates}}"></span></p>
                        <p class="fact-name">{{__('Candidate')}}</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="fact">
                        <div class="fact-icon">
                            <i data-feather="file-text"></i>
                        </div>
                        <p class="fact-number"><span class="count" data-form="0" data-to="{{$totalCvs}}"></span></p>
                        <p class="fact-name">{{__('Resume')}}</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="fact">
                        <div class="fact-icon">
                            <i data-feather="award"></i>
                        </div>
                        <p class="fact-number"><span class="count" data-form="0" data-to="{{$total_companies_count}}"></span></p>
                        <p class="fact-name">{{__('Companies')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if(Session::has('warning'))
        <script>
            $(document).ready(function(){
                $("#loginModal").modal();
            });
        </script>
    @endif
    
    @if(Session::has('success'))
        <script>
            $(document).ready(function(){
                $("#loginModal").modal();
            });
        </script>
    @endif

    @if(Session::has('errorUser'))
        <script>
            $(document).ready(function(){
                $("#loginModal").modal();
            });
        </script>
    @endif

    <script>
        $('#submitButton').click(function(e){
            e.preventDefault();
            let category = $('#category').val();
            let location = $('#location').val();
            let keyword = $('#keyword').val();

            if(category != "" || location != "" || keyword != ""){
                $('#submitForm').submit();
            }
            else{
                toastr.options.positionClass = 'toast-top-center';
                toastr.error('Please Select any of one option');
                return;
            }

        });
    </script>
@endsection