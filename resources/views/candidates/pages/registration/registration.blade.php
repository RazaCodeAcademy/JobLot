<!DOCTYPE html>
<html lang="en">

    <head>
        <base href="../../../">
        <meta charset="utf-8" />
        <title>Candidate | Register</title>
        <meta name="description" content="Add user example" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="canonical" href="https://keenthemes.com/metronic" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <link href="{{asset('/public/candidate/dist/assets/css/pages/wizard/wizard-4.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/candidate/dist/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/candidate/dist/assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/candidate/dist/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/candidate/dist/assets/css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/candidate/dist/assets/css/themes/layout/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/candidate/dist/assets/css/themes/layout/brand/dark.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/candidate/dist/assets/css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <link rel="stylesheet" type="text/css" href="{{asset('/public/css/main.css')}}">

        <link rel="icon" href="{{asset('/public/asset/images/logo.png')}}">

        <style>
            .select2-container {
                width: 100% !important;
            }

            .headerSeparator{
                width:100%; height:60px;
            }
        </style>
    </head>

    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
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
    
        <div class="d-flex flex-column flex-root" style="margin-top: 100px;">
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div class="d-flex flex-column-fluid">
                    <div class="container">
                        <div class="card card-custom card-transparent">
                            <div class="card-body p-0">
                                <div class="wizard wizard-4" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="false">

                                    {{-- Wizard Steps --}}
                                    <div class="wizard-nav">
                                        <div class="wizard-steps">
                                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                                <div class="wizard-wrapper">
                                                    <div class="wizard-number">1</div>
                                                    <div class="wizard-label">
                                                        <div class="wizard-title">{{__('Account Registeration')}}</div>
                                                        <div class="wizard-desc">{{__('Account Details')}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wizard-step" data-wizard-type="step">
                                                <div class="wizard-wrapper">
                                                    <div class="wizard-number">2</div>
                                                    <div class="wizard-label">
                                                        <div class="wizard-title">{{__('Basic Information')}}</div>
                                                        <div class="wizard-desc">{{__('Add Details')}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wizard-step" data-wizard-type="step">
                                                <div class="wizard-wrapper">
                                                    <div class="wizard-number">3</div>
                                                    <div class="wizard-label">
                                                        <div class="wizard-title">{{__('Education/Experience')}}</div>
                                                        <div class="wizard-desc">{{__('Add Details')}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wizard-step" data-wizard-type="step">
                                                <div class="wizard-wrapper">
                                                    <div class="wizard-number">4</div>
                                                    <div class="wizard-label">
                                                        <div class="wizard-title">{{__('Submission')}}</div>
                                                        <div class="wizard-desc">{{__('Review and Submit')}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-custom card-shadowless rounded-top-0">
                                        <div class="card-body p-0">
                                            <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                                                <div class="col-xl-12 col-xxl-10">
                                                    <form class="form" action="{{route('candidateRegisteration')}}" method="POST" id="kt_form">
                                                        @csrf
                                                        <div class="row justify-content-center">
                                                            <div class="col-xl-9">

                                                                {{-- Step # 1 --}}
                                                                <div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Email Address')}}</label>
                                                                        <div class="col-lg-9 col-xl-9">
                                                                            <div class="input-group input-group-solid input-group-lg">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="la la-at"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control form-control-solid form-control-lg" name="email" placeholder="Email" value="{{ session()->get('register.email') }}" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Password')}}</label>
                                                                        <div class="col-lg-9 col-xl-9">
                                                                            <div class="input-group input-group-solid input-group-lg">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="la la-lock"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input class="form-control" placeholder="Enter password" name="password" type="password"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Confirm Password')}}</label>
                                                                        <div class="col-lg-9 col-xl-9">
                                                                            <div class="input-group input-group-solid input-group-lg">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="la la-lock"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input class="form-control" placeholder="Confirm password" name="confirmPassword" type="password"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Contact Phone')}}</label>
                                                                        <div class="col-lg-9 col-xl-9">
                                                                            <div class="input-group input-group-solid input-group-lg">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="la la-phone"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="text" class="form-control form-control-solid form-control-lg" name="phone" value="" placeholder="Phone" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- Step # 2 --}}
                                                                <div class="my-5 step" data-wizard-type="step-content">
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('First Name')}}<span class="text-danger">*</span></label>
                                                                        <div class="col-lg-9 col-xl-9">
                                                                            <input class="form-control form-control-solid form-control-lg" name="firstName" type="text" value="" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Last Name')}}<span class="text-danger">*</span></label>
                                                                        <div class="col-lg-9 col-xl-9">
                                                                            <input class="form-control form-control-solid form-control-lg" name="lastName" type="text" value="" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Gender')}}<span class="text-danger">*</span></label>
                                                                        <div class="col-lg-9 col-xl-9">
                                                                            <select name="gender" class="form-control form-control-solid form-control-lg">
                                                                                <option selected disabled value="">{{__('Select')}}</option>
                                                                                @foreach($genders as $gender)
                                                                                    <option value="{{$gender->id}}">{{$gender->type}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Date of Birth')}} <span class="text-danger">*</span></label>
                                                                        <div class="col-lg-9 col-xl-9">
                                                                            <div class="form-group">
                                                                                <input class="form-control form-control-solid form-control-lg datepickerk disableKey" type="text" name="DOB" value="" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Nationality')}}<span class="text-danger">*</span></label>
                                                                        <div class="col-lg-9 col-xl-9">
                                                                            <select name="nationality" class="form-control form-control-solid form-control-lg">
                                                                                <option selected disabled value="">{{__('Select')}}</option>
                                                                                @foreach($nationality as $nationality)
                                                                                <option value="{{$nationality->id}}">{{(session()->has('language')) ? $nationality->name_ar : $nationality->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Current country')}}<span class="text-danger">*</span></label>
                                                                        <div class="col-lg-9 col-xl-9">
                                                                            <select name="location" class="form-control form-control-solid form-control-lg">
                                                                                <option selected disabled value="">{{__('Select')}}</option>
                                                                                @foreach($locations as $location)
                                                                                <option value="{{$location->id}}">{{(session()->has('language')) ? $location->name_ar : $location->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Field/Industry')}}<span class="text-danger">*</span></label>
                                                                        <div class="col-lg-9 col-xl-9">
                                                                            <select name="field_of_expertise" id="field_of_expertise" class="form-control select2-container js-example-basic-multiple" multiple="multiple">
                                                                                @foreach($fields as $field)
                                                                                <option value="{{$field->id}}">{{(session()->has('language')) ? $field->category_ar : $field->category}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Interested Country of Work')}}<span class="text-danger">*</span></label>
                                                                        <div class="col-lg-9 col-xl-9">
                                                                            <select name="country_of_interest" id="country_of_interest" class="form-control form-control-solid form-control-lg js-example-basic-multiple1" multiple>
                                                                                @foreach($countryOfInterest as $countryOfInterest)
                                                                                    <option value="{{$countryOfInterest->id}}">{{(session()->has('language')) ? $countryOfInterest->name_ar : $countryOfInterest->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- Step # 3 --}}
                                                                <div class="my-5 step" data-wizard-type="step-content">
                                                                    <h5 class="text-dark font-weight-bold mb-10">{{__('Education Details:')}}</h5>
                                                                    
                                                                    <div class="form-group">
                                                                        <label>{{__('Degree')}} <span class="text-danger">*</span></label>
                                                                        <select name="qualification" id="myDegree" class="form-control form-control-solid form-control-lg">
                                                                            <option selected disabled value="">{{__('Select')}}</option>
                                                                            @foreach($qualifications as $qualification)
                                                                                <option value="{{$qualification->id}}">{{(session()->has('language')) ? $qualification->name_ar : $qualification->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div id="myDegreeDiv">
                                                                        <div class="form-group">
                                                                            <label>{{__('Field of study')}} <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control form-control-solid form-control-lg" name="field_of_study" placeholder="" value="" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{__('Institution Name')}} <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control form-control-solid form-control-lg" name="institution" placeholder="" value="" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{__('Description')}} <span class="text-danger">*</span></label>
                                                                            <textarea type="text" class="form-control form-control-solid form-control-lg" name="description" rows="3" maxlength="255" placeholder=""></textarea>
                                                                            <span class="form-text text-muted">{{__('Description can be of no more than 255 characters')}}</span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-xl-4">
                                                                                <!--begin::Group-->
                                                                                <div class="form-group">
                                                                                    <label>{{__('Starting Date')}}<span class="text-danger">*</span></label>
                                                                                    <input class="form-control form-control-solid form-control-lg datepickerk disableKey" type="text" name="starting_date" value="" id="educationeStartingDate"/>
                                                                                </div>
                                                                            </div>
                                                                            <!--end::Group-->
                                                                            <!--begin::Group-->
                                                                            <div class="col-xl-4">
                                                                                <div class="form-group">
                                                                                    <label>{{__('Ending Date')}} <span class="text-danger">*</span></label>
                                                                                    <input class="form-control form-control-solid form-control-lg datepickerk disableKey" type="text" name="ending_date" value="" id="educationeEndingDate"/>
                                                                                </div>
                                                                            </div>
                                                                            <!--end::Group-->

                                                                            <!--begin::Group-->
                                                                            <div class="col-xl-4">
                                                                                <div class="form-group">
                                                                                    <label>{{__('If present select')}} </label>
                                                                                    <div class="col-9 col-form-label">
                                                                                        <div class="checkbox-inline">
                                                                                            <label class="checkbox checkbox-success">
                                                                                                <input type="checkbox" class="educationPresent" id="education_present" name="educationPresent" />
                                                                                                <span></span>
                                                                                                {{__(' Present')}}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!--end::Group-->
                                                                        </div>
                                                                    </div>

                                                                    <h5 class="text-dark font-weight-bold mb-10">{{__('Experience Details')}}</h5>
                                                               
                                                                    <div class="form-group">
                                                                        <div class="checkbox-inline">
                                                                            <label class="checkbox checkbox-success">
                                                                                <input type="checkbox" class="noExperience" id="no_experience" name="noExperience" />
                                                                                <span></span>
                                                                                {{__('No Experience')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>

                                                                    <div id="myExperienceDiv">
                                                                        <div class="form-group">
                                                                            <label>{{__('Company Name')}} <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control form-control-solid form-control-lg"  placeholder="Enter Name" name="company" id="company"/>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{__('Location')}} <span class="text-danger">*</span></label>
                                                                            <select name="company_location" class="form-control form-control-solid form-control-lg" id="company_location">
                                                                                <option selected value="">{{__('Select')}}</option>
                                                                                @foreach($countries as $country)
                                                                                    <option value="{{$country->id}}">{{(session()->has('language')) ? $country->name_ar : $country->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{__('Position/Title')}} <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control form-control-solid form-control-lg" name="position" placeholder="" value="" id="position" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>{{__('Description')}} <span class="text-danger">*</span></label>
                                                                            <textarea type="text" class="form-control form-control-solid form-control-lg" name="experience_description" rows="3" maxlength="255" placeholder="" id="experience_description"></textarea>
                                                                            <span class="form-text text-muted">{{__('Description can be of no more than 255 characters')}}</span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-xl-4">
                                                                                <div class="form-group">
                                                                                    <label>{{__('Starting Date')}} <span class="text-danger">*</span></label>
                                                                                    <input class="form-control form-control-solid form-control-lg datepickerk disableKey" type="text" name="experience_starting_date" value="" id="experienceStartingDate"/>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-xl-4">
                                                                                <div class="form-group">
                                                                                    <label>{{__('Ending Date')}} <span class="text-danger">*</span></label>
                                                                                    <input class="form-control form-control-solid form-control-lg datepickerk disableKey" type="text" name="experience_ending_date" value="" id="experienceEndingDate"/>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-xl-4">
                                                                                <div class="form-group">
                                                                                    <label>{{__('If present select')}} </label>
                                                                                    <div class="col-9 col-form-label">
                                                                                        <div class="checkbox-inline">
                                                                                            <label class="checkbox checkbox-success">
                                                                                                <input type="checkbox" class="experiencePresent" id="experience_present" name="experiencePresent" />
                                                                                                <span></span>
                                                                                                {{__(' Present')}}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- Step # 4 --}}
                                                                <div class="my-5 step" data-wizard-type="step-content">
                                                                    <div id="sessionData">
                                                                        <h5 class="mb-10 font-weight-bold text-dark" style="text-align: center">Review your Details and Submit</h5>
                                                                        @if (session()->has('candidateSessionData'))
                                                                            <h6 class="font-weight-bolder mb-3"><mark>{{__('Account details:')}}</mark></h6>
                                                                            <div class="text-dark-50 line-height-lg">
                                                                                <div><strong>{{__('Email:')}} </strong> {{session()->get("candidateSessionData")['email']}}</div>
                                                                                <div><strong>{{__('Phone Number:')}} </strong> {{session()->get("candidateSessionData")['phone']}}</div>
                                                                            </div>
                                                                            <div class="separator separator-dashed my-5"></div>
                                                                            <!--end::Section-->
                                                                            <!--begin::Section-->
                                                                            <h6 class="font-weight-bolder mb-3"><mark>{{__('Basic Information:')}}</mark></h6>
                                                                            <div class="text-dark-50 line-height-lg">
                                                                                <div><strong>{{__('First Name:')}} </strong> {{session()->get("candidateSessionData")['firstName']}} </div>
                                                                                <div><strong>{{__('Last Name:')}} </strong>  {{session()->get("candidateSessionData")['lastName']}}</div>
                                                                                <div><strong>{{__('Gender:')}} </strong> @if(isset(session()->get("candidateSessionData")['gender'][0])) {{session()->get("candidateSessionData")['gender'][0]}} @endif </div>
                                                                                <div><strong>{{__('Date of birth:')}} </strong>  {{\Carbon\Carbon::parse(session()->get("candidateSessionData")['DOB'])->format('l, M d, Y')}}</div>
                                                                                <div><strong>{{__('Nationality:')}} </strong>  @if(isset(session()->get("candidateSessionData")['nationality'][0])) {{session()->get("candidateSessionData")['nationality'][0]}} @endif </div>
                                                                                <div><strong>{{__('Current country:')}} </strong> @if(isset(session()->get("candidateSessionData")['location'][0])) {{session()->get("candidateSessionData")['location'][0]}} @endif </div>
                                                                                <div><strong>{{__('Field/Industry:')}} </strong> @foreach(session()->get("candidateSessionData")['field_of_expertise'] as $item)  {{$item->category}}  @if (!$loop->last) {{','}} @endif @endforeach </div>
                                                                                <div><strong>{{__('Interested Country of Work:')}} </strong> @foreach(session()->get("candidateSessionData")['interestCountry'] as $item) {{$item->name}} @if (!$loop->last) {{','}} @endif @endforeach </div>
                                                                            </div>
                                                                            <!--end::Section-->
                                                                            <div class="separator separator-dashed my-5"></div>
                                                                            <!--begin::Section-->
                                                                            <h6 class="font-weight-bolder mb-3"><mark>{{__('Education/Experience Information:')}}</mark></h6>
                                                                            <div class="text-dark-50 line-height-lg">
                                                                                <div><strong><u>{{__('Education information')}}</u></strong> </div>
                                                                                @if(isset(session()->get("candidateSessionData")['qualification'][0]))
                                                                                    @if(session()->get("candidateSessionData")['qualification'][0] != 'No Degree')
                                                                                        <div><strong>{{__('Degree:')}} </strong> @if(isset(session()->get("candidateSessionData")['qualification'][0])) {{session()->get("candidateSessionData")['qualification'][0]}} @endif  </div>
                                                                                        <div><strong>{{__('Description:')}} </strong>   {{session()->get("candidateSessionData")['description']}}</div>
                                                                                        <div><strong>{{__('Starting Date:')}} </strong> {{\Carbon\Carbon::parse(session()->get("candidateSessionData")['starting_date'])->format('l, M d, Y')}}</div>
                                                                                        <div><strong>{{__('Ending Date:')}} </strong> {{ (session()->get("candidateSessionData")['ending_date'] == null) ? 'Present' : \Carbon\Carbon::parse(session()->get("candidateSessionData")['ending_date'])->format('l, M d, Y') }}</div>
                                                                                    @else
                                                                                        <div><strong>{{__('Not Available')}}</strong></div>
                                                                                    @endif
                                                                                @endif

                                                                                <br>
                                                                                
                                                                                <div><strong><u>{{__('Experience information')}} </u></strong> </div>
                                                                                @if(session()->get("candidateSessionData")['no_experience'] == 0)
                                                                                    <div><strong>{{__('Company Name:')}} </strong>  {{session()->get("candidateSessionData")['company']}}</div>
                                                                                    <div><strong>{{__('Company Location:')}} </strong> @if(isset(session()->get("candidateSessionData")['company_location'][0])) {{session()->get("candidateSessionData")['company_location'][0]}} @endif </div>
                                                                                    <div><strong>{{__('Position/Title:')}} </strong>  {{session()->get("candidateSessionData")['position']}}</div>
                                                                                    <div><strong>{{__('Experience Description:')}} </strong>  {{session()->get("candidateSessionData")['experience_description']}}</div>
                                                                                    <div><strong>{{__('Experience Starting Date:')}} </strong>  {{\Carbon\Carbon::parse(session()->get("candidateSessionData")['experience_starting_date'])->format('l, M d, Y') }}</div>
                                                                                    <div><strong>{{__('Experience Ending Date:')}} </strong>  {{ (session()->get("candidateSessionData")['experience_ending_date'] == null) ? 'Present' : \Carbon\Carbon::parse(session()->get("candidateSessionData")['experience_ending_date'])->format('l, M d, Y') }}</div>
                                                                                @else
                                                                                    <div><strong>{{__('Not Available')}}</strong></div>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                {{-- Next / Submit Buttons --}}
                                                                <div class="d-flex justify-content-between border-top pt-10 mt-15">
                                                                    <div class="mr-2">
                                                                        <button type="button" style="background-color: rgba(204, 73, 74, 0.2);border:none;color:rgb(204, 73, 74)" id="prev-step" class="btn btn-light-primary font-weight-bolder px-9 py-4" data-wizard-type="action-prev">{{__('Previous')}}</button>
                                                                    </div>
                                                                    <div>
                                                                        <button type="submit" style="background-color: rgb(204, 73, 74);border:none" class="btn btn-success font-weight-bolder px-9 py-4" data-wizard-type="action-submit">{{__('Submit')}}</button>
                                                                        <button type="button" style="background-color: rgb(204, 73, 74);border:none" id="next-step" class="btn btn-primary font-weight-bolder px-9 py-4" data-wizard-type="action-next">{{__('Next')}}</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </form>
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

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
        <script>
            var route="{{route('candidateRegister')}}";
            var candidateData="{{route('candidateData')}}";

            $( "#myDegree" ).change(function() {
                if(this.value == 1){
                    $('#myDegreeDiv').css('display', 'none');
                }
                else{
                    $('#myDegreeDiv').css('display', 'block');
                }
            });

            $( "#no_experience" ).change(function() {
                if($(this).is(':checked')){
                    $('#myExperienceDiv').css('display', 'none');
                }
                else{
                    $('#myExperienceDiv').css('display', 'block');
                }
            });

            $(".experiencePresent").click(e => clickedExperiencedFuntion(e));

            function clickedExperiencedFuntion(e){
                if($('#experience_present').is(':checked')){
                    $('#experienceEndingDate').prop('disabled',true);
                }
                else{
                    $('#experienceEndingDate').prop('disabled',false);
                }
            }

            $(".educationPresent").click(e => clickedEducationFuntion(e));

            function clickedEducationFuntion(e){
                if($('#education_present').is(':checked')){
                    $('#educationeEndingDate').prop('disabled',true);
                }
                else{
                    $('#educationeEndingDate').prop('disabled',false);
                }
            }
        </script>
        <script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
        <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
        <script src="{{asset('/public/candidate/dist/assets/plugins/global/plugins.bundle.js')}}"></script>
        <script src="{{asset('/public/candidate/dist/assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
        <script src="{{asset('/public/candidate/dist/assets/js/scripts.bundle.js')}}"></script>
        <script src="{{asset('/public/candidate/dist/assets/js/pages/custom/user/add-user.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.0/flatpickr.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(document).ready( function () {

                $(".datepickerk").datepicker({
                    shortYearCutoff: 1,
                    dateFormat: "yy-mm-dd",
                    changeMonth: true,
                    changeYear: true, 
                    maxDate: 0,
                    yearRange: "1940:2100" 
                });

                $(".disableKey").keypress(function (e) {
                    return false;
                });
                $(".disableKey").keydown(function (e) {
                    return false;
                });
            });
        </script>
    </body>

</html>