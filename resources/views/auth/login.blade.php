{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Login') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    <form method="POST" action="{{ route('login') }}">--}}
{{--                        @csrf--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

{{--                                @error('email')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">--}}

{{--                                @error('password')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                                    <label class="form-check-label" for="remember">--}}
{{--                                        {{ __('Remember Me') }}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row mb-0">--}}
{{--                            <div class="col-md-8 offset-md-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    {{ __('Login') }}--}}
{{--                                </button>--}}

{{--                                @if (Route::has('password.request'))--}}
{{--                                    <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                        {{ __('Forgot Your Password?') }}--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endsection--}}


    <!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Path</title>

    <!-- Bootstrap CSS -->

    @include('common.libraries')

</head>
<body>

<!-- Header -->

{{--@extends('common.header-home')--}}

<header class=" ">

    <nav class="navbar navbar-expand-xl absolute-nav transparent-nav cp-nav navbar-light bg-light fluid-nav">
        <a class="navbar-brand" href="index.php">
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
                            <h5>BY Category</h5>
                            <ul>
                                <li><a href="#">Accounting / Finance <span>(233)</span></a></li>
                                <li><a href="#">Education <span>(46)</span></a></li>
                                <li><a href="#">Design & Creative <span>(156)</span></a></li>
                                <li><a href="#">Health Care <span>(98)</span></a></li>
                                <li><a href="#">Engineer & Architects <span>(188)</span></a></li>
                                <li><a href="#">Marketing & Sales <span>(124)</span></a></li>
                                <li><a href="#">Garments / Textile <span>(584)</span></a></li>
                                <li><a href="#">Customer Support <span>(233)</span></a></li>
                            </ul>
                        </li>
                        <li class="search-by">
                            <h5>BY LOcation</h5>
                            <ul>
                                <li><a href="#">Kuwait <span>(508)</span></a></li>
                                <li><a href="#">United Arab Emirates<span>(96)</span></a></li>
                                <li><a href="#">Saudi Arabia <span>(155)</span></a></li>
                                <li><a href="#">Qatar <span>(24)</span></a></li>
                                <li><a href="#">Oman <span>(10)</span></a></li>
                                <li><a href="#">Bahrain <span>(268)</span></a></li>
                                <li><a href="#">Jordon <span>(46)</span></a></li>
                                <li><a href="#">Lebanon <span>(12)</span></a></li>
                                <li><a href="#">Eygpt <span>(456)</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto main-nav " >





                <!--            <li class="menu-item post-job"><a title="Title" href="post-job.php"><i class="fas fa-plus"></i>Post a Job</a></li>-->
            </ul>
            <ul class="navbar-nav ml-auto account-nav">

                <li class="menu-item login-popup"><button title="Title" type="button" data-toggle="modal" data-target="#exampleModalLong">Login</button></li>
                <li class="menu-item login-popup"><button title="Title" type="button" data-toggle="modal" data-target="#exampleModalLong2">Registration</button></li>
            </ul>
        </div>
    </nav>
    <!-- Modal -->
    <div class="account-entry">

{{--        <form method="post" action="{{ route('login') }}">--}}
        <form method="post" action="{{ route('userLogin') }}">
            @csrf
            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i data-feather="user"></i>Login</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{--                        <form action="#">--}}
                            <div class="form-group">
                                <input id="email" type="email" name="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror form-control-lg" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror form-control-lg" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="more-option">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Remember Me
                                    </label>
                                </div>
                                <a href="#">Forget Password?</a>
                            </div>
                            <button class="button primary-bg btn-block">Login</button>
                            {{--                        </form>--}}
                            <div class="shortcut-login">
                                <p>Don't have an account? <a href="#">Register</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <form method="POST" action="{{ route('userRegister') }}">
            @csrf
            <div class="modal fade" id="exampleModalLong2" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i data-feather="edit"></i>Registration</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="account-type ">
                                    <div class="card-body">
                                        <label>Account Type</label>
                                        <select name="accountTypeUser"  class="form-control @error('accountTypeUser') is-invalid @enderror" id="account_type" required>
                                            <option selected="selected" disabled="disabled" value="">Please select</option>
                                            <option value='Employer'>Employer</option>
                                            <option value='Candidate'>Candidate</option>
                                        </select>
                                        @error('accountTypeUser')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ 'The account type field must be selected' }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <input id="Username" name="Username" type="text" value="{{ old('Username') }}" placeholder="Name" class="form-control @error('Username') is-invalid @enderror"  required autocomplete="Username" autofocus>
                                @error('Username')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="UserEmail" name="UserEmail" type="email" value="{{ old('UserEmail') }}" placeholder="Email Address" class="form-control @error('UserEmail') is-invalid @enderror" required autocomplete="UserEmail">
                                @error('UserEmail')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="user_password" name="user_password" type="password" placeholder="Password" class="form-control @error('user_password') is-invalid @enderror" required>
                                {{--                                    <input id="password" name="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">--}}
                                @error('user_password')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="user_password_confirmation" required>
                                {{--                                    <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required autocomplete="new-password">--}}
                            </div>
                            <div class="more-option terms">
                                <div class="form-check">
                                    <input class="form-check-input @error('agreeterms') is-invalid @enderror" name="agreeterms" type="checkbox" id="AgreeTerms" required>
                                    {{--                                @error('agreeterms') is-invalid @enderror--}}
                                    <label class="form-check-label" for="defaultCheck2">
                                        I accept the <a href="#">terms & conditions</a>
                                    </label>
                                    @error('agreeterms')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ 'The agreeterms field must be checked' }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6" style="float:left;">
                                {{--                            <form action="add-resume.php">--}}
                                {{--                                <button class="button primary-bg btn-block">Candidate Register</button>--}}
                                {{--                            </form>--}}
                            </div>
                            <div class="col-md-6" style="float:left;">
                                {{--                            <form action="employer/index.php">--}}
                                <button class="button primary-bg btn-block">Register</button>
                                {{--                            <input type="submit" value="Register" class="button primary-bg btn-block" name="btnSubmit" id="btnSubmit">--}}
                                {{--                            </form>--}}
                            </div>


                            <div class="shortcut-login">
                                <p>Already have an account? <a onclick="loginModal()" style="cursor:pointer">Login</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

</header>
<!-- Header End -->


<!-- Banner -->
<div class="banner banner-1 banner-1-bg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="banner-content">
                    <h1>58,246 Job Listed</h1>
                    <p>Create free account to find thousands Jobs, Employment & Career Opportunities around you!</p>
                    <a href="add-resume.php" class="button">Upload Resume</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Search and Filter -->
<div class="searchAndFilter-wrapper">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="searchAndFilter-block">
                    <div class="searchAndFilter">
                        <form action="#" class="search-form">
                            <input type="text" placeholder="Enter Keywords">
                            <select class="selectpicker" id="search-location">
                                <option value="" selected>Location</option>
                                <option value="california">California</option>
                                <option value="las-vegas">Las Vegas</option>
                                <option value="new-work">New Work</option>
                                <option value="carolina">Carolina</option>
                                <option value="chicago">Chicago</option>
                                <option value="silicon-vally">Silicon Vally</option>
                                <option value="washington">Washington DC</option>
                                <option value="neveda">Neveda</option>
                            </select>
                            <select class="selectpicker" id="search-category">
                                <option value="" selected>Category</option>
                                <option value="real-state">Real State</option>
                                <option value="vehicales">Vehicales</option>
                                <option value="electronics">Electronics</option>
                                <option value="beauty">Beauty</option>
                                <option value="furnitures">Furnitures</option>
                            </select>
                            <button class="button primary-bg"><i class="fas fa-search"></i>Search Job</button>
                        </form>
                        <div class="filter-categories">
                            <h4>Job Category</h4>
                            <ul>
                                <li><a href="job-listing.php"><i data-feather="bar-chart-2"></i>Accounting / Finance <span>(233)</span></a></li>
                                <li><a href="job-listing.php"><i data-feather="edit-3"></i>Education <span>(46)</span></a></li>
                                <li><a href="job-listing.php"><i data-feather="feather"></i>Design & Creative <span>(156)</span></a></li>
                                <li><a href="job-listing.php"><i data-feather="briefcase"></i>Health Care <span>(98)</span></a></li>
                                <li><a href="job-listing.php"><i data-feather="package"></i>Engineer & Architects <span>(188)</span></a></li>
                                <li><a href="job-listing.php"><i data-feather="pie-chart"></i>Marketing & Sales <span>(124)</span></a></li>
                                <li><a href="job-listing.php"><i data-feather="command"></i>Garments / Textile <span>(584)</span></a></li>
                                <li><a href="job-listing.php"><i data-feather="globe"></i>Customer Support <span>(233)</span></a></li>
                                <li><a href="job-listing.php"><i data-feather="headphones"></i>Digital Media <span>(15)</span></a></li>
                                <li><a href="job-listing.php"><i data-feather="radio"></i>Telecommunication <span>(03)</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Search and Filter End -->

<!-- Registration Box -->
<div class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="call-to-action-box candidate-box">
                    <div class="icon">
                        <img src="{{asset('asset/images/register-box/1.png')}}" alt="">
                    </div>
                    <span>Are You</span>
                    <h3>Candidate?</h3>
                    <a href="#" data-toggle="modal" data-target="#exampleModalLong2">Register Now <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="call-to-action-box employer-register">
                    <div class="icon">
                        <img src="{{asset('asset/images/register-box/2.png')}}" alt="">
                    </div>
                    <span>Are You</span>
                    <h3>Employer?</h3>
                    <a href="#" data-toggle="modal" data-target="#exampleModalLong3">Register Now <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Registration Box End -->

<!-- Top Companies -->
<div class="section-padding-top padding-bottom-90">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="section-header">
                    <h2>Top Companies</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="company-carousel owl-carousel">
                    <div class="company-wrap">
                        <div class="thumb">
                            <a href="#">
                                <img src="{{asset('asset/images/company/company-logo-1.png')}}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="body">
                            <h4><a href="employer-details">Digoin</a></h4>
                            <span>Kansas City, Missouri</span>
                            <a href="job-listing.php" class="button">4 Open Positions</a>
                        </div>
                    </div>
                    <div class="company-wrap">
                        <div class="thumb">
                            <a href="#">
                                <img src="{{asset('asset/images/company/company-logo-2.png')}}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="body">
                            <h4><a href="employer-details.php">Orion Ltd.</a></h4>
                            <span>Sacramento, California</span>
                            <a href="job-listing.php" class="button">2 Open Positions</a>
                        </div>
                    </div>
                    <div class="company-wrap">
                        <div class="thumb">
                            <a href="#">
                                <img src="{{asset('asset/images/company/company-logo-3.png')}}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="body">
                            <h4><a href="employer-details.php">Realhouse</a></h4>
                            <span>London, United Kingdom</span>
                            <a href="job-listing.php" class="button">4 Open Positions</a>
                        </div>
                    </div>
                    <div class="company-wrap">
                        <div class="thumb">
                            <a href="#">
                                <img src="{{asset('asset/images/company/company-logo-4.png')}}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="body">
                            <h4><a href="employer-details.php">BioPro</a></h4>
                            <span>Ajax, Ontarioland</span>
                            <a href="job-listing.php" class="button">1 Open Positions</a>
                        </div>
                    </div>
                    <div class="company-wrap">
                        <div class="thumb">
                            <a href="#">
                                <img src="{{asset('asset/images/company/company-logo-1.png')}}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="body">
                            <h4><a href="employer-details.php">Digoin</a></h4>
                            <span>Kansas City, Missouri</span>
                            <a href="job-listing.php" class="button">4 Open Positions</a>
                        </div>
                    </div>
                    <div class="company-wrap">
                        <div class="thumb">
                            <a href="#">
                                <img src="{{asset('asset/images/company/company-logo-2.png')}}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="body">
                            <h4><a href="employer-details.php">Orion Ltd.</a></h4>
                            <span>Sacramento, California</span>
                            <a href="job-listing.php" class="button">2 Open Positions</a>
                        </div>
                    </div>
                    <div class="company-wrap">
                        <div class="thumb">
                            <a href="#">
                                <img src="{{asset('asset/images/company/company-logo-3.png')}}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="body">
                            <h4><a href="employer-details.php">Realhouse</a></h4>
                            <span>London, United Kingdom</span>
                            <a href="job-listing.php" class="button">4 Open Positions</a>
                        </div>
                    </div>
                    <div class="company-wrap">
                        <div class="thumb">
                            <a href="#">
                                <img src="{{asset('asset/images/company/company-logo-4.png')}}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="body">
                            <h4><a href="employer-details.php">BioPro</a></h4>
                            <span>Ajax, Ontarioland</span>
                            <a href="job-listing.php" class="button">1 Open Positions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top Companies End -->

<!-- Jobs -->
<div class="section-padding-bottom alice-bg">
    <div class="container">
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs job-tab" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="recent-tab" data-toggle="tab" href="#recent" role="tab" aria-controls="recent" aria-selected="true">Recent Job</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="feature-tab" data-toggle="tab" href="#feature" role="tab" aria-controls="feature" aria-selected="false">Feature Job</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="recent" role="tabpanel" aria-labelledby="recent-tab">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-8.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Restaurant Team Member - Crew </a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Geologitic</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>New Orleans</a></span>
                                                <span class="job-type temporary"><a href="#"><i data-feather="clock"></i>Temporary</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-9.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Nutrition Advisor</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Theoreo</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>New York City</a></span>
                                                <span class="job-type full-time"><a href="#"><i data-feather="clock"></i>Full Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-10.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">UI Designer</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Degoin</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>San Francisco</a></span>
                                                <span class="job-type part-time"><a href="#"><i data-feather="clock"></i>Part Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-3.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Land Development Marketer</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Realouse</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>Washington, D.C.</a></span>
                                                <span class="job-type freelance"><a href="#"><i data-feather="clock"></i>Freelance</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-10.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">UI Designer</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Degoin</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>San Francisco</a></span>
                                                <span class="job-type part-time"><a href="#"><i data-feather="clock"></i>Part Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-3.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Land Development Marketer</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Realouse</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>Washington, D.C.</a></span>
                                                <span class="job-type freelance"><a href="#"><i data-feather="clock"></i>Freelance</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-1.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Designer Required</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Theoreo</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>New York City</a></span>
                                                <span class="job-type full-time"><a href="#"><i data-feather="clock"></i>Full Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-2.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Project Manager</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Degoin</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>San Francisco</a></span>
                                                <span class="job-type part-time"><a href="#"><i data-feather="clock"></i>Part Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-8.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Restaurant Team Member - Crew </a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Geologitic</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>New Orleans</a></span>
                                                <span class="job-type temporary"><a href="#"><i data-feather="clock"></i>Temporary</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-9.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Nutrition Advisor</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Theoreo</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>New York City</a></span>
                                                <span class="job-type full-time"><a href="#"><i data-feather="clock"></i>Full Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-1.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Designer Required</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Theoreo</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>New York City</a></span>
                                                <span class="job-type full-time"><a href="#"><i data-feather="clock"></i>Full Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-2.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Project Manager</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Degoin</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>San Francisco</a></span>
                                                <span class="job-type part-time"><a href="#"><i data-feather="clock"></i>Part Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="feature" role="tabpanel" aria-labelledby="feature-tab">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-10.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-listing.php">UI Designer</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Degoin</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>San Francisco</a></span>
                                                <span class="job-type part-time"><a href="#"><i data-feather="clock"></i>Part Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-1.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-listing.php">Designer Required</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Theoreo</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>New York City</a></span>
                                                <span class="job-type full-time"><a href="#"><i data-feather="clock"></i>Full Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-2.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-listing.php">Project Manager</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Degoin</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>San Francisco</a></span>
                                                <span class="job-type part-time"><a href="#"><i data-feather="clock"></i>Part Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-1.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-listing.php">Designer Required</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Theoreo</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>New York City</a></span>
                                                <span class="job-type full-time"><a href="#"><i data-feather="clock"></i>Full Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-8.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-listing.php">Restaurant Team Member - Crew </a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Geologitic</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>New Orleans</a></span>
                                                <span class="job-type temporary"><a href="#"><i data-feather="clock"></i>Temporary</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-9.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-listing.php">Nutrition Advisor</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Theoreo</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>New York City</a></span>
                                                <span class="job-type full-time"><a href="#"><i data-feather="clock"></i>Full Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-3.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Land Development Marketer</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Realouse</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>Washington, D.C.</a></span>
                                                <span class="job-type freelance"><a href="#"><i data-feather="clock"></i>Freelance</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-2.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Project Manager</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Degoin</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>San Francisco</a></span>
                                                <span class="job-type part-time"><a href="#"><i data-feather="clock"></i>Part Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-8.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Restaurant Team Member - Crew </a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Geologitic</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>New Orleans</a></span>
                                                <span class="job-type temporary"><a href="#"><i data-feather="clock"></i>Temporary</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-9.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Nutrition Advisor</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Theoreo</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>New York City</a></span>
                                                <span class="job-type full-time"><a href="#"><i data-feather="clock"></i>Full Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-10.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">UI Designer</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Degoin</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>San Francisco</a></span>
                                                <span class="job-type part-time"><a href="#"><i data-feather="clock"></i>Part Time</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="job-list half-grid">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="{{asset('asset/images/job/company-logo-3.png')}}" class="img-fluid" alt="">
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="content">
                                            <h4><a href="job-details.php">Land Development Marketer</a></h4>
                                            <div class="info">
                                                <span class="company"><a href="#"><i data-feather="briefcase"></i>Realouse</a></span>
                                                <span class="office-location"><a href="#"><i data-feather="map-pin"></i>Washington, D.C.</a></span>
                                                <span class="job-type freelance"><a href="#"><i data-feather="clock"></i>Freelance</a></span>
                                            </div>
                                        </div>
                                        <div class="more">
                                            <div class="buttons">
                                                <a href="#" class="button">Apply Now</a>
                                                <a href="#" class="favourite"><i data-feather="heart"></i></a>
                                            </div>
                                            <p class="deadline">Deadline: Oct 31, 2018</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Jobs End -->



<!-- Fun Facts -->
<div class="padding-top-90 padding-bottom-60 fact-bg">
    <div class="container">
        <div class="row fact-items">
            <div class="col-md-3 col-sm-6">
                <div class="fact">
                    <div class="fact-icon">
                        <i data-feather="briefcase"></i>
                    </div>
                    <p class="fact-number"><span class="count" data-form="0" data-to="12376"></span></p>
                    <p class="fact-name">Live Jobs</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="fact">
                    <div class="fact-icon">
                        <i data-feather="users"></i>
                    </div>
                    <p class="fact-number"><span class="count" data-form="0" data-to="89562"></span></p>
                    <p class="fact-name">Candidate</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="fact">
                    <div class="fact-icon">
                        <i data-feather="file-text"></i>
                    </div>
                    <p class="fact-number"><span class="count" data-form="0" data-to="28166"></span></p>
                    <p class="fact-name">Resume</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="fact">
                    <div class="fact-icon">
                        <i data-feather="award"></i>
                    </div>
                    <p class="fact-number"><span class="count" data-form="0" data-to="1366"></span></p>
                    <p class="fact-name">Companies</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fun Facts End -->



<!-- Modal -->
<div class="account-entry">
    <div class="modal fade" id="exampleModalLong3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i data-feather="edit"></i>Registration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="account-type">
                        <a href="#" class="candidate-acc"><i data-feather="user"></i>Candidate</a>
                        <a href="#" class="employer-acc active"><i data-feather="briefcase"></i>Employer</a>
                    </div>
                    <form action="#">
                        <div class="form-group">
                            <input type="text" placeholder="Username" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="email" placeholder="Email Address" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Password" class="form-control">
                        </div>
                        <div class="more-option terms">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck3">
                                <label class="form-check-label" for="defaultCheck3">
                                    I accept the <a href="#">terms & conditions</a>
                                </label>
                            </div>
                        </div>
                        <button class="button primary-bg btn-block">Register</button>
                    </form>
                    <div class="shortcut-login">

                        <p>Already have an account? <a href="#">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







{{--@extends('common.footer')--}}
@extends('common.footerLibraries')
</body>
</html>

<script>
    // let select = document.getElementById('accounttype');
    // select.onchange = function(){
    //     this.form.submit();
    // };
    // let select = document.getElementById('accounttype');
    // select.addEventListener('change', function(){
    //     this.form.submit();
    // }, false);
    function formValidation()
    {
        let check_account = document.registration.accounttype;
        {

            if(account_check(check_account))
            {
                alert('pta nai');
            }

        }
        return false;
    }
    function account_check(check_account)
    {
        if(check_account.value === "Default")
        {
            alert('select your account type from the list');
            check_account.focus();
            return false;
        }
        else
        {
            return true;
        }
    }


</script>


