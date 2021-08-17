@extends('employer.layouts.master')

@section('title')
    Path | Payment History
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">{{__('Invoice Information')}}</h5>
                        <!--end::Page Title-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!-- begin::Card-->
                <div class="card card-custom overflow-hidden">
                    <div class="card-body p-0">
                        <!-- begin: Invoice-->
                        <!-- begin: Invoice header-->
                        <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                            <div class="col-md-9">
                                <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                                    <h1 class="display-4 font-weight-boldest mb-10">{{__('INVOICE')}}</h1>
                                    <div class="d-flex flex-column align-items-md-end px-0">
                                        <!--begin::Logo-->
                                        <span><img style="justify-content: right;" src="{{asset('public/asset/images/logo-2.png')}}" alt="" /></span>
                                        <!--end::Logo-->
                                    </div>
                                </div>
                                <div class="border-bottom w-100"></div>
                                <div class="d-flex justify-content-between pt-6">
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">{{__('DATE OF PURCHASE')}}</span>
                                        <span class="opacity-70">{{\Carbon\Carbon::parse($invoices->created_at)->format('d M Y') }}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">{{__('INVOICE NO.')}}</span>
                                        <span class="opacity-70">{{$invoices->invoice_id}}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">{{__('ORDER NO')}}.</span>
                                        <span class="opacity-70">{{$invoices->order_id}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice header-->
                        <!-- begin: Invoice body-->
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="pl-0 font-weight-bold text-muted text-uppercase" style="text-align: center">{{__('Package Type')}}</th>
                                            <th class="pl-0 font-weight-bold text-muted text-uppercase" style="text-align: center">{{__('Buyer Name')}}</th>
                                            <th class="pl-0 font-weight-bold text-muted text-uppercase" style="text-align: center">{{__('Buyer Email')}}</th>
                                            <th class="pl-0 font-weight-bold text-muted text-uppercase" style="text-align: center">{{__('Buyer Phone No.')}}</th>
                                            <th class="pl-0 font-weight-bold text-muted text-uppercase" style="text-align: center">{{__('Payment Method')}}</th>
                                            <th class="pl-0 font-weight-bold text-muted text-uppercase" style="text-align: center">{{__('Payment Currency')}}</th>
                                            <th class="pl-0 font-weight-bold text-muted text-uppercase" style="text-align: center">{{__('Amount paid')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="font-weight-boldest">
                                            <td class="pl-0 pt-7" style="text-align: center">{{$invoices->package_name}}</td>
                                            <td class="pl-0 pt-7" style="text-align: center">{{$invoices->customer_name}}</td>
                                            <td class="pl-0 pt-7" style="text-align: center">{{$invoices->customer_email}}</td>
                                            <td class="pl-0 pt-7" style="text-align: center">{{$invoices->customer_phone}}</td>
                                            <td class="pl-0 pt-7" style="text-align: center">{{$invoices->payment_gateway}}</td>
                                            <td class="pl-0 pt-7" style="text-align: center">{{$invoices->currency}}</td>
                                            <td class="text-danger border-top-0 pl-0 pt-7 " style="text-align: center">{{$invoices->amount_paid}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice body-->
                        <div class="pl-0 font-weight-bold text-muted text-uppercase" style="text-align: center"> Thank you! for your purchase</div>
                        <!-- begin: Invoice action-->
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-9">
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.print();">Download Invoice</button>
                                    <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">Print Invoice</button>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice action-->
                        <!-- end: Invoice-->
                    </div>
                </div>
                <!-- end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection

@section('script')

@endsection
