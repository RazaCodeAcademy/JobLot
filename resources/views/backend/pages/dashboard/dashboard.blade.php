@extends('backend.layouts.master')

@section('title')
	Dashboard
@endsection

@section('css')
@endsection

@section('main-content')
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Subheader-->
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
			<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
				<div class="d-flex align-items-center flex-wrap mr-2">
					<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{__('Dashboard')}}</h5>
				</div>
			</div>
		</div>

        {{--  @php $user_role_id = DB::table('model_has_roles')->where('model_id', Auth::user()->id)->first();
                     $user = DB::table('roles')->where('id', $user_role_id->role_id)->first();
        @endphp  --}}

        {{--  @if ($user->id == 1)
            <div class="form-group row">
                <label class="col-form-label text-right col-lg-4 col-sm-12">{{__('Filter by country')}}</label>
                <div class="col-lg-4 col-md-9 col-sm-12">
                    <select class="form-control selectpicker" name="country" id="country" data-size="7" data-live-search="true">
                        <option value="0">{{__('All')}}</option>
                        <option data-divider="true" label="Label"></option>
                        @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif  --}}


        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--Begin::Row-->
                <div class="row">
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 29-->
                        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{asset('public/backend/dist/assets/media/svg/shapes/abstract-1.svg')}})">
                            <!--begin::Body-->
                            <div class="card-body">
                                <span class="svg-icon svg-icon-2x svg-icon-info">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z" fill="#000000" opacity="0.3" />
                                            <path d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z" fill="#000000" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                                <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block" id="live-jobs">{{$liveJobs}}</span>
                                <span class="font-weight-bold text-muted font-size-sm">{{__('Total Active Job(s)')}}</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 29-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 30-->
                        <div class="card card-custom bg-info card-stretch gutter-b">
                            <!--begin::Body-->
                            <div class="card-body">
                                <span class="svg-icon svg-icon-2x svg-icon-white">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                                <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block" id="live-candidate-applied-jobs">{{$liveAppliedEmployeeJobs}}</span>
                                <span class="font-weight-bold text-white font-size-sm">{{__('Total candidates active to live jobs')}}</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 30-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 31-->
                        <div class="card card-custom bg-danger card-stretch gutter-b">
                            <!--begin::Body-->
                            <div class="card-body">
                                <span class="svg-icon svg-icon-2x svg-icon-white">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
                                            <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
                                            <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
                                            <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                                <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block" id="total-candidates">{{count($employees)}}</span>
                                <span class="font-weight-bold text-white font-size-sm">{{__('Total Employee(s)')}}</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 31-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Stats Widget 32-->
                        <div class="card card-custom bg-dark card-stretch gutter-b">
                            <!--begin::Body-->
                            <div class="card-body">
                                <span class="svg-icon svg-icon-2x svg-icon-white">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000" />
                                            <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                                <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 text-hover-primary d-block" id="total-employers">{{count($employers)}}</span>
                                <span class="font-weight-bold text-white font-size-sm">{{__('Total Employer(s)')}}</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 32-->
                    </div>
                </div>
                <!--End::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->

        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">{{__('List of new job post(s)')}}
                            <span class="d-block text-muted pt-2 font-size-sm"></span></h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable" id="myCustomTable">
                        <thead>
                        <tr>
                            <th style="text-align:center;">{{__('Name')}}</th>
                            <th style="text-align:center;">{{__('Business Category')}}</th>
                            <th style="text-align:center;">{{__('Job Location')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($jobs as $job)
                            <tr>
                                <td style="text-align:center;"><a href="{{route('employerJobDetail', encrypt($job->id))}}">{{$job->title}}</a></td>
                                <td style="text-align:center;">{{$job->get_bussines_catogories->category ??'N/A'}}</td>
                                <td style="text-align:center;">{{$job->user->comp_location ?? 'N/A'}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</div>
@endsection

@section('script')
   
        <script>
        $("#country").change(function (e) {
            $.ajax({
                url: "{{route('filterCountryDashboard')}}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    country_id: $('#country').val(),
                },
                success: function(data){
                    $('#live-jobs').html(data.values[0]);
                    $('#live-candidate-applied-jobs').html(data.values[1]);
                    $('#total-candidates').html(data.values[2]);
                    $('#total-employers').html(data.values[3]);
                },
                error: function(result){
                    console.log('error');
                }
            });
        });
        </script>
   
@endsection
