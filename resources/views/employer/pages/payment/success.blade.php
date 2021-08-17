@extends('employer.layouts.master')

@section('title')
    Path | Payment Success
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Success</h5>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label"> Payment Success
                                <span class="d-block text-muted pt-2 font-size-sm"></span></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="block-wrapper">
                                        <div class="payment-result">
                                            <div class="icon">
                                                <i data-feather="check"></i>
                                            </div>
                                            <h3>You Unlocked <span>{{$finalResult->package_name}}</span> {{__('Package')}}</h3>
                                            <p>Thanks for your order!</p>
                                            <div class="result">
                                                <span>Your payment has been processed successfully.</span>
                                            </div>
                                            <div class="w-100"></div>
                                            <a href="{{route('invoice', encrypt($finalResult->id))}}" class="view-invoice">{{__('View Invoice')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
