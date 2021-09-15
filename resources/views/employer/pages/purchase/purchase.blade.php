@extends('employer.layouts.master')

@section('title')
    Packages
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-chart text-primary"></i>
                        </span>
                        <h4 class="card-label">{{__('Packages')}}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center text-center my-0 my-md-25">

                        @php
                            $country = DB::table('countries')->where('id', auth()->user()->country_name)->first();
                        @endphp
                        <!-- begin: Pricing-->
                        @foreach($packages as $package)
                            @php
                                $packageDetail = DB::table('package_details')->where('package_id', $package->id)->first();
                                $packageFeatures = DB::table('package_feature_lists')->where('package_details_id', $packageDetail->id)->get();
                                $packageCurrency = DB::table('package_currencys')->where('id', $packageDetail->currency)->first();
                            @endphp

                            <div class="col-md-4 col-xxl-3 bg-white rounded-left shadow-sm mb-6">
                                {{-- <form action="{{route('payment', encrypt($package->id))}}" method="POST"> --}}
                                    {{-- @csrf --}}
                                    <div class="pt-25 pb-25 pb-md-10 px-4">
                                        <h4 class="mb-15">{{$package->package_name}}</h4>
                                        <p class="mb-10 d-flex flex-column text-dark-50">
                                            <span> @if (isset($packageDetail->package_description)) {{$packageDetail->package_description}} @endif</span>
                                        </p>
                                        <br>

                                        @if($exist == 0)
                                            <button type="button" onclick="location.href='{{ route('packageDetail', encrypt($package->id)) }}'" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">{{__('Purchase')}}</button>
                                        @elseif($exist == 1)
                                            @if($existRecord == "" || empty($existRecord))
                                                <button type="button" onclick="location.href='{{ route('packageDetail', encrypt($package->id)) }}'" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">{{__('Purchase')}}</button>
                                            @else
                                                <button @if($existRecord->package_id ==  $package->id) disabled @endif type="button" onclick="location.href='{{ route('packageDetail', encrypt($package->id)) }}'" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3" @if($existRecord->package_id ==  $package->id) style="cursor: no-drop" @endif>@if($existRecord->package_id ==  $package->id) {{__('Purchased')}} @else{{__('Purchase')}} @endif</button>
                                            @endif
                                        @endif
                                    </div>
                                {{-- </form> --}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
@endsection

@section('script')
@endsection
