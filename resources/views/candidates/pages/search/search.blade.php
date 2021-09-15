@extends('candidates.layouts.master')

@section('title')
    Search Jobs
@endsection

@section('css')
    <style>
        .des-span p{
            text-align: justify !important;
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection

@section('main-content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{__('Job Search')}}</h5>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">

            <div class="container">

                <form method="Get" action="{{route('jobs')}}" id="submitForm">
                    {{-- @csrf --}}
                    <div class="form-group row col-lg-12">

                        <div class="col-lg-4 col-md-9 col-sm-12">
                            <select class="form-control selectpicker" id="country" name="country_id" data-size="7" data-live-search="true">
                                <option selected disabled value=" ">{{__('Select Country')}}</option>
                                <option data-divider="true" label="Label"></option>
                                @foreach($countries as $country)
                                    @if (isset($countryId))
                                        <option {{($countryId == $country->id) ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                    @else
                                        <option value="{{$country->id}}">{{(session()->has('language')) ? $country->name_ar : $country->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-9 col-sm-12">
                            <select class="form-control selectpicker" id="industry" name="industry_id" data-size="7" data-live-search="true">
                                <option selected disabled value=" ">{{__('Select Industry')}}</option>
                                <option data-divider="true" label="Label"></option>
                                @foreach($industries as $industry)
                                    @if (isset($industryId))
                                        <option {{($industryId == $industry->id) ? 'selected' : ''}} value="{{$industry->id}}">{{$industry->category}}</option>
                                    @else
                                        <option value="{{$industry->id}}">{{(session()->has('language')) ? $industry->category_ar : $industry->category}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-9 col-sm-12">
                            <input class="form-control" placeholder="Company Name" id="company" name="company_name" type="text" @if (isset($companyName)) value="{{$companyName}}" @endif required>
                            {{--  <select class="form-control selectpicker" id="company" name="company_name" data-size="7" data-live-search="true" required>
                                <option selected disabled value="">{{__('Select Company name')}}</option>
                                <option data-divider="true" label="Label"></option>
                                @foreach($companies as $company)
                                    @if (isset($companyName))
                                    <option {{($companyName == $company->name) ? 'selected' : ''}} value="{{$company->name}}">{{$company->name}}</option>
                                        @else
                                    <option value="{{$company->name}}">{{$company->name}}</option>
                                    @endif
                                @endforeach
                            </select>  --}}
                        </div>

                        <div class="col-lg-6 col-md-9 col-sm-12" style="margin-top: 10px">
                            <div style="text-align: end">
                                {{--  <a onclick="searchFunction()" class="btn btn-primary mr-2" >{{__('Filter')}}</a>  --}}
                                <button id="submitButton" type="submit" class="btn btn-primary mr-2" >{{__('Filter')}}</button>
                            </div>
                        </div>
                    </div>
                </form>

                @if (isset($jobs ))
                    <div id="search-jobs">
{{--                    @include('candidates.pages.search.search-jobs')--}}
                        <div id="load" class="d-flex flex-column-fluid">
                            <!--begin::Container-->
                            <div class="container">
                                <!--begin::Row-->
                                <div class="row">
                                    @foreach($jobs as $job)
                                        @php
                                            $jobLocation = DB::table('countries')->where('id', $job->job_location)->first();
                                        @endphp
                                        <div class="col-xl-4">
                                            <!--begin::Card-->
                                            <div class="card card-custom gutter-b card-stretch">
                                                <!--begin::Body-->
                                                <div class="card-body">
                                                    <!--begin::Info-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Pic-->
                                                        <div class="flex-shrink-0 mr-4 symbol symbol-60 symbol-circle">
                                                            <img src="{{asset('images/'.$job->avatar)}}" alt="image" />
                                                        </div>
                                                        <!--end::Pic-->
                                                        <!--begin::Info-->
                                                        <div class="d-flex flex-column mr-auto">
                                                            <!--begin: Title-->
                                                            <div class="d-flex flex-column mr-auto">
                                                                <a class="text-dark text-hover-primary font-size-h4 font-weight-bolder mb-1" href="{{route('jobDetail', $job->slug)}}">{{ (session()->has('language')) ? $job->title_ar : $job->title }}</a>
                                                                <span class="text-muted font-weight-bold"><i class="flaticon2-placeholder mr-2 font-size-lg"></i>{{(session()->has('language')) ? $jobLocation->name_ar : $jobLocation->name}}</span>
                                                                <div class="dropdown">
                                                                    <a class="dropdown-toggle" style="cursor: pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fa fa-share-alt mr-1 font-size-lg"></i> {{__('Share')}}
                                                                    </a>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" style="cursor: pointer" onclick="copyLink('{{route('jobDetails', $job->slug)}}')">{{__('Copy Link')}}</a>
                                                                        <a class="dropdown-item" href="whatsapp://send?text={{route('jobDetails', $job->slug)}}" data-action="share/whatsapp/share">{{__('Whatsapp')}}</a>
                                                                        <a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{route('jobDetails', $job->slug)}}&display=popup" target="_blank">{{__('Facebook')}}</a>
                                                                        <a class="dropdown-item" href="https://twitter.com/intent/tweet?url={{route('jobDetails', $job->slug)}}" target="_blank">{{__('Twitter')}}</a>
                                                                        {{--  <a class="dropdown-item" href="https://www.instagram.com/?url={{route('jobDetails', $job->slug)}}" target="_blank">{{__('Instagram')}}</a>  --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Info-->
                                                    </div>
                                                    <!--end::Info-->
                                                    <!--begin::Description-->
                                                    <div class="mb-10 mt-5 font-weight-bold"><span class="des-span">{!! htmlspecialchars_decode($job->description) !!}</span></div>
                                                    <!--end::Description-->
                                                    <!--begin::Data-->
                                                    <div class="d-flex mb-5">
                                                        <div class="d-flex align-items-center mr-7">
                                                            <span class="font-weight-bold mr-4">{{__('Start')}}</span>
                                                            <span class="btn btn-light-primary btn-sm font-weight-bold btn-upper btn-text">{{\Carbon\Carbon::parse($job->date)->format('d M y')}}</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="font-weight-bold mr-4">{{__('End')}}</span>
                                                            <span class="btn btn-light-danger btn-sm font-weight-bold btn-upper btn-text">{{\Carbon\Carbon::parse($job->endingDate)->format('d M y')}}</span>
                                                        </div>
                                                    </div>
                                                    <!--end::Data-->
                                                    @php $appliedJobs = DB::table('candidate_applied_jobs')->where('job_id', $job->job_id)->where('user_id', Auth::user()->id)->first(); @endphp
                                                    <a @if(isset($appliedJobs)) style="cursor: no-drop" class="btn btn-block btn-sm btn-danger font-weight-bolder text-uppercase py-4"
                                                       @else href="#" class="btn btn-block btn-sm btn-light-success font-weight-bolder text-uppercase py-4"
                                                        @endif >
                                                        @if(isset($appliedJobs)) {{__('Applied')}} @else {{__('Apply')}} @endif
                                                    </a>

                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end:: Card-->
                                        </div>
                                    @endforeach
                                        @if (!isset($jobs))
                                            <div class="d-flex flex-column-fluid">
                                                <!--begin::Container-->
                                                <div class="container">
                                                    <!--begin::Row-->
                                                    <div class="row" style="justify-content: center">
                                                        <h2 class="font-weight-bolder text-uppercase py-4">{{__('No Jobs Found!')}}</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                </div>
                                <!--begin::Pagination-->
{{--                                <div class="d-flex justify-content-between align-items-center flex-wrap" style="position: relative;top: 0;bottom: 0;left: 0; right: 0; width: 200px; height: 100px; margin: auto;">--}}
{{--                                    <div class="d-flex flex-wrap mr-3">--}}

{{--                                        {{$jobs->links()}}--}}
{{--                                                        {!! $jobs->links() !!}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <!--end::Pagination-->
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>

@endsection

@section('script')
    <script>
        function searchFunction() {
            // alert($('#country').val() + $('#industry').val() + $('#company').val());

            // if ($('#country').val() == null && $('#industry').val() == null && $('#company').val() == null)
            if ($('#company').val() == null)
            {
                alert('Please select Company Name from dropdown');
            }
            else {
            $.ajax({
                url: "{{route('jobs')}}",
                method: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",
                    country_id: $('#country').val(),
                    industry_id: $('#industry').val(),
                    company_name: $('#company').val(),
                },
                success: function(jobs) {
                    $("#search-jobs").html('');
                    // $("#search-jobs").html(data.options);
                    $("#search-jobs").html(jobs);
                    $('#js-example-basic-multiple').select2();
                    $('.js-example-basic-multiple1').select2();
                }
            });
            }
        }

        $('#submitButton').click(function(e){
            e.preventDefault();
            let country = $('#country').val();
            let industry = $('#industry').val();
            let company = $('#company').val();


            if(country != null || industry != null || company != ""){
                $('#submitForm').submit();
            }
            else{
                toastr.options.positionClass = 'toast-top-center';
                toastr.error('Please Select any of one option');
                return;
            }


        });
    </script>
@endsection
