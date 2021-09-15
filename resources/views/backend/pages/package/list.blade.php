@extends('backend.layouts.master')

@section('title')
    List Packages
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <h5 class="text-dark font-weight-bold my-1 mr-5">{{__('Packages')}}</h5>
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{route('listPackages')}}" class="text-muted">{{__('List Packages')}}</a>
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
                            <h3 class="card-label">{{__('Packages Table')}}
                                <span class="d-block text-muted pt-2 font-size-sm"></span></h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{route('createPackage')}}" class="btn btn-primary font-weight-bolder"><i class="la la-plus"></i>{{__('Add Package')}}</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-separate table-head-custom table-checkable" id="myCustomTable">
                            <thead>
                            <tr>
                                <th style="text-align: center">{{__('ID')}}</th>
                                <th style="text-align: center">{{__('Package Name')}}</th>
                                <th style="text-align: center">{{__('Package for Country')}}</th>
                                <th style="text-align: center">{{__('Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <td style="text-align: center">{{$package->id}}</td>
                                    @php
                                        $packageName = \Illuminate\Support\Facades\DB::table('packages')->where('id', $package->package_id)->first();
                                        $country_id = explode(',', $packageName->countries);
                                        $countries = DB::table('countries')->select('name')->whereIn('id', $country_id)->get();
                                    @endphp
                                    <td style="text-align: center">{{$packageName->package_name}}</td>
                                    <td style="text-align: center">@foreach($countries as $key => $value) {{$value->name}} @if($loop->last) {{' '}} @else {{' | '}} @endif @endforeach</td>
                                    <td style="text-align: center">
                                        <a href="{{route('viewPackage', $package->package_id)}}"><i class="la la-eye text-success mr-5"></i></a>
                                        <a href="{{route('editPackage', $package->package_id)}}"><i class="la la-pencil-alt text-success mr-5"></i></a>
                                        <a style="cursor: pointer" onclick="deleteFunction('{{$package->package_id}}') "><i class="la la-trash text-danger mr-5"></i></a>
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
                            url: "{{route('deletePackage')}}",
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
