@extends('employer.layouts.master')

@section('title')
    Path | Candidate's CV
@endsection

@section('css')
    <style>
        .hoverClass:hover{
            color: blue !important;
        }
    </style>
@endsection

@section('main-content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
                <div style="text-align: end; margin-bottom: 10px">
                    <a onclick="window.print()" class="btn btn-success font-weight-bolder"><i class="la la-print"></i>{{__('Print')}}</a>
                    <a href="{{route('saveCvPdf', encrypt($candidate->user_id))}}" target="_blank" class="btn btn-warning font-weight-bolder"><i class="la la-print"></i> {{__('Save PDF')}}</a>
                    <a href="{{url()->previous()}}" class="btn btn-primary font-weight-bolder"><i class="la la-backspace"></i> {{__('Go Back')}}</a>
                </div>
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-body">
                    <!--begin::Details-->
                    <div class="d-flex mb-9">
                        <!--begin: Pic-->
                        <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                            <div class="symbol symbol-50 symbol-lg-120">
                                @if($candidate->avatar != null)
                                    <img src=" {{ asset('images/'.$candidate->avatar) }}" alt="image" />
                                @else
                                    <img  src="{{asset('public/employer/dist/assets/media/noimage.png')}}" alt="image" />
                                @endif
                            </div>
                            <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                                <span class="font-size-h3 symbol-label font-weight-boldest">JM</span>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between flex-wrap mt-1">
                                <div class="d-flex mr-3">
                                    <span style="cursor: pointer" class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{$candidate->firstName}} {{$candidate->lastName}}</span>
                                    <a href="#">
                                        {{-- <i class="flaticon2-correct text-success font-size-h5"></i> --}}
                                    </a>
                                </div>
                                <div class="my-lg-0 my-3">
                                </div>
                            </div>
                            <!--end::Title-->
                            <!--begin::Content-->
                            <div class="d-flex flex-wrap justify-content-between mt-1">
                                <div class="d-flex flex-column flex-grow-1 pr-8">
                                    <div class="d-flex flex-wrap mb-4">
                                        <a href="#" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i class="flaticon2-new-email mr-2 font-size-lg"></i>{{$candidate->email}}</a>
                                        <a href="#" class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <i class="flaticon2-phone mr-2 font-size-lg"></i>{{$candidate->phoneNo}}</a>
                                        {{--  <a href="#" class="text-dark-50 text-hover-primary font-weight-bold">
                                            @php $location = DB::table('countries')->where('id', $candidate->location)->first(); @endphp
                                            <i class="flaticon2-placeholder mr-2 font-size-lg"></i>{{$location->name}}</a>  --}}
                                    </div>
                                    <span class="font-weight-bold text-dark-50">{{$candidate->about}}</span>
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <div class="separator separator-solid"></div>

                    <div class="d-flex align-items-center flex-wrap mt-8">

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
                            <span class="mr-4">
                                <i class="flaticon-avatar display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Gender')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                <span class="text-dark-50 font-weight-bold"></span>@if($candidate->gender == 1) Male @elseif($candidate->gender == 2) Female @else Other @endif</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
                            <span class="mr-4">
                                <i class="flaticon-analytics display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Experience')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                    @php
                                        use Carbon\Carbon;
                                        $experiences = DB::table('candidate_experiences')
                                            ->where('user_id', $candidate->user_id)
                                            ->get();

                                        $total = 0;

                                        if (count($experiences) > 0)
                                        {
                                            foreach ($experiences as $key=>$value)
                                            {
                                                $datetime1 = Carbon::createFromDate($value->experience_starting_date);
                                                $datetime2 = Carbon::createFromDate($value->experience_ending_date);
                                                $intervals[] = $datetime1->diffInDays($datetime2);
                                            }

                                            foreach ($intervals as $key => $value)
                                            {
                                                $total += $value;
                                            }
                                        }
                                    @endphp
                                <span class="text-dark-50 font-weight-bold"></span>
                                    @if ($total <= 365)
                                        Less than one year
                                    @elseif($total > 365 && $total <= 730)
                                        1 Year
                                    @elseif($total > 730 && $total <= 1095)
                                        2 Years
                                    @elseif($total > 1095 && $total <= 1460)
                                        3 Years
                                    @elseif($total > 1460 && $total <= 1825)
                                        4 Years
                                    @elseif($total > 1825)
                                        5+ Years
                                    @else
                                        No Experience
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
                            <span class="mr-4">
                                <i class="flaticon-book display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Latest Degree')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                    @php
                                        $candidateDegree = DB::table('candidate_educations')
                                            ->where('user_id', $candidate->user_id)
                                            ->max('degree');
                                        $degree = DB::table('job_qualifications')->where('id', $candidateDegree)->first();
                                    @endphp
                                <span class="text-dark-50 font-weight-bold"></span>
                                    @if(isset($degree)) {{(session()->has('language')) ? $degree->name_ar : $degree->name}} @else No Degree @endif
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
							<span class="mr-4">
                                <i class="flaticon-information display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Age')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>
                                    {{\Carbon\Carbon::parse($candidate->DOB)->diff(\Carbon\Carbon::now())->format('%y years')}}
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
							<span class="mr-4">
                                <i class="flaticon-earth-globe display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Current Location')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>
                                    @php 
                                        $location = DB::table('countries')->where('id', $candidate->location)->first(); 
                                    @endphp
                                    {{(session()->has('language')) ? $location->name_ar : $location->name}}
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
							<span class="mr-4">
                                <i class="flaticon-earth-globe display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Country of Interest')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                    @php 
                                        $countries = explode(',', $candidate->country_of_interest);
                                        $countryOfInterests = DB::table('countries')->whereIn('id', $countries)->get();
                                    @endphp
                                    <span class="text-dark-50 font-weight-bold"></span>
                                    @foreach($countryOfInterests as $countryOfInterest) 
                                        {{(session()->has('language')) ? $countryOfInterest->name_ar : $countryOfInterest->name}}
                                        @if (!$loop->last)
                                            {{" , "}}
                                        @endif
                                    @endforeach
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
							<span class="mr-4">
                                <i class="la la-heart display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Martial Status')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>
                                    {{ ($candidate->maritalStatus == 1) ? __('Single') : __('Married') }}
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
							<span class="mr-4">
                                <i class="flaticon-coins display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Current Salary')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>
                                    @php
                                        $currentCurrency = DB::table('package_currencys')->find($candidate->current_currency);
                                    @endphp
                                    @if(isset($candidate->salary))
                                        {{$candidate->salary}}              
                                        @if(isset($currentCurrency)) {{$currentCurrency->currency_name}} @endif                      
                                    @else 
                                        None 
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
							<span class="mr-4">
                                <i class="flaticon-coins display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Expected Salary')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>
                                    @php
                                        $expectedCurrency = DB::table('package_currencys')->find($candidate->expected_currency);
                                    @endphp
                                    @if(isset($candidate->expected_salary))
                                        {{$candidate->expected_salary}}              
                                        @if(isset($expectedCurrency)) {{$expectedCurrency->currency_name}} @endif                      
                                    @else 
                                        None 
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
							<span class="mr-4">
                                <i class="flaticon-earth-globe display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Nationality')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>
                                    @php 
                                        $nationality = DB::table('nationalities')->find($candidate->nationality); 
                                    @endphp
                                     @if(isset($nationality)) {{(session()->has('language')) ? $nationality->name_ar : $nationality->name}} @else None @endif
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
							<span class="mr-4">
                                <i class="flaticon-book display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Career Level')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold"></span>
                                    @php 
                                        $careerLevel = DB::table('job_career_levels')->find($candidate->career_level); 
                                    @endphp
                                    @if(isset($careerLevel)) {{(session()->has('language')) ? $careerLevel->name_ar : $careerLevel->name}} @else None @endif
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
							<span class="mr-4">
                                <i class="flaticon-speech-bubble-1 display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Languages')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                    @php 
                                        $languages = explode(',', $candidate->language);
                                        $candidateLanguages = DB::table('languages')->whereIn('id', $languages)->get();
                                    @endphp
                                    <span class="text-dark-50 font-weight-bold"></span>
                                    @foreach($candidateLanguages as $candidateLanguage) 
                                        {{(session()->has('language')) ? $candidateLanguage->name_ar : $candidateLanguage->name}}
                                        @if (!$loop->last)
                                            {{" , "}}
                                        @endif
                                    @endforeach
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center flex-lg-fill mr-1 mb-5" style="flex-basis:20% !important">
							<span class="mr-4">
                                <i class="flaticon-graphic display-4 text-muted font-weight-bold"></i>
                            </span>
                            <div class="d-flex flex-column text-dark-75">
                                <span class="font-weight-bolder font-size-sm">{{__('Field Of expertise')}}</span>
                                <span class="font-weight-bolder font-size-h5">
                                    @php $fields = explode(',', $candidate->field_of_expertise);
                                            $expertises = DB::table('employee_bussiness_categories')->whereIn('id', $fields)->get();
                                    @endphp
                                        <span class="text-dark-50 font-weight-bold"></span>
                                    @foreach($expertises as $expertise) {{(session()->has('language')) ? $expertise->category_ar : $expertise->category}}
                                    @if (!$loop->last)
                                        {{" , "}}
                                    @endif
                                    @endforeach</span>
                            </div>
                        </div>
                        
                    </div>

                    <div class="separator separator-solid"></div>

                    @php
                        $counter = 1;
                    @endphp

                    <div class="experience dashboard-section details-section" style="margin-top: 20px">
                        <h4><i data-feather="briefcase"></i><?php echo $counter++ ?>{{__(' - Work Experiance')}}</h4>
                        <br>
                        @foreach ($experiences as $experience)
                            @php
                                $companyLocation = DB::table('countries')->find($experience->company_location);
                            @endphp
                            <div class="experience-section ml-5">
                                <h5><span> {{$experience->company}}</span></h5>
                                <span class="service-year">{{$experience->position}}</span><br>
                                <span class="service-year">{{ \Carbon\Carbon::parse($experience->experience_starting_date)->format('M Y') }} - @if($experience->experience_ending_date == null) Present @else {{ \Carbon\Carbon::parse($experience->experience_ending_date)->format('M Y') }} @endif</span><br>
                                @if(isset($companyLocation))<span class="service-year">{{(session()->has('language')) ? $companyLocation->name_ar : $companyLocation->name}}</span> <br> @endif
                                <p>{{$experience->experience_description}}</p>
                            </div>
                        @endforeach
                        @if(count($experiences)==0)
                            <div class="experience-section ml-5">
                                <span class="service-year">{{__('Not Available')}}</span>
                            </div>
                        @endif
                    </div>

                
                    <div class="edication-background details-section dashboard-section" style="margin-top: 20px">
                        <h4><i data-feather="book"></i><?php echo $counter++ ?> {{__('- Education Background')}}</h4>
                        <br>
                        @foreach ($educations as $education)
                            <div class="education-label ml-5">
                                <h5>{{$education->title}}<span>{{$education->institution}}</span></h5>
                                <span class="service-year">{{$education->field_of_study}}</span><br>
                                <span class="service-year">{{ \Carbon\Carbon::parse($education->starting_date)->format('M Y') }} - @if($education->ending_date == null) Present @else {{ \Carbon\Carbon::parse($education->ending_date)->format('M Y') }} @endif</span><br>
                                <p>{{$education->description}}</p>
                            </div>
                        @endforeach
                        @if(count($educations)==0)
                            <div class="experience-section ml-5">
                                <span class="service-year">{{__('Not Available')}}</span>
                            </div>
                        @endif
                    </div>

                    <div class="edication-background details-section dashboard-section" style="margin-top: 20px">
                        <h4><i data-feather="book"></i><?php echo $counter++ ?> {{__('- Portfolios')}}</h4>
                        <br>
                        @foreach ($portfolios as $portfolio)
                            <div class="education-label ml-5">
                                <span>- </span>  <span class="service-year"><a class="hoverClass" href="{{$portfolio->link}}" style="color:black;" target="_blank">{{$portfolio->title}}</a></span><br>
                            </div>
                        @endforeach
                        @if(count($portfolios)==0)
                            <div class="experience-section ml-5">
                                <span class="service-year">{{__('Not Available')}}</span>
                            </div>
                        @endif
                    </div>

                    @if(!empty($skills))
                        <div class="edication-background details-section dashboard-section" style="margin-top: 20px">
                            <h4><i data-feather="book"></i><?php echo $counter++ ?> {{__('- Skills')}}</h4>
                            <br>
                            @php
                                $skillsNew = DB::table('skills')->whereIn('id', explode(',', $skills->skill))->get();
                            @endphp
                            @foreach ($skillsNew as $skill)
                                <div class="education-label ml-5">
                                    <span class="service-year">- {{(session()->has('language')) ? $skill->name_ar : $skill->name}}</span><br>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
@endsection

@section('script')
@endsection