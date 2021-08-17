@extends('backend.layouts.master')

@section('title')	
	Path | List Cities
@endsection

@section('css')
@endsection

@section('main-content')
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

		<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
			<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
				<div class="d-flex align-items-center flex-wrap mr-1">
					<div class="d-flex align-items-baseline flex-wrap mr-5">
						<h5 class="text-dark font-weight-bold my-1 mr-5">{{__('Cities')}}</h5>
						<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
							<li class="breadcrumb-item">
								<a href="{{route('listCities')}}" class="text-muted">{{__('List Cities')}}</a>
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
							<h3 class="card-label">{{__('Cities Table')}}
							<span class="d-block text-muted pt-2 font-size-sm"></span></h3>
						</div>
						<div class="card-toolbar">
							<a href="{{route('createCity')}}" class="btn btn-primary font-weight-bolder"><i class="la la-plus"></i>{{__('Add City')}}</a>
						</div>
					</div>
					<div class="card-body">
						<table class="table table-separate table-head-custom table-checkable" id="myCustomTable">
							<thead>
								<tr>
									<th>{{__('ID')}}</th>
									<th>{{__('Name')}}</th>
									<th>{{__('Country')}}</th>
									<th>{{__('Actions')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($cities as $city)
									<tr>
										<td>{{$city->id}}</td>
										<td>{{ (session()->has('language')) ? $city->name_ar : $city->name }}</td>
										<td>
											@php
												$country = DB::table('countries')->find($city->id);
											@endphp
											@if(isset($country))
												{{ (session()->has('language')) ? $country->name_ar : $country->name }}
											@endif
										</td>
										<td>
											<a href="{{route('editCity', $city->id)}}"><i class="la la-pencil-alt text-success mr-5"></i></a>
											<a style="cursor: pointer" onclick="deleteFunction('{{$city->id}}') "><i class="la la-trash text-danger mr-5"></i></a>
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
						url: "{{route('deleteCity')}}",
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