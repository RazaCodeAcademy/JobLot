<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
		<link href="{{asset('public/employer/dist/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		
        <style>
            /* .section{
                max-width: 1000px;
                margin: auto;
            } */
			.border {
				border-bottom: 1px solid #b7b6be;
			}

			.text-light {
				color: #818796;
			}

			.text-dark {
				color: #333;
			}

			.mr-2 {
				margin-right: 10px;
			}

			.font-size-lg {
				font-size: 20px;
			}

			span {
				margin-right: 15px;
			}

			.section {
				padding: 30px;
			}

			.section-header {
				padding: 0 0 30px 0;
                display: block;
                position: relative;
			}

			.section-header img {
                position: absolute;
                top: 30px;
                left: 30px;
				border-radius: 8px;
                width: 130px;
                height: 130px;
			}

			.section-description {
				padding: 20px 0;
			}

			.display-4 {
				font-size: 20px;
			}

			.card {
				display: inline-block;
                width: 32%;
                margin-top: 30px;
                min-height: 150px;
			}

			.card:last-child {
                margin-left: 30px;
			}
            .card i{
                font-size: 40px;
                color: #818796;
			}

			.flaticon2-correct {
				color: green;
				font-size: 20px;
				margin-left: 20px;
			}
            
            .card-desc{
                display: inline-block;
                margin-left: 10px;
            }
            .card-desc h4{
                font-size: 14px;
                margin: 0 0 10px 0;
            }

            .card-desc p{
                font-size: 18px;
                margin: 0;
                padding: 0;

            }

            .pl-50{
                padding-left: 40px;
            }
		</style>

        @if($candidateImage != null)
            <style>
                .section-desc {
                    padding: 0 20px;
                    margin-left: 160px;
                }
            </style>
        @else
            <style>
                .section-desc {
                    padding: 0 20px;
                    margin-left: 0px;
                }
            </style>
        @endif
		<title>CV</title>
	</head>

	<body>
		<section class="section">
			<div class="section-header border">
                @if($candidateImage != null)
                    <img src="data:image/jpeg;base64,{{$candidateImage}}" alt="image">
                @endif
				<div class="section-desc">
					<h3 class="text-dark">{{$candidate->firstName}} {{$candidate->lastName}}</h3>
					<span class="text-light">
                        <i class="flaticon2-new-email mr-2 font-size-lg"></i> {{$candidate->email}}
                    </span>
					<span class="text-light">
                        <i class="flaticon2-phone mr-2 font-size-lg"></i> {{$candidate->phoneNo}}
                    </span>
					<p class="text-light">
						{{$candidate->about}}
					</p>
				</div>
			</div>

			<div class="section-description border">
				<div class="card">
						<i class="flaticon-avatar display-4"></i>
					<div class="card-desc">
						<h4>{{__('Gender')}}</h4>
						<p>@if($candidate->gender == 1) {{__('Male')}} @elseif($candidate->gender == 2) {{__('Female')}} @else {{__('Other')}} @endif</p>
					</div>
				</div>

				<div class="card">
						<i class="flaticon-analytics display-4"></i>
                    @php
                        use Carbon\Carbon;
                        $experiences = DB::table('candidate_experiences')
                            ->where('user_id', $candidate->user_id)
                            ->get();

                        $total = 0;

                        if (isset($experiences))
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
					<div class="card-desc">
						<h4>{{__('Experience')}}</h4>
						<p>
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
                        </p>
					</div>
				</div>

				<div class="card">
						<i class="flaticon-book display-4"></i>
					<div class="card-desc">
						<h4>{{__('Latest Degree')}}</h4>
                        @php
                            $candidateDegree = DB::table('candidate_educations')
                                ->where('user_id', $candidate->user_id)
                                ->max('degree');
                            $degree = DB::table('job_qualifications')->where('id', $candidateDegree)->first();
                        @endphp
						<p>@if(isset($degree)) {{(session()->has('language')) ? $degree->name_ar : $degree->name}} @else No Degree @endif</p>
					</div>
				</div>

                <br>

                <div class="card">
                    <i class="flaticon-information display-4"></i>
                    <div class="card-desc">
                        <h4>{{__('Age')}}</h4>
                        <p>{{\Carbon\Carbon::parse($candidate->DOB)->diff(\Carbon\Carbon::now())->format('%y years')}}</p>
                    </div>
                </div>

                <div class="card">
                    <i class="flaticon-earth-globe display-4"></i>
                    <div class="card-desc">
                        <h4>{{__('Current Location')}}</h4>
                        @php 
                            $location = DB::table('countries')->where('id', $candidate->location)->first(); 
                        @endphp
                        <p>{{(session()->has('language')) ? $location->name_ar : $location->name}}</p>
                    </div>
                </div>

                <div class="card">
                    <i class="flaticon-earth-globe display-4"></i>
                    <div class="card-desc">
                        <h4>{{__('Country of Interest')}}</h4>
                        @php 
                            $countries = explode(',', $candidate->country_of_interest);
                            $countryOfInterests = DB::table('countries')->whereIn('id', $countries)->get();
                        @endphp
                        <p>
                            @foreach($countryOfInterests as $countryOfInterest) 
                                {{(session()->has('language')) ? $countryOfInterest->name_ar : $countryOfInterest->name}}
                                @if (!$loop->last)
                                    {{" , "}}
                                @endif
                            @endforeach
                        </p>
                    </div>
                </div>

                <br>

                <div class="card">
                    <i class="la la-heart display-4"></i>
                    <div class="card-desc">
                        <h4>{{__('Martial Status')}}</h4>
                        <p>{{ ($candidate->maritalStatus == 1) ? __('Single') : __('Married') }}</p>
                    </div>
                </div>

                <div class="card">
                    <i class="flaticon-coins display-4"></i>
                    <div class="card-desc">
                        <h4>{{__('Current Salary')}}</h4>
                        @php
                            $currentCurrency = DB::table('package_currencys')->find($candidate->current_currency);
                        @endphp
                        <p>
                            @if(isset($candidate->salary))
                                {{$candidate->salary}}              
                                @if(isset($currentCurrency)) {{$currentCurrency->currency_name}} @endif                      
                            @else 
                                None 
                            @endif
                        </p>
                    </div>
                </div>

                <div class="card">
                    <i class="flaticon-coins display-4"></i>
                    <div class="card-desc">
                        <h4>{{__('Expected Salary')}}</h4>
                        @php
                            $expectedCurrency = DB::table('package_currencys')->find($candidate->expected_currency);
                        @endphp
                        <p>
                            @if(isset($candidate->expected_salary))
                                {{$candidate->expected_salary}}              
                                @if(isset($expectedCurrency)) {{$expectedCurrency->currency_name}} @endif                      
                            @else 
                                None 
                            @endif
                        </p>
                    </div>
                </div>

                <br>

                <div class="card">
                    <i class="flaticon-earth-globe display-4"></i>
                    <div class="card-desc">
                        <h4>{{__('Nationality')}}</h4>
                        @php 
                            $nationality = DB::table('nationalities')->find($candidate->nationality); 
                        @endphp
                        <p>@if(isset($nationality)) {{(session()->has('language')) ? $nationality->name_ar : $nationality->name}} @else None @endif</p>
                    </div>
                </div>

                <div class="card">
                    <i class="flaticon-book display-4"></i>
                    <div class="card-desc">
                        <h4>{{__('Career Level')}}</h4>
                        @php 
                            $careerLevel = DB::table('job_career_levels')->find($candidate->career_level); 
                        @endphp
                        <p>@if(isset($careerLevel)) {{(session()->has('language')) ? $careerLevel->name_ar : $careerLevel->name}} @else None @endif</p>
                    </div>
                </div>

                <div class="card">
                    <i class="flaticon-speech-bubble-1 display-4"></i>
                    <div class="card-desc">
                        <h4>{{__('Languages')}}</h4>
                        @php 
                            $languages = explode(',', $candidate->language);
                            $candidateLanguages = DB::table('languages')->whereIn('id', $languages)->get();
                        @endphp
                        <p>
                            @foreach($candidateLanguages as $candidateLanguage) 
                                {{(session()->has('language')) ? $candidateLanguage->name_ar : $candidateLanguage->name}}
                                @if (!$loop->last)
                                    {{" , "}}
                                @endif
                            @endforeach
                        </p>
                    </div>
                </div>

                <br>

				<div class="card" style="margin-left: 0px">
					<i class="flaticon-graphic display-4"></i>
					<div class="card-desc">
						<h4>{{__('Field Of expertise')}}</h4>
                        @php 
                            $fields = explode(',', $candidate->field_of_expertise);
                            $expertises = DB::table('employee_bussiness_categories')->whereIn('id', $fields)->get();
                        @endphp
						<p>
                            @foreach($expertises as $expertise) 
                                {{(session()->has('language')) ? $expertise->category_ar : $expertise->category}}
                                @if (!$loop->last)
                                    {{" , "}}
                                @endif
                            @endforeach
                        </p>
					</div>
				</div>
			</div>

            <section>
                @php
                    $counter = 1;
                @endphp
    
                <div class="experience  dashboard-section details-section" style="margin-top: 20px">
                    <h4><i data-feather="briefcase"></i><?php echo $counter++ ?> {{__('- Work Experiance')}}</h4>
                    @foreach ($experiences as $experience)
                        @php
                            $companyLocation = DB::table('countries')->find($experience->company_location);
                        @endphp
                        <div class="experience-section pl-50">
                            <h5><span> {{$experience->company}}</span></h5>
                            <span class="service-year">{{$experience->position}}</span><br>
                            <span class="service-year">{{ \Carbon\Carbon::parse($experience->experience_starting_date)->format('M Y') }} - @if($experience->experience_ending_date == null) Present @else {{ \Carbon\Carbon::parse($experience->experience_ending_date)->format('M Y') }} @endif</span><br>
                            @if(isset($companyLocation))<span class="service-year">{{(session()->has('language')) ? $companyLocation->name_ar : $companyLocation->name}}</span> <br> @endif
                            <p>{{$experience->experience_description}}</p>
                        </div>
                    @endforeach
                    @if(empty($experiences))
                        {{__('Not Available')}}
                    @endif
                </div>
    
                <div class="edication-background details-section dashboard-section" style="margin-top: 20px">
                    <h4><i data-feather="book"></i><?php echo $counter++ ?>{{__(' - Education Background')}}</h4>
                    @foreach ($educations as $education)
                        <div class="education-label pl-50">
                            <h5>{{$education->title}}<span>{{$education->institution}}</span></h5>
                            <span class="service-year">{{$education->field_of_study}}</span><br>
                            <span class="service-year">{{ \Carbon\Carbon::parse($education->starting_date)->format('M Y') }} - @if($education->ending_date == null) Present @else {{ \Carbon\Carbon::parse($education->ending_date)->format('M Y') }} @endif</span><br>
                            <p>{{$education->description}}</p>
                        </div>
                    @endforeach
                    @if(empty($educations))
                        {{__('Not Available')}}
                    @endif
                </div>
    
                <div class="edication-background details-section dashboard-section" style="margin-top: 20px">
                    <h4><i data-feather="book"></i><?php echo $counter++ ?>{{__(' - Portfolios')}}</h4>
                    @foreach ($portfolios as $portfolio)
                        <div class="education-label pl-50">
                            <span>- </span>  <span class="service-year"><a class="hoverClass" href="{{$portfolio->link}}" style="color:black;" target="_blank">{{$portfolio->title}}</a></span><br>
                        </div>
                    @endforeach
                    @if(empty($portfolios))
                        {{__('Not Available')}}
                    @endif
                </div>
    
                @if(!empty($skills))
                    <div class="edication-background details-section dashboard-section" style="margin-top: 20px">
                        <h4><i data-feather="book"></i><?php echo $counter++ ?> {{__('- Skills')}}</h4>
                        @php
                            $skillsNew = DB::table('skills')->whereIn('id', explode(',', $skills->skill))->get();
                        @endphp
                        @foreach ($skillsNew as $skill)
                            <div class="education-label pl-50">
                                <span class="service-year">- {{(session()->has('language')) ? $skill->name_ar : $skill->name}}</span><br>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
		</section>
	</body>
</html>
