@extends('candidates.layouts.master')

@section('title')
    Timeline
@endsection

@section('css')
    <style>
        .des-span p{
            text-align: justify !important;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
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

    @foreach($matchedJobs as $job)

        <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Entry-->
                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b">
                            <div class="card-body">
                                <!--begin::Details-->
                                <div class="d-flex mb-9">
                                    <!--begin: Pic-->
                                    <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                                        @php
                                            $jobImage = DB::table('users')
                                                                    ->where('id', $job->user_id)->first();
                                            $jobLocation = DB::table('countries')->where('id', $job->job_location)->first();
                                        @endphp
                                        <div class="symbol symbol-50 symbol-lg-120">
                                            @if($jobImage->avatar != null)
                                                <img src=" {{asset('images/'.$jobImage->avatar)}}" alt="image" />
                                            @else
                                                <img  src="{{asset('public/candidate/dist/assets/media/noimage.png')}}" alt="image" />
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
                                                <a href="{{route('jobDetail', $job->slug)}}">
                                                   <span style="cursor: pointer" class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{ (session()->has('language')) ? $job->title_ar : $job->title }}</span>
                                                </a>
                                                <i class="flaticon2-correct text-success font-size-h5"></i>
                                            </div>
                                            <div class="my-lg-0 my-3">
                                                @php $appliedJobs = DB::table('candidate_applied_jobs')->where('job_id', $job->id)->where('user_id', Auth::user()->id)->first(); @endphp
                                                @if(isset($appliedJobs))   <a style="cursor: no-drop" class="btn btn-sm btn-danger font-weight-bolder text-uppercase mr-3">{{__('Applied')}} @endif</a>

                                            </div>
                                        </div>
                                        <!--end::Title-->
                                        <!--begin::Content-->
                                        <div class="d-flex flex-wrap justify-content-between mt-1">
                                            <div class="d-flex flex-column flex-grow-1 pr-8">
                                                <div class="d-flex flex-wrap mb-4">
                                                    
                                                    <a class="text-dark-50 text-hover-primary font-weight-bold">
                                                        <i class="flaticon2-placeholder mr-2 font-size-lg"></i>{{(session()->has('language')) ? $jobLocation->name_ar : $jobLocation->name}}
                                                    </a>

                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" style="cursor: pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-share-alt ml-2 mr-1 font-size-lg"></i> {{__('Share')}}
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
                                                <span class="font-weight-bold text-dark-50 des-span">{!! htmlspecialchars_decode($job->description) !!}</span>
                                            </div>
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                                <div class="separator separator-solid"></div>
                                <!--begin::Items-->
                                <div class="d-flex align-items-center flex-wrap mt-8">

                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                                    <span class="mr-4">
                                        <i class="flaticon-time display-4 text-muted font-weight-bold"></i>
                                    </span>
                                        <div class="d-flex flex-column text-dark-75">
                                            <span class="font-weight-bolder font-size-sm">{{__('Start date')}}</span>
                                            <span class="font-weight-bolder font-size-h5">
                                              <span class="text-dark-50 font-weight-bold"></span>{{\Carbon\Carbon::parse($job->date)->format('d M Y')}}</span>
                                        </div>
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                                    <span class="mr-4">
                                        <i class="flaticon-danger display-4 text-muted font-weight-bold"></i>
                                    </span>
                                        <div class="d-flex flex-column text-dark-75">
                                            <span class="font-weight-bolder font-size-sm">{{__('End date')}}</span>
                                            <span class="font-weight-bolder font-size-h5">
                                               <span class="text-dark-50 font-weight-bold"></span>{{\Carbon\Carbon::parse($job->endingDate)->format('d M Y')}}
                                            </span>
                                        </div>
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
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
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
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
                                    <!--end::Item-->
                                </div>
                                <!--begin::Items-->
                            </div>
                        </div>
                        <!--end::Card-->

                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>
            <!--end::Content-->
    @endforeach
    <!--begin::Pagination-->
        <div class="d-flex justify-content-between align-items-center flex-wrap" style="position: relative;top: 0;bottom: 0;left: 0; right: 0; width: 200px; height: 100px; margin: auto;">
            <div class="d-flex flex-wrap mr-3">
                {{$matchedJobs->links()}}
            </div>
        </div>
        <!--end:: Pagination-->
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
