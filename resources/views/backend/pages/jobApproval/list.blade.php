@extends('backend.layouts.master')

@section('title')
    Path | List Job Approvals
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Job Approvals</h5>
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                @php 
                                $user_role_id = DB::table('model_has_roles')->where('model_id', Auth::user()->id)->first();
                                     $user = DB::table('roles')->where('id', $user_role_id->role_id)->first();
                                @endphp

                                @if($user->id == 1)
                                    <a href="{{route('listJobApproval')}}" class="text-muted">List Job Approvals</a>
                                @elseif($user->id == 4)
                                    <a href="{{route('subAdminListJobApproval')}}" class="text-muted">List Job Approvals</a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label">Job Approvals Table
                                <span class="d-block text-muted pt-2 font-size-sm"></span></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-separate table-head-custom table-checkable" id="myCustomTable">
                            <thead>
                            <tr>
                                <th style="text-align: center">Sr No.</th>
                                <th style="text-align: center">Job title</th>
                                <th style="text-align: center">Job category</th>
                                <th style="text-align: center">Job location</th>
                                <th style="text-align: center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php $SrNo = 0; @endphp
                                @foreach ($jobs as $job)
                                    @php $SrNo++; $location = DB::table('countries')->where('id', $job->job_location)->first(); @endphp
                                    <tr>
                                        <td style="text-align: center">{{$SrNo}}</td>
                                        @if ($user->id == 1)
                                            <td style="text-align: center"><a href="{{route('employerJobDetail', encrypt($job->id))}}">{{$job->title}}</a></td>
                                        @elseif($user->id == 4)
                                            <td style="text-align: center"><a href="{{route('employerJobDetailSubAdmin', encrypt($job->id))}}">{{$job->title}}</a></td>
                                        @endif
                                        <td style="text-align: center">{{$job->category}}</td>
                                        <td style="text-align: center">{{$location->name}}</td>
                                        <td style="text-align: center">
                                            @if ($user->id == 1)
                                                <a onclick="jobAcceptFunction('{{$job->id}}', '1')" style="cursor: pointer"><i class="las la-check-circle" style="color: green;font-size: 40px;"></i></a>
                                                <a onclick="jobDeclineFunction('{{$job->id}}', '2', {{$job->user_id}})" style="cursor: pointer"><i class="las la-times-circle" style="color: red;font-size: 40px;"></i></a>
                                            @elseif($user->id == 4)
                                                <a onclick="jobAcceptFunctionSubAdmin('{{$job->id}}', '1')" style="cursor: pointer"><i class="las la-check-circle" style="color: green;font-size: 40px;"></i></a>
                                                <a onclick="jobDeclineFunctionSubAdmin('{{$job->id}}', '2', {{$job->user_id}})" style="cursor: pointer"><i class="las la-times-circle" style="color: red;font-size: 40px;"></i></a>
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
        function jobAcceptFunction(id,value) {
            swal({
                title: "Are you sure?",
                text: "Press ok to proceed",
                icon: "success",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            method: "POST",
                            url: "{{route('jobStatus')}}",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                'id': id,
                                'value': value
                            },
                            success: function (response) {
                                if(response.status === 1){
                                    swal("Successfully Accepted", {
                                        icon: "success",
                                    });
                                    window.setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                }
                                else{
                                    swal("Error While Processing! Try Again", {
                                        icon: "error",
                                    });
                                }
                            }
                        });

                    } else {
                        swal("Nothing done!");
                    }
                });
        }

        function jobDeclineFunction(id,value,user_id) {
            swal({
                title: "Are you sure?",
                text: "Once rejected, you will not be able to recover!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            method: "POST",
                            url: "{{route('jobStatus')}}",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                'id': id,
                                'value': value,
                                'user_id': user_id
                            },
                            success: function (response) {
                                if(response.status === 1){
                                    swal("Successfully Rejected", {
                                        icon: "success",
                                    });
                                    window.setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                }
                                else{
                                    swal("Error While Rejecting", {
                                        icon: "error",
                                    });
                                }
                            }
                        });

                    } else {
                        swal("Nothing Done!");
                    }
                });
        }

        function jobAcceptFunctionSubAdmin(id,value) {
            swal({
                title: "Are you sure?",
                text: "Press ok to proceed",
                icon: "success",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            method: "POST",
                            url: "{{route('subAdminJobStatus')}}",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                'id': id,
                                'value': value
                            },
                            success: function (response) {
                                if(response.status === 1){
                                    swal("Successfully Accepted", {
                                        icon: "success",
                                    });
                                    window.setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                }
                                else{
                                    swal("Error While Processing! Try again", {
                                        icon: "error",
                                    });
                                }
                            }
                        });

                    } else {
                        swal("Nothing done!");
                    }
                });
        }

        function jobDeclineFunctionSubAdmin(id,value,user_id) {
            swal({
                title: "Are you sure?",
                text: "Once rejected, you will not be able to recover!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            method: "POST",
                            url: "{{route('subAdminJobStatus')}}",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                'id': id,
                                'value': value,
                                'user_id': user_id
                            },
                            success: function (response) {
                                if(response.status === 1){
                                    swal("Successfully Rejected", {
                                        icon: "success",
                                    });
                                    window.setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                }
                                else{
                                    swal("Error While Rejecting", {
                                        icon: "error",
                                    });
                                }
                            }
                        });

                    } else {
                        swal("Nothing Done!");
                    }
                });
        }
    </script>
@endsection
