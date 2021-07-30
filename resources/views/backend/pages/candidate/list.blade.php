@extends('backend.layouts.master')

@section('title')
    Path | List Candidates
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">List of candidates</h5>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--Begin::Row-->
                <div class="row" style="justify-content: center">
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
                                <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block" id="total-jobs">@if(isset($activeUsers)) {{$activeUsers}} @else 0 @endif</span>
                                <span class="font-weight-bold text-white font-size-sm">Total Active User(s)</span>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 30-->
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
                        <h3 class="card-label">List of Candidates
                            <span class="d-block text-muted pt-2 font-size-sm"></span></h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable" id="myCustomTable">
                        <thead>
                        <tr>
                            <th style="text-align:center;">Name</th>
                            <th style="text-align:center;">Current Country</th>
                            <th style="text-align:center;">Nationality</th>
                            <th style="text-align:center;">Age</th>
                            <th style="text-align:center;">Field of interest</th>
                            <th style="text-align:center;">Last employer name</th>
                            <th style="text-align:center;">Degree</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $user_role_id = DB::table('model_has_roles')->where('model_id', Auth::user()->id)->first();
                              $user = DB::table('roles')->where('id', $user_role_id->role_id)->first();
                        @endphp
                        @if($user->id == 1)
                            @foreach ($candidates as $candidate)
                                @php
                                        $candidateAbout = DB::table('candidate_abouts')->where('user_id', $candidate->model_id)->first();
                                        $country = DB::table('countries')->select('name')->where('id', $candidateAbout->location)->first();
                                        $candidate_personal_informations = DB::table('candidate_personal_informations')->where('user_id', $candidate->model_id)->first();
                                        $nationality = DB::table('countries')->where('id', $candidate_personal_informations->nationality)->first();
                                        $candidate_educations = DB::table('candidate_educations')->where('user_id', $candidate->model_id)->max('degree');
                                        $degree = DB::table('job_qualifications')->where('id', $candidate_educations)->first();
                                        $candidate_applied_jobs = DB::table('candidate_applied_jobs')
                                                                    ->where('user_id', $candidate->model_id)
                                                                    ->where('application_status','=','Hired')
                                                                    ->latest('created_at')
                                                                    ->first();
                                        $fieldOfInterest = explode(',', $candidateAbout->field_of_expertise);
                                        $interestedFields = DB::table('employee_bussiness_categories')->wherein('id', $fieldOfInterest)->get();
                                        if (!empty($candidate_applied_jobs)){
                                        $job_id = DB::table('jobs')->select('user_id')->where('id',$candidate_applied_jobs->job_id)->first();
                                        $employeeName = DB::table('users')->select('name')->where('id', $job_id->user_id)->first();
                                        }
                                @endphp
                                <tr>
                                    <td style="text-align:center;">{{$candidate->name}}</td>
                                    <td style="text-align:center;">{{$country->name}}</td>
                                    <td style="text-align:center;">@if(isset($nationality)){{$nationality->name}} @else N/A @endif</td>
                                    <td style="text-align:center;">@if(isset($candidate_personal_informations->age)){{$candidate_personal_informations->age}}@endif</td>
                                    <td style="text-align:center;">@foreach($interestedFields as $fields) {{$fields->category}} @if($loop->last) {{''}} @else {{"|"}} @endif  @endforeach</td>
                                    <td style="text-align:center;">@if(isset($employeeName)) {{$employeeName->name}} @else N/A @endif</td>
                                    <td style="text-align:center;">@if(isset($degree)){{$degree->name}}@endif</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
