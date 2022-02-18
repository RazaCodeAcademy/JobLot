@extends('candidates.layouts.master')

@section('title')
    Employer Profile
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{__('Employers Profile')}}</h5>
                </div>
            </div>
        </div>

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
                                            $employerLocation = DB::table('countries')->where('id', $employer->country_name)->first();
                                        @endphp
                                        <div class="symbol symbol-50 symbol-lg-120">
                                            @if($employer->avatar != null)
                                                <img src=" {{asset('images/'.$employer->avatar)}}" alt="image" />
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
                                                <a>
                                                    <span class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{$employer->name}}</span>
                                                </a>
                                                <i class="flaticon2-correct text-success font-size-h5"></i>
                                            </div>
                                            <div class="my-lg-0 my-3">
                                                <a href="{{url()->previous()}}" class="btn btn-sm btn-secondary font-weight-bolder text-uppercase">{{__('Back')}}</a>
                                            </div>
                                        </div>
                                        <!--end::Title-->
                                        <!--begin::Content-->
                                        <div class="d-flex flex-wrap justify-content-between mt-1">
                                            <div class="d-flex flex-column flex-grow-1 pr-8">
                                                <div class="d-flex flex-wrap mb-4">
                                                    {{-- <a class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                                        <i class="flaticon2-new-email mr-2 font-size-lg"></i>{{$employer->email}}</a> --}}
                                                    <a class="text-dark-50 text-hover-primary font-weight-bold">
                                                        <i class="flaticon2-placeholder mr-2 font-size-lg"></i>{{(session()->has('language')) ? $employerLocation->name_ar : $employerLocation->name}}</a>
                                                </div>
                                                <span class="font-weight-bold text-dark-50">{{$employer->aboutus}}</span>
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
                                            <i class="flaticon-analytics display-4 text-muted font-weight-bold"></i>
                                        </span>
                                        <div class="d-flex flex-column text-dark-75">
                                            <span class="font-weight-bolder font-size-sm">{{__('Total Jobs Posted')}}</span>
                                            @php $jobCount = DB::table('jobs')->where('user_id', $employer->id)->where('status','=',1)->where('job_approval','=',1)->count(); @endphp
                                            <span class="font-weight-bolder font-size-h5">
                                              <span class="text-dark-50 font-weight-bold"></span>
                                               @if(isset($jobCount)) {{$jobCount}} @else 0 @endif
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

@endsection

@section('script')
@endsection
