@extends('employer.layouts.master')

@section('title')
    Packages
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
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
                        
                        {{-- @foreach($packages as $package) --}}
                            @php
                                $packageDetail = DB::table('package_details')->where('package_id', $package->id)->first();
                                $packageFeatures = DB::table('package_feature_lists')->where('package_details_id', $packageDetail->id)->get();
                                $packageCurrency = DB::table('package_currencys')->where('id', $packageDetail->currency)->first();
                            @endphp

                            <div class="col-md-4 col-xxl-3 bg-white rounded-left shadow-sm mb-6">
                                <form action="{{route('payment', encrypt($package->id))}}" method="POST">
                                    @csrf
                                    <div class="pt-25 pb-25 pb-md-10 px-4">
                                        <h4 class="mb-15">{{$package->package_name}}</h4>
                                        <p class="mb-10 d-flex flex-column text-dark-50">
                                            <span> @if (isset($packageDetail->package_description)) {{$packageDetail->package_description}} @endif</span>
                                        </p>

                                        <span class="px-7 py-3 font-size-h1 font-weight-bold d-inline-flex flex-center bg-primary-o-10 rounded-lg mb-15">
                                            @if (isset($packageCurrency)) {{ $packageCurrency->currency_name}} @endif @if (isset($packageDetail->rate)) {{ $packageDetail->rate}} @endif
                                        </span>
                                        <br />

                                        <h3>{{__('Features')}}</h3>
                                        @foreach($packageFeatures as $packageFeature)
                                            <span class="flaticon2-correct">
                                                {{$packageFeature->feature_name}}
                                            </span>
                                            <br>
                                        @endforeach
                                        <br>

                                        @if($exist == 0)
                                            @if(auth()->user()->country_name == 4)
                                                <input type="radio" name="payment_method" value="1" required> Knet 
                                                <input type="radio" name="payment_method" class="ml-2" value="2" required> Master/Visa
                                                <br>
                                            @endif
                                            <button type="submit" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">{{__('Purchase')}}</button>
                                        @elseif($exist == 1)
                                            @if($existRecord == "" || empty($existRecord))
                                                @if(auth()->user()->country_name == 4)
                                                    <input type="radio" name="payment_method" value="1" required> Knet 
                                                    <input type="radio" name="payment_method" class="ml-2" value="2" required> Master/Visa
                                                    <br>
                                                @endif
                                                <button type="submit" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">{{__('Purchase')}}</button>
                                            @else
                                                @if($existRecord->package_id !=  $package->id)
                                                    @if(auth()->user()->country_name == 4)
                                                        <input type="radio" name="payment_method" value="1" required> Knet 
                                                        <input type="radio" name="payment_method" class="ml-2" value="2" required> Master/Visa
                                                        <br>
                                                    @endif
                                                @endif
                                                <button @if($existRecord->package_id ==  $package->id) disabled @endif type="submit" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3" @if($existRecord->package_id ==  $package->id) style="cursor: no-drop" @endif>@if($existRecord->package_id ==  $package->id) {{__('Purchased')}} @else{{__('Purchase')}} @endif</button>
                                            @endif
                                        @endif
                                    </div>
                                </form>
                            </div>
                        {{-- @endforeach --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
