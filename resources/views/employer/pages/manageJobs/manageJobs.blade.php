@extends('employer.layouts.master')

@section('title')
    Path | Manage Jobs
@endsection

@section('css')
@endsection

@section('main-content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{__('List of jobs')}}</h5>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    @foreach($jobs as $job)
                        @php
                            $totalApplications = DB::table('candidate_applied_jobs')->where('job_id', $job->id)->get();
                            $jobLocation = DB::table('countries')->where('id', $job->job_location)->first();
                        @endphp
                    <div class="col-xl-4">
                        <div class="card card-custom gutter-b card-stretch">
                            <div class="card-body vertical-card">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 mr-4 symbol symbol-60 symbol-circle">
                                        <img src="{{asset('images/'.Auth::user()->avatar)}}" alt="image" />
                                    </div>
                                    <div class="d-flex flex-column mr-auto">
                                        <div class="d-flex flex-column mr-auto">
                                            <a href="{{route('viewJob', encrypt($job->id))}}" class="text-dark text-hover-primary font-size-h4 font-weight-bolder mb-1">{{(session()->has('language')) ? $job->title_ar : $job->title}}</a>
                                            <span class="text-muted font-weight-bold"><i class="flaticon2-placeholder mr-2 font-size-lg"></i>{{(session()->has('language')) ? $jobLocation->name_ar : $jobLocation->name}}</span>
                                            @if($job->approval_status == 1)
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle" style="cursor: pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-share-alt mr-1 font-size-lg"></i> {{__('Share')}}
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" style="cursor: pointer" onclick="copyLink('{{route('jobDetails', $job->slug)}}')">{{__('Copy Link')}}</a>
                                                        <a class="dropdown-item" href="whatsapp://send?text={{route('jobDetails', $job->slug)}}" data-action="share/whatsapp/share">{{__('Whatsapp')}}</a>
                                                        <a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{route('jobDetails', $job->slug)}}" target="_blank">{{__('Facebook')}}</a>
                                                        <a class="dropdown-item" href="https://twitter.com/intent/tweet?url={{route('jobDetails', $job->slug)}}" target="_blank">{{__('Twitter')}}</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-toolbar mb-7">
                                        <div class="dropdown dropdown-inline" data-toggle="tooltip" title="More" data-placement="left">
                                            <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ki ki-bold-more-hor"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                <ul class="navi navi-hover">
                                                    <li class="navi-item">
                                                        <a href="{{route('editJob', encrypt($job->id))}}" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="flaticon2-edit"></i>
                                                            </span>
                                                            <span class="navi-text">{{__('Edit')}}</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a href="{{route('viewJob', encrypt($job->id))}}" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="flaticon2-browser"></i>
                                                            </span>
                                                            <span class="navi-text">{{__('View')}}</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a style="cursor: pointer" @if ($job->status == 1) onclick="changeStatus('{{$job->id}} ', 0)" @else onclick="changeStatus('{{$job->id}}', 1)" @endif class="navi-link">
                                                            <span class="navi-icon">
                                                               @if($job->status == 1) <i class="flaticon2-cancel"></i> @else <i class="flaticon2-correct"></i> @endif
                                                            </span>
                                                            <span class="navi-text">@if($job->status == 1) Inactive @else Active @endif </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-auto mt-5 font-weight-bold short">{!! htmlspecialchars_decode($job->description) !!}</div>
                                <div class="d-flex mb-5 mt-5">
                                    <div class="d-flex align-items-center mr-7">
                                        <span class="font-weight-bold mr-4">{{__('Start')}}</span>
                                        <span class="btn btn-light-primary btn-sm font-weight-bold btn-upper btn-text">{{ \Carbon\Carbon::parse($job->date)->format('d M y')}}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="font-weight-bold mr-4">{{__('End')}}</span>
                                        <span class="btn btn-light-danger btn-sm font-weight-bold btn-upper btn-text">{{ \Carbon\Carbon::parse($job->endingDate)->format('d M y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center">
                                <div class="d-flex">
                                    @php
                                        $newDate = Carbon\Carbon::createFromDate($job->date)->addMonths(2)->format('Y-m-d');
                                    @endphp
                                    @if(Carbon\Carbon::now() <= $newDate )
                                        <div class="d-flex align-items-center mr-7">
                                            <span class="svg-icon svg-icon-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z" fill="#000000" />
                                                        <path d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                            </span>
                                            <a href="{{route('manageCandidates', encrypt($job->id))}}" class="font-weight-bolder text-primary ml-2">{{count($totalApplications)}} {{__('Application')}}</a>
                                        </div>

                                        <div class="d-flex align-items-center mr-7">
                                            <span class="svg-icon svg-icon-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z" fill="#000000" />
                                                        <path d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                            </span>
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
                                            <a href="{{route('manageMatchedCandidates', encrypt($job->id))}}" class="font-weight-bolder text-primary ml-2">{{$applicantMatched}} {{__('Matched')}}</a>
                                        </div>
                                    @endif
                                    <div class="d-flex align-items-center mr-7">
                                            <span class="svg-icon svg-icon-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000" />
                                                        <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                            </span>
                                        <a class="font-weight-bolder text-primary ml-2">@if($job->status == 1) {{__('Active')}} @else {{__('Inactive')}} @endif</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if (count($jobs) == 0)
                        <h1 style="text-align: center">No Jobs Posted</h1>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center flex-wrap" style="position: relative;top: 0;bottom: 0;left: 0; right: 0; width: 200px; height: 100px; margin: auto;">
                    <div class="d-flex flex-wrap mr-3">
                        {{$jobs->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function changeStatus(id ,value)
        {
            $.ajax({
                method: "POST",
                url: "{{route('employerJobStatus')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    'job_id': id,
                    'status': value,
                },
                success: function (response) {
                    if (response.status === 1) {
                        swal("Successfully Updated", {
                            icon: "success",
                        });
                        setTimeout(function(){ location.reload(); }, 1000);
                    } else {
                        swal("Error While Updating", {
                            icon: "error",
                        });
                    }
                }
            });
        }
    </script>
@endsection
