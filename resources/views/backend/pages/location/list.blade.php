@extends('backend.layouts.master')

@section('title')	
	Path | List Job Locations
@endsection

@section('css')
@endsection

@section('main-content')
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

		<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
			<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
				<div class="d-flex align-items-center flex-wrap mr-1">
					<div class="d-flex align-items-baseline flex-wrap mr-5">
						<h5 class="text-dark font-weight-bold my-1 mr-5">Job Locations</h5>
						<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
							<li class="breadcrumb-item">
								<a href="{{route('listLocations')}}" class="text-muted">List Job Locations</a>
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
							<h3 class="card-label">Job Locations Table
							<span class="d-block text-muted pt-2 font-size-sm"></span></h3>
						</div>
						<div class="card-toolbar">
							<a href="{{route('createLocation')}}" class="btn btn-primary font-weight-bolder"><i class="la la-plus"></i> Add Job Location</a>
						</div>
					</div>
					<div class="card-body">
						<table class="table table-separate table-head-custom table-checkable" id="myCustomTable">
							<thead>
								<tr>
									<th>ID</th>
									<th>Location</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($locations as $location)
									<tr>
										<td>{{$location->id}}</td>
										<td>{{$location->location}}</td>
										<td>
											<a href="{{route('editLocation', $location->id)}}"><i class="la la-pencil-alt text-success mr-5"></i></a>
											<a style="cursor: pointer" onclick="deleteFunction('{{$location->id}}') "><i class="la la-trash text-danger mr-5"></i></a>
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
						url: "{{route('deleteLocation')}}",
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