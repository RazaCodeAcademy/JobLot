@extends('employer.layouts.master')

@section('title')
    Payment History
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{__('History')}}</h5>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">  {{__('Payment history')}}
                                <span class="d-block text-muted pt-2 font-size-sm"></span></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-separate table-head-custom table-checkable" id="myCustomTable">
                            <thead>
                            <tr>
                                <th style="text-align: center">#</th>
                                <th style="text-align: center">{{__('Purchased Package')}}</th>
                                <th style="text-align: center">{{__('Purchased Date')}}</th>
                                <th style="text-align: center">{{__('Amount Paid')}}</th>
                                <th style="text-align: center">{{__('Jobs Posting Limit')}}</th>
                                <th style="text-align: center">{{__('Total Posting')}}</th>
                                <th style="text-align: center">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $SrNo = 0; @endphp
                            @foreach ($employeePackages as $employeePackage)
                               @php $SrNo++ @endphp
                                <tr>
                                    <td style="text-align: center">{{$SrNo}}</td>
                                    <td style="text-align: center"><h3>{{$employeePackage->package_name}}</h3></td>
                                    <td style="text-align: center">{{\Carbon\Carbon::parse($employeePackage->created_at)->format('d M Y') }}</td>
                                    <td style="text-align: center">{{$employeePackage->amount_paid}}</td>
                                    <td style="text-align: center">{{$employeePackage->jobs_limit}}</td>
                                    <td style="text-align: center">{{$employeePackage->jobs_count}}</td>
                                    <td style="text-align: center">
                                        <a href="{{route('invoice', encrypt($employeePackage->id))}}"><i class="la la-eye text-info mr-5"></i></a>
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

@endsection
