@extends('backend.layouts.master')

@section('title')
    Path | List Advertisements
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{__('List of Advertisements')}}</h5>
                </div>
            </div>
        </div>

        @php $user_role_id = DB::table('model_has_roles')->where('model_id', Auth::user()->id)->first();
                      $user = DB::table('roles')->where('id', $user_role_id->role_id)->first();
        @endphp

        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">{{__('List of Advertisements')}}
                            <span class="d-block text-muted pt-2 font-size-sm"></span></h3>
                    </div>
                    <div class="card-toolbar">
                        @if ($user->id == 1)
                            <a href="{{route('createAdvertise')}}" class="btn btn-primary font-weight-bolder"><i class="la la-plus"></i> {{__('Add Advertise')}}</a>
                        @elseif($user->id  == 4)
                            <a href="{{route('subAdminCreateAdvertise')}}" class="btn btn-primary font-weight-bolder"><i class="la la-plus"></i> {{__('Add Advertise')}}</a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable" id="myCustomTable">
                        <thead>
                        <tr>
                            <th style="text-align:center;">{{__('Name')}}</th>
                            <th style="text-align:center;">{{__('Country')}}</th>
                            <th style="text-align:center;">{{__('Employer')}}</th>
                            {{--  <th style="text-align:center;">Image(s)</th>  --}}
                            <th style="text-align:center;">{{__('Total Views')}}</th>
                            <th style="text-align:center;">{{__('Total Clicks')}}</th>
                            <th style="text-align:center;">{{__('Status')}}</th>
                            <th style="text-align:center;">{{__('Start Date')}}</th>
                            <th style="text-align:center;">{{__('End Date')}}</th>
                            <th>{{__('Actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($advertisements as $advertisement)
                            @php
                                $country_id = explode(',', $advertisement->countries);
                                $countries = DB::table('countries')->whereIn('id',$country_id)->get();
                                $employerName = DB::table('users')->where('id',$advertisement->employer)->first();
                                $images = DB::table('advertisements_images')->where('ad_id', $advertisement->id)->get();
                            @endphp
                            <tr>
                                <td style="text-align:center;">{{$advertisement->title}}</td>
                                <td style="text-align:center;">@foreach($countries as $country) {{$country->name}} @if($loop->last) {{''}} @else {{"|"}} @endif @endforeach</td>
                                <td style="text-align:center;">{{$employerName->name}}</td>
                                {{--  <td style="text-align:center;">
                                    @foreach($images as $image)
                                        <img style="display: block; !important;" src="{{asset('images/'.$image->image)}}" id="image" width="90" height="90" class="thumbnail-image-50" />
                                    @endforeach
                                </td>  --}}
                                <td style="text-align:center;">{{views($advertisement)->unique()->count()}}</td>
                                <td style="text-align:center;">{{views($advertisement)->count()}}</td>
                                <td style="text-align:center;">
                                    @if ($user->id == 1)
                                        <select name="status" id="status" data-class="{{$advertisement->id}}" class="form-control status" required>
                                            <option @if($advertisement->status == 1) selected @endif value = 1>{{__('Active')}}</option>
                                            <option @if($advertisement->status == 0) selected @endif value = 0>{{__('In-Active')}}</option>
                                        </select>
                                    @elseif($user->id == 4)
                                        <select name="status" id="statusSubAdmin" data-class="{{$advertisement->id}}" class="form-control statusSubAdmin" required>
                                            <option @if($advertisement->status == 1) selected @endif value = 1>{{__('Active')}}</option>
                                            <option @if($advertisement->status == 0) selected @endif value = 0>{{__('In-Active')}}</option>
                                        </select>
                                    @endif
                                </td>
                                <td style="text-align:center;">{{\Carbon\Carbon::parse($advertisement->start_date)->format('d M Y') }}</td>
                                <td style="text-align:center;">{{\Carbon\Carbon::parse($advertisement->end_date)->format('d M Y') }}</td>
                                <td style="text-align:center;">
{{--                                    <a href="{{route('viewAdvertise', $advertisement->id)}}"><i class="la la-eye text-success mr-5"></i></a>--}}
                                    @if($user->id == 1)
                                        <a href="{{route('editAdvertise', $advertisement->id)}}"><i class="la la-pencil-alt text-success mr-5"></i></a>
                                        <a style="cursor: pointer" onclick="deleteFunction('{{$advertisement->id}}') "><i class="la la-trash text-danger mr-5"></i></a>
                                    @elseif($user->id == 4)
                                        <a href="{{route('subAdminEditAdvertise', $advertisement->id)}}"><i class="la la-pencil-alt text-success mr-5"></i></a>
                                        <a style="cursor: pointer" onclick="deleteSubAdminFunction('{{$advertisement->id}}') "><i class="la la-trash text-danger mr-5"></i></a>
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
@endsection

@section('script')
    <script>

        $('.status').on('change', function ()
        {
            let ad_id = $(this).data('class');
            let status_id = $(this).val();

            $.ajax({
                method: "POST",
                url: "{{route('statusAdvertise')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    'ad_id': ad_id,
                    'status_id': status_id,
                },
                success: function (response) {
                    if (response.status === 1) {
                        swal("Successfully Updated", {
                            icon: "success",
                        });
                    } else {
                        swal("Error While Updating", {
                            icon: "error",
                        });
                    }
                }
            });
        });

        $('.statusSubAdmin').on('change', function ()
        {
            let ad_id = $(this).data('class');
            let status_id = $(this).val();

            $.ajax({
                method: "POST",
                url: "{{route('subAdminStatusAdvertise')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    'ad_id': ad_id,
                    'status_id': status_id,
                },
                success: function (response) {
                    if (response.status === 1) {
                        swal("Successfully Updated", {
                            icon: "success",
                        });
                    } else {
                        swal("Error While Updating", {
                            icon: "error",
                        });
                    }
                }
            });
        });

        function deleteFunction(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            method: "POST",
                            url: "{{route('deleteAdvertise')}}",
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

        function deleteSubAdminFunction(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            method: "POST",
                            url: "{{route('subAdminDeleteAdvertise')}}",
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
