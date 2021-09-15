@extends('candidates.layouts.master')

@section('title')
    Job Details
@endsection

@section('css')
@endsection

@section('main-content')

    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Mobile Toggle-->
                    <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none" id="kt_subheader_mobile_toggle">
                        <span></span>
                    </button>
                    <!--end::Mobile Toggle-->
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">{{__('Employer and Job Details')}}</h5>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Profile Personal Information-->
                <div class="d-flex flex-row">
                    <!--begin::Aside-->
                    <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
                        <!--begin::Profile Card-->
                        <div class="card card-custom card-stretch">
                            <!--begin::Header-->
                            <div class="card-header py-3">
                                <div class="card-title align-items-start flex-column">
                                    <h3 class="card-label font-weight-bolder text-dark">{{__('Employer Information')}}</h3>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-4">
                                <!--begin::User-->
                                @php $employer = DB::table('users')->where('id', $job->user_id)->first(); @endphp

                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                        <div class="symbol-label" style="background-image:url({{asset('images/'.$employer->avatar)}})"></div>
                                        <i class="symbol-badge bg-success"></i>
                                    </div>
                                    <div>
                                        <a href="{{route('employerProfileView', encrypt($job->user_id))}}" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{$employer->name}}</a>
                                        @php
                                            $categoryIds = explode(',', $employer->category);
                                            $categories =  DB::table('employee_bussiness_categories')->whereIn('id', $categoryIds)->get();
                                        @endphp
                                        <div class="text-muted">@foreach($categories as $category) {{(session()->has('language')) ? $category->category_ar : $category->category}} @if (!$loop->last) , @endif  @endforeach</div>
                                        <div class="mt-2">
                                        </div>
                                    </div>
                                </div>
                                <!--end::User-->
                                <!--begin::Contact-->
                                <div class="py-9">
                                    {{-- <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="font-weight-bold mr-2">{{__('Email:')}}</span>
                                        <a href="#" class="text-muted text-hover-primary">{{$employer->email}}</a>
                                    </div> --}}
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="font-weight-bold mr-2">{{__('Phone:')}}</span>
                                        <span class="text-muted">{{$employer->phoneNo}}</span>
                                    </div>
                                    @if(isset($employer->phoneNo2))
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="font-weight-bold mr-2">{{__('Phone:')}}</span>
                                        <span class="text-muted">{{$employer->phoneNo2}}</span>
                                    </div>
                                    @endif

                                    @if(isset($employer->companyPhoneNo))

                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="font-weight-bold mr-2">{{__('Phone')}}:</span>
                                            <span class="text-muted">{{$employer->companyPhoneNo}}</span>
                                        </div>
                                    @endif

                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        @php $location = DB::table('countries')->where('id', $employer->country_name)->first(); @endphp
                                        <span class="font-weight-bold mr-2">Location:</span>
                                        <span class="text-muted">{{(session()->has('language')) ? $location->name_ar : $location->name}} </span>
                                    </div>

                                    @if(isset($employer->companyWebAddress))

                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="font-weight-bold mr-2">Website:</span>
                                            <span class="text-muted"><a  target="_blank" href="{{$employer->companyWebAddress}}">{{__('Link')}}</a></span>
                                        </div>
                                    @endif

                                    @if($employer->twitter != null)
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="font-weight-bold mr-2"><i class="la la-twitter"></i></span>
                                            <span class="text-muted"><a  target="_blank" href="{{$employer->twitter}}">{{__('Profile')}}</a></span>
                                        </div>
                                    @endif
                                    @if($employer->linkedin != null)
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="font-weight-bold mr-2"><i class="la la-linkedin"></i></span>
                                            <span class="text-muted"><a  target="_blank" href="{{$employer->linkedin}}">{{__('Profile')}}</a></span>
                                        </div>
                                    @endif
                                    @if($employer->instagram != null)
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="font-weight-bold mr-2"><i class="la la-instagram"></i></span>
                                            <span class="text-muted"><a  target="_blank" href="{{$employer->instagram}}">{{__('Profile')}}</a></span>
                                        </div>
                                    @endif

                                    
                                </div>
                                <!--end::Contact-->
                                <!--begin::Nav-->
                                <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                                    <div class="navi-item mb-2">
                                        <a href="{{route('employerProfileView', encrypt($job->user_id))}}" class="navi-link py-4">
                                            <span class="navi-icon mr-2">
                                                <span class="svg-icon">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
                                                            <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text font-size-lg">{{__('Profile Overview')}}</span>
                                        </a>
                                    </div>
                                </div>
                                <!--end::Nav-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Profile Card-->
                    </div>
                    <!--end::Aside-->
                    <!--begin::Content-->
                    <div class="flex-row-fluid ml-lg-8">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch">
                            <!--begin::Header-->
                            <div class="card-header py-3">
                                <div class="card-title align-items-start flex-column">
                                    <h3 class="card-label font-weight-bolder text-dark">{{__('Job Information')}}</h3>
                                </div>
                                <div class="card-toolbar">
                                    @php $appliedJobs = DB::table('candidate_applied_jobs')->where('job_id', $job->id)->where('user_id', Auth::user()->id)->first(); @endphp
                                    <a @if(isset($appliedJobs)) class="btn btn-danger mr-2" style="cursor: no-drop" @else href="{{route('jobApply',  ['id' => $job->id, 'user_id'=>$job->user_id])}}" class="btn btn-success mr-2" @endif >@if(isset($appliedJobs)) Applied @else Apply @endif</a>
                                    <a href="{{url()->previous()}}" class="btn btn-secondary">{{__('Back')}}</a>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Entry-->
                            <div class="d-flex flex-column-fluid">
                                <!--begin::Container-->
                                <div class="container-fluid">
                                    <!--begin::Card-->
                                    <div class="card card-custom gutter-b">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <!--begin: Pic-->
                                                <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                                                    <div class="symbol symbol-50 symbol-lg-120">
                                                        <img alt="Pic" src="{{asset('images/'.$employer->avatar)}}" />
                                                    </div>
                                                    <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                                                        <span class="font-size-h3 symbol-label font-weight-boldest">JM</span>
                                                    </div>
                                                </div>
                                                <!--end: Pic-->
                                                <!--begin: Info-->
                                                <div class="flex-grow-1">
                                                    <!--begin: Title-->
                                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                        <div class="mr-3">
                                                            <!--begin::Name-->
                                                            <a class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">{{ (session()->has('language')) ? $job->title_ar : $job->title }}
                                                                <i class="flaticon2-correct text-success icon-md ml-2"></i></a>
                                                            <!--end::Name-->
                                                            <!--begin::Contacts-->
                                                            <div class="d-flex flex-wrap my-2">
                                                                {{-- <a class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
															<span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
																		<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
																	</g>
																</svg>
															</span>{{$employer->email}}</a> --}}
                                                                <a class="text-muted text-hover-primary font-weight-bold">
                                                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Map/Marker2.svg-->
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0" width="24" height="24" />
                                                                                <path d="M9.82829464,16.6565893 C7.02541569,15.7427556 5,13.1079084 5,10 C5,6.13400675 8.13400675,3 12,3 C15.8659932,3 19,6.13400675 19,10 C19,13.1079084 16.9745843,15.7427556 14.1717054,16.6565893 L12,21 L9.82829464,16.6565893 Z M12,12 C13.1045695,12 14,11.1045695 14,10 C14,8.8954305 13.1045695,8 12,8 C10.8954305,8 10,8.8954305 10,10 C10,11.1045695 10.8954305,12 12,12 Z" fill="#000000" />
                                                                            </g>
                                                                        </svg>
                                                                        <!--end::Svg Icon-->
                                                                        @php $jobLocation = DB::table('countries')->where('id', $job->job_location)->first(); @endphp
                                                                    </span>{{(session()->has('language')) ? $jobLocation->name_ar : $jobLocation->name}}
                                                                </a>

                                                                <div class="dropdown">
                                                                    <a class="dropdown-toggle" style="cursor: pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fa fa-share-alt ml-2 mr-1 font-size-lg"></i> Share
                                                                    </a>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" style="cursor: pointer" onclick="copyLink('{{route('jobDetails', $job->slug)}}')">{{__('Copy Link')}}</a>
                                                                        <a class="dropdown-item" href="whatsapp://send?text={{route('jobDetails', $job->slug)}}" data-action="share/whatsapp/share">Whatsapp</a>
                                                                        <a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{route('jobDetails', $job->slug)}}" target="_blank">Facebook</a>
                                                                        <a class="dropdown-item" href="https://twitter.com/intent/tweet?url={{route('jobDetails', $job->slug)}}" target="_blank">Twitter</a>
                                                                        {{--  <a class="dropdown-item" href="https://www.instagram.com/?url={{route('jobDetails', $job->slug)}}" target="_blank">Instagram</a>  --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Contacts-->
                                                        </div>
                                                    </div>
                                                    <!--end: Title-->
                                                    <!--begin: Content-->
                                                    <div class="d-flex align-items-center flex-wrap justify-content-between">
                                                        <div class="flex-grow-1 font-weight-bold text-dark-50 py-5 py-lg-2 mr-5">
                                                            <span style="word-break: break-all;">{!! htmlspecialchars_decode($job->description) !!}</span>
                                                        </div>

                                                        <div class="d-flex flex-wrap align-items-center py-2">
                                                            <div class="d-flex align-items-center mr-10">
                                                                <div class="mr-6">
                                                                    <div class="font-weight-bold mb-2">{{__('Start Date')}}</div>
                                                                    <span class="btn btn-sm btn-text btn-light-primary text-uppercase font-weight-bold">{{\Carbon\Carbon::parse($job->date)->format('d M Y')}}</span>
                                                                </div>
                                                                <div class="">
                                                                    <div class="font-weight-bold mb-2">{{__('End Date')}}</div>
                                                                    <span class="btn btn-sm btn-text btn-light-danger text-uppercase font-weight-bold">{{\Carbon\Carbon::parse($job->endingDate)->format('d M Y')}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 flex-shrink-0 w-150px w-xl-300px mt-4 mt-sm-0">
{{--                                                                <span class="font-weight-bold">{{__('Progress')}}</span>--}}
{{--                                                                <div class="progress progress-xs mt-2 mb-2">--}}
{{--                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 63%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                                                </div>--}}
{{--                                                                <span class="font-weight-bolder text-dark">78%</span>--}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end: Content-->
                                                </div>
                                                <!--end: Info-->
                                            </div>
                                            <div class="separator separator-solid my-7"></div>
                                            <!--begin: Items-->
                                            <div class="d-flex align-items-center flex-wrap">
                                                <!--begin: Item-->
                                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
												<span class="mr-4">
													<i class="flaticon-analytics display-4 text-muted font-weight-bold"></i>
												</span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">{{__('Experience')}}</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                          <span class="text-dark-50 font-weight-bold"></span>
                                                            @if ($job->experience == 1)
                                                                Min 1 Year
                                                            @elseif ($job->experience == 2)
                                                                Less than one year
                                                            @elseif($job->experience == 3)
                                                                1 Year
                                                            @elseif($job->experience == 4)
                                                                2 Years
                                                            @elseif($job->experience == 5)
                                                                3 Years
                                                            @elseif($job->experience == 6)
                                                                4 Years
                                                            @elseif($job->experience == 7)
                                                                5+ Years
                                                            @else
                                                                No Experience
                                                            @endif
                                                         </span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
												<span class="mr-4">
													<i class="flaticon-information display-4 text-muted font-weight-bold"></i>
												</span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        @php $field = DB::table('employee_bussiness_categories')->where('id', $job->category)->first(); @endphp
                                                        <span class="font-weight-bolder font-size-sm">{{__('Field Of expertise')}}</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            {{(session()->has('language')) ? $field->category_ar : $field->category}}
                                                        </span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
												<span class="mr-4">
													<i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>
												</span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">{{__('Salary Range')}}</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                        <span class="text-dark-50 font-weight-bold"></span>{{$job->salary}}</span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
												<span class="mr-4">
													<i class="flaticon-map-location icon-2x text-muted font-weight-bold"></i>
												</span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">{{__('Job Location')}}</span>
                                                        <span class="font-weight-bolder font-size-h5">
													   {{(session()->has('language')) ? $jobLocation->name_ar : $jobLocation->name}}</span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
												<span class="mr-4">
													<i class="flaticon-book icon-2x text-muted font-weight-bold"></i>
												</span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">{{__('Degree')}}</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            @php $degree = DB::table('job_qualifications')->where('id', $job->qualification)->first(); @endphp
													   {{(session()->has('language')) ? $degree->name_ar : $degree->name}}</span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
												<span class="mr-4">
													<i class="flaticon-statistics icon-2x text-muted font-weight-bold"></i>
												</span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">{{__('Career Level')}}</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            @php $career = DB::table('job_career_levels')->where('id', $job->career_level)->first(); @endphp
													   {{(session()->has('language')) ? $career->name_ar : $career->name}}</span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
												<span class="mr-4">
													<i class="flaticon-folder icon-2x text-muted font-weight-bold"></i>
												</span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">{{__('Job Type')}}</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            @php $jobType = DB::table('job_types_tables')->find($job->type); @endphp @if(isset($jobType)) {{(session()->has('language')) ? $jobType->name_ar : $jobType->name }} @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                                <!--begin: Item-->
                                                <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
												<span class="mr-4">
													<i class="flaticon-user icon-2x text-muted font-weight-bold"></i>
												</span>
                                                    <div class="d-flex flex-column text-dark-75">
                                                        <span class="font-weight-bolder font-size-sm">{{__('Gender')}}</span>
                                                        <span class="font-weight-bolder font-size-h5">
                                                            {{$job->gender}}</span>
                                                    </div>
                                                </div>
                                                <!--end: Item-->
                                            </div>

                                            @if(isset($job->responsibilities))
                                            <!--begin: Info-->
                                                <div class="separator separator-solid my-7"></div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                                    <span class="mr-4">
                                                        <i class="flaticon-list display-4 text-muted font-weight-bold"></i>
                                                    </span>
                                                        <div class="d-flex flex-column text-dark-75">
                                                            <span class="font-weight-bolder font-size-sm">{{__('Responsibilities:')}}</span>
                                                        </div>
                                                    </div>
                                                 </div>
                                                <span>
                                                    {!! htmlspecialchars_decode($job->responsibilities) !!}
                                                </span>
                                            @endif

                                            @if(isset($job->description))
                                            <!--begin: Info-->
                                                <div class="separator separator-solid my-7"></div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                                    <span class="mr-4">
                                                        <i class="flaticon-list display-4 text-muted font-weight-bold"></i>
                                                    </span>
                                                        <div class="d-flex flex-column text-dark-75">
                                                            <span class="font-weight-bolder font-size-sm">{{__('Description:')}}</span>
                                                        </div>
                                                    </div>
                                                 </div>
                                                <span>
                                                    {!! htmlspecialchars_decode($job->description) !!}
                                                </span>
                                            @endif

                                            @if(isset($job->education))
                                            <!--begin: Info-->
                                                <div class="separator separator-solid my-7"></div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                                    <span class="mr-4">
                                                        <i class="flaticon-list display-4 text-muted font-weight-bold"></i>
                                                    </span>
                                                        <div class="d-flex flex-column text-dark-75">
                                                            <span class="font-weight-bolder font-size-sm">{{__('Educations:')}}</span>
                                                        </div>
                                                    </div>
                                                 </div>
                                                <span>
                                                    {!! htmlspecialchars_decode($job->education) !!}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <!--end::Card-->
                                </div>
                                <!--end::Container-->
                            </div>
                            <!--end::Entry-->
                        </div>
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Profile Personal Information-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->

@endsection

@section('script')
    <script>
        function deleteFunction(id) {
            swal({
                title: "Are you sure?",
                text: "Job will be deleted!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            method: "POST",
                            {{--url: "{{route('deleteUser')}}",--}}
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                'id': id
                            },
                            success: function (response) {
                                if(response.status === 1){
                                    swal("Successfully Deleted", {
                                        icon: "success",
                                    });
                                    window.setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                }
                                else{
                                    swal("Error While Deleting", {
                                        icon: "error",
                                    });
                                }
                            }
                        });

                    } else {
                        swal("Your Data is safe!");
                    }
                });
        }
    </script>
@endsection
