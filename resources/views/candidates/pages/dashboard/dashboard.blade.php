@extends('candidates.layouts.master')

@section('title')
    Path | Dashboard
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{__('Dashboard')}}</h5>
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
                                <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">@if (isset($cv->count)) {{$cv->count}} @else 0 @endif</span>
                                <span class="font-weight-bold text-white font-size-sm">{{__('CV views')}}</span>
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

        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">{{__('Number of Job(s) Applied')}}
                            <span class="d-block text-muted pt-2 font-size-sm"></span></h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable" id="myCustomTable">
                        <thead>
                        <tr>
                            <th style="text-align:center;">#</th>
                            <th style="text-align:center;">{{__('Job')}}</th>
                            <th style="text-align:center;">{{__('Location')}}</th>
                            <th style="text-align:center;">{{__('Company name')}}</th>
                            <th style="text-align:center;">{{__('Type')}}</th>
                            {{--  <th style="text-align:center;">{{__('Application status')}}</th>  --}}
                            <th style="text-align:center;">{{__('Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $no = 0; @endphp
                        @foreach ($appliedJobs as $job)
                            @php $no++;
                                 $location = DB::table('countries')->where('id', $job->job_location)->first();
                                 $img = DB::table('users')->where('id', $job->user_id)->first();
                                 $skills = explode(',', $job->skills);
                                 $jobSkills  = DB::table('skills')->whereIn('id', $skills)->get();
                            @endphp
                            <tr>
                                <td style="text-align:center;">{{$no}}</td>
                                <td >
                                    <span class="width: 250px;">
                                    <span class="d-flex align-items-center">
                                        @if(isset($img->avatar))
                                            <img style="width: 100%; max-width: 40px; height: 40px;border-radius: 50%;" src="{{asset('images/'.$img->avatar)}}">
                                        @else
                                            <span class="symbol symbol-circle symbol-lg-35 symbol-25 symbol-light-success">
                                                <span class="symbol-label font-size-h5 font-weight-bold">{{strtoupper(substr($job->title, 0, 1))}}</span>
                                            </span>
                                        @endif
                                    <span class="ml-3">
                                    <a href="{{route('jobDetail', $job->slug)}}"><span class="text-dark-75 font-weight-bolder font-size-lg mb-0">{{ (session()->has('language')) ? $job->title_ar : $job->title }}</span></a><br>
                                    <a class="text-muted font-weight-bold text-hover-primary"> @foreach($jobSkills as $jobSkill) {{ (session()->has('language')) ? $jobSkill->name_ar : $jobSkill->name }} @endforeach</a>
                                        </span>
                                        </span>
                                        </span>
                                </td>
                                <td style="text-align:center;">{{ (session()->has('language')) ? $location->name_ar : $location->name }}</td>
                                <td style="text-align:center;" class="text-muted font-weight-bold">{{$img->name}}</td>
                                <td style="text-align:center;">
                                    <span style="width: 158px;">
                                        <span
                                            @if($job->type == 1) class="label label-lg font-weight-bold  label-light-info label-inline"
                                            @elseif ($job->type == 2) class="label label-lg font-weight-bold  label-light-warning label-inline"
                                            @endif>
                                            @php $jobType = DB::table('job_types_tables')->find($job->type); @endphp @if(isset($jobType)) {{(session()->has('language')) ? $jobType->name_ar : $jobType->name }} @endif
                                        </span>
                                    </span>
                                </td>
                                {{--  <td style="text-align:center;"><span
                                        @if($job->application_status == 'Pending') class="label label-lg font-weight-bold label-light-info  label-inline">
                                        @else
                                            class="label label-lg font-weight-bold  label-light-primary label-inline">
                                        @endif
                                        {{$job->application_status}}</span></td>  --}}
                                <td style="text-align:center;">
                                    @if($job->application_status != 'Hired')
                                        <a style="cursor: pointer" onclick="deleteFunction('{{$job->id}}') "><i class="la la-trash text-danger mr-5"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">{{__('Matched Job(s)')}}
                            <span class="d-block text-muted pt-2 font-size-sm"></span></h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable" id="myCustomTable1">
                        <thead>
                        <tr>
                            <th style="text-align:center;">{{__('Name')}}</th>
                            <th style="text-align:center;">{{__('Business Category')}}</th>
                            <th style="text-align:center;">{{__('Job Location')}}</th>
                            <th style="text-align:center;">{{__('Applied for')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $no = 0; @endphp
                        @foreach ($matchedJobs as $matchedJob)
                            @php
                                $no++;
                                     $location = DB::table('countries')->where('id', $matchedJob->job_location)->first();
                                     $businessCategory  = DB::table('employee_bussiness_categories')->where('id', $matchedJob->category)->first();
                                     $applied = DB::table('candidate_applied_jobs')->where('job_id', $matchedJob->id)->where('user_id', Auth::user()->id)->first();
                                @endphp
                            <tr>
                                <td style="text-align:center;"><a href="{{route('jobDetail', $matchedJob->slug)}}"><span class="text-dark-75 font-weight-bolder font-size-lg mb-0">{{ (session()->has('language')) ? $matchedJob->title_ar : $matchedJob->title }}</span></a></td>
                                <td style="text-align:center;">{{ (session()->has('language')) ? $businessCategory->category_ar : $businessCategory->category}}</td>
                                <td style="text-align:center;">{{ (session()->has('language')) ? $location->name_ar : $location->name }}</td>
                                <td style="text-align:center;">
                                    @if(isset($applied))
                                        <span style="width: 158px;">
                                            <span
                                                class="label label-lg font-weight-bold  label-light-warning label-inline">
                                                Applied
                                            </span>
                                        </span>
                                    @else
                                        <a href="{{route('jobApply', ['id'=> $matchedJob->id , 'user_id'=>$matchedJob->user_id])}}" style="cursor: pointer">
                                            <span style="width: 158px;">
                                            <span
                                                class="label label-lg font-weight-bold  label-light-info label-inline">
                                                Apply
                                            </span>
                                        </span>
                                        </a>

                                    @endif
                                </td>
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
                            url: "{{route('unapplyJob')}}",
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
