@extends('employer.layouts.master')

@section('title')
    Dashboard
@endsection

@section('css')
    <style>
        .blinking {
            animation: blinkingText 1.7s infinite;
        }

        @keyframes blinkingText {
            0% {
                color: rgb(255, 255, 255);
                background-color: rgb(184, 11, 132);
            }

            49% {
                color: rgb(255, 255, 255);
                background-color: rgb(206, 143, 118);
            }

            60% {
                color: transparent;
                background-color: transparent;
            }

            99% {
                color: transparent;
                background-color: transparent;
            }

            100% {
                color: rgb(255, 255, 255);
                background-color: rgb(11, 144, 184);
            }
        }

    </style>
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
            <div class="container">
                <div class="row" style="justify-content: center">
                    <div class="col-xl-3">
                        <div class="card card-custom bg-info card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-2x svg-icon-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path
                                                d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <path
                                                d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg>
                                </span>
                                @php
                                    $user_id = Auth::user()->id;
                                    
                                    $job_count = DB::table('jobs')
                                        ->where('user_id', $user_id)
                                        ->count();
                                @endphp
                                <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block"
                                    id="live-candidate-applied-jobs">
                                @if (isset($job_count)) {{ $job_count }} @else 0
                                    @endif
                                </span>
                                <span class="font-weight-bold text-white font-size-sm">{{__('Total Job Posted')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card card-custom bg-danger card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-2x svg-icon-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16"
                                                rx="1.5" />
                                            <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
                                            <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
                                            <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
                                        </g>
                                    </svg>
                                </span>
                                <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block"
                                    id="total-candidates">

                                    @php
                                        if (isset($jobCount)){
                                            $packageJobs = (int) $jobCount->jobs_limit - (int) $jobCount->jobs_count ;
                                        }
                                        else{
                                            $packageJobs = 0;
                                        }
                                    @endphp

                                    {{ auth()->user()->free_jobs + $packageJobs }}

                                </span>
                                <span class="font-weight-bold text-white font-size-sm">{{__('Job(s) remaining')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('public/backend/dist/assets/media/svg/shapes/abstract-1.svg') }})">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-2x svg-icon-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z"
                                                fill="#000000" opacity="0.3" />
                                            <path
                                                d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z"
                                                fill="#000000" />
                                        </g>
                                    </svg>
                                </span>
                                <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block"
                                    id="live-jobs">{{ $liveJobs }}</span>
                                <span class="font-weight-bold text-muted font-size-sm">{{__('Total Live Job(s)')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card card-custom bg-danger card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-2x svg-icon-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16"
                                                rx="1.5" />
                                            <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
                                            <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
                                            <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
                                        </g>
                                    </svg>
                                </span>
                                <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block" id="total-candidates">
                                @if (isset($count)) {{ $count }} @else 0
                                    @endif
                                </span>
                                <span class="font-weight-bold text-white font-size-sm">{{__('Application Submit')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card card-custom bg-dark card-stretch gutter-b">
                            <div class="card-body">
                                <span class="svg-icon svg-icon-2x svg-icon-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z"
                                                fill="#000000" />
                                            <path
                                                d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z"
                                                fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                </span>
                                <span
                                    class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 text-hover-primary d-block"
                                    id="total-employers">
                                    @if (isset($totalJobCount)) 
                                        {{ $totalJobCount }}
                                    @else
                                        0 
                                    @endif
                                </span>
                                <span class="font-weight-bold text-white font-size-sm">{{__('Total Job Views')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label"> {{__('List of Jobs')}}
                                <span class="d-block text-muted pt-2 font-size-sm"></span>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-separate table-head-custom table-checkable" id="myCustomTable">
                            <thead>
                                <tr>
                                    <th style="text-align: center">#</th>
                                    <th style="text-align: center">{{__('Title')}}</th>
                                    <th style="text-align: center">{{__('Country')}}</th>
                                    <th style="text-align: center">{{__('Post Date')}}</th>
                                    <th style="text-align: center">{{__('Type')}}</th>
                                    <th style="text-align: center">{{__('Job Status')}}</th>
                                    <th style="text-align: center">{{__('Admin Approval')}}</th>
                                    <th style="text-align: center">{{__('Applications')}}</th>
                                    <th style="text-align: center">{{__('Matched Candidates')}}</th>
                                    <th style="text-align: center">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $SrNo = 0; @endphp
                                @foreach ($jobs as $job)
                                    @php
                                    // dd($job);
                                        $usersInactive = DB::table('users')->where('account_active', 1)->get()->pluck('id');
                                        $totalApplications = DB::table('candidate_applied_jobs')
                                            ->where('job_id', $job->id)
                                            ->whereIn('user_id', $usersInactive)
                                            ->count();
                                        $jobLocation = DB::table('countries')
                                            ->where('id', $job->job_location)
                                            ->first();
                                        $SrNo++;

                                    //    $users = DB::table('users as u')->select('users.id, users.name')
                                    //    ->join('candidate_personal_informations as pi', 'u.id' , '=', 'pi.user_id')
                                    //    ->where('u.country_name', $job->job_location)
                                    //    ->where('pi.nationality', $job->candidate_nationality)
                                    @endphp
                                    <tr>
                                        <td style="text-align: center">{{ $SrNo }}</td>
                                        <td style="text-align: center" class="font-weight-bolder text-black mb-0"><a
                                                href="{{ route('viewJob', encrypt($job->id)) }}">{{ (session()->has('language')) ? $job->title_ar : $job->title }}</a>
                                        </td>
                                        <td style="text-align: center">{{ (session()->has('language')) ? $jobLocation->name_ar : $jobLocation->name }}</td>
                                        <td style="text-align: center"><span style="width: 158px;">
                                                <div class="font-weight-normal text-black mb-0">
                                                    {{ \Carbon\Carbon::parse($job->date)->format('d M Y') }}</div>
                                            </span></td>
                                        <td style="text-align: center"><span style="width: 158px;"><span @if ($job->type == 1) class="label label-lg font-weight-bold  label-light-info label-inline"
                                                @elseif ($job->type == 2) class="label label-lg font-weight-bold  label-light-warning label-inline" @endif>
                                                @if ($job->type == 1) {{__('Full time')}}
                                                @elseif($job->type == 2) {{__('Part time')}}
                                                @else N/A
                                                @endif
                                            </span></span></td>
                                        <td style="text-align: center"><span style="width: 158px;"><span @if ($job->status == 1) class="label label-lg font-weight-bold  label-light-success label-inline"
                                                    @elseif($job->status == 0) class="label label-lg font-weight-bold  label-light-danger label-inline" @endif>
                                                    @if ($job->status == 1) {{__('Active')}}
                                                    @elseif($job->status == 0) {{__('Inactive')}}
                                                    @else N/A @endif
                                                </span></span>
                                        </td>
                                        <td style="text-align: center">
                                            <span style="width: 158px;">
                                                <span @if ($job->approval_status == 1) class="label label-lg font-weight-bold  label-light-success label-inline"
                                                        @elseif($job->approval_status == 2) class="label label-lg font-weight-bold  label-light-primary label-inline"
                                                        @elseif($job->approval_status == 3) class="label label-lg font-weight-bold  label-light-danger label-inline" @endif>
                                                    @if ($job->approval_status == 1)
                                                        {{__('Approved')}}
                                                    @elseif($job->approval_status == 2) {{__('InProcess')}}
                                                    @elseif($job->approval_status == 3) {{__('Rejected')}}
                                                    @else N/A @endif
                                                </span>
                                            </span>
                                        </td>
                                        <td style="text-align: center">
                                            @php
                                                $newDate = Carbon\Carbon::createFromDate($job->date)->addMonths(2)->format('Y-m-d');
                                            @endphp
                                            @if(Carbon\Carbon::now() <= $newDate )
                                                <a @if ($totalApplications > 0) href="{{ route('manageCandidates', encrypt($job->id)) }}" @endif> {{ $totalApplications }} {{__('Application(s)')}}</a>
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            @if(Carbon\Carbon::now() <= $newDate )
                                                @php
                                                    $candidate_jobs = DB::table('candidate_applied_jobs')->where('job_id', $job->id)->get()->pluck('user_id');

                                                    $query  = DB::table('users as u')->whereIn('u.id', $candidate_jobs)
                                                    ->join('candidate_abouts as ab', 'u.id', '=', 'ab.user_id')
                                                    ->join('candidate_personal_informations as pi', 'u.id', '=', 'pi.user_id')
                                                    ->where('u.match_cv', 1)
                                                    ->where('u.account_active', 1)
                                                    ->where('ab.location', $job->job_location)
                                                    ->where('pi.nationality', $job->candidate_nationality)
                                                    ->where('ab.gender', $job->gender)
                                                    ->whereRaw("find_in_set('".$job->category."', ab.field_of_expertise)");

                                                    $applicantMatched = $query->count();
                                                    
                                                @endphp
                                                <a  href="{{ route('manageMatchedCandidates', encrypt($job->id)) }}" > {{ $applicantMatched }} {{__('Matched Candidates')}}</a>
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            <a href="{{ route('viewJob', encrypt($job->id)) }}"><i
                                                    class="la la-eye text-info mr-1"></i></a>
                                            <a href="{{ route('editJob', encrypt($job->id)) }}"><i
                                                    class="la la-pencil-alt text-success mr-1"></i></a>
                                            <a style="cursor: pointer" onclick="deleteFunction('{{ $job->id }}') "><i
                                                    class="la la-trash text-danger mr-1"></i></a>

                                            @if($job->approval_status == 1)
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle" style="cursor: pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-share-alt font-size-lg"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" style="cursor: pointer" onclick="copyLink('{{route('jobDetails', $job->slug)}}')">{{__('Copy Link')}}</a>
                                                        <a class="dropdown-item" href="whatsapp://send?text={{route('jobDetails', $job->slug)}}" data-action="share/whatsapp/share">Whatsapp</a>
                                                        <a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{route('jobDetails', $job->slug)}}" target="_blank">Facebook</a>
                                                        <a class="dropdown-item" href="https://twitter.com/intent/tweet?url={{route('jobDetails', $job->slug)}}" target="_blank">Twitter</a>
                                                        {{--  <a class="dropdown-item" href="https://www.instagram.com/?url={{route('jobDetails', $job->slug)}}" target="_blank">Instagram</a>  --}}
                                                    </div>
                                                </div>
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
                            url: "{{ route('deleteJob') }}",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                'id': id
                            },
                            success: function(response) {
                                if (response.status === 1) {
                                    swal("Successfully Deleted", {
                                        icon: "success",
                                    });
                                    window.setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                } else {
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
