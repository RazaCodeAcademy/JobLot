@extends('backend.layouts.master')

@section('title')
	List Users
@endsection

@section('css')
@endsection

@section('main-content')
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

		<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
			<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
				<div class="d-flex align-items-center flex-wrap mr-1">
					<div class="d-flex align-items-baseline flex-wrap mr-5">
						<h5 class="text-dark font-weight-bold my-1 mr-5">{{__('Users')}}</h5>
						<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
							<li class="breadcrumb-item">
								<a href="{{route('listUsers')}}" class="text-muted">{{__('List Users')}}</a>
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
							<h3 class="card-label">{{__('Users Table')}}
							<span class="d-block text-muted pt-2 font-size-sm"></span></h3>
						</div>
						<div class="card-toolbar">
                            @php 
								$user_role_id = DB::table('model_has_roles')->where('model_id', Auth::user()->id)->first();
								$userRole = DB::table('roles')->where('id', $user_role_id->role_id)->first();
                            @endphp

                            @if($userRole->id == 1)
								<a href="{{route('createUser')}}" class="btn btn-primary font-weight-bolder"><i class="la la-plus"></i> {{__('Add User')}}</a>
                            @elseif($userRole->id == 4)
								<a href="{{route('subAdminCreateUser')}}" class="btn btn-primary font-weight-bolder"><i class="la la-plus"></i> {{__('Add User')}}</a>
                            @endif
						</div>
					</div>
					<div class="card-body">
						<table class="table table-separate table-head-custom table-checkable" id="myCustomTable">
							<thead>
								<tr>
									<th>{{__('ID')}}</th>
									<th>{{__('Name')}}</th>
									<th>{{__('Email')}}</th>
									<th>{{__('Role')}}</th>
									<th>{{__('Actions')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($users as $user)
								{{--  @dd($user->roles->first()->id)  --}}
									<tr>
										<td>{{$loop->iteration}}</td>
										<td>{{$user->first_name.' '.$user->last_name}}</td>
										<td>{{$user->email}}</td>
										<td>
											@if($user->roles->first()->id == 2) 
											Employer 
											@elseif($user->roles->first()->id == 3) 
											Employee 
											@elseif($user->roles->first()->id == 1 ) 
											 Admin  
											@endif
										</td>
										<td>
                                            @if($userRole->id == 1)
                                                <a href="{{route('viewUser', $user->id)}}"><i class="la la-eye text-success mr-5"></i></a>
                                            @elseif($userRole->id == 4)
                                                <a href="{{route('subAdminViewUser', $user->id)}}"><i class="la la-eye text-success mr-5"></i></a>
                                            @endif

                                            @if($userRole->id == 1)
                                                <a href="{{route('editUser', $user->id)}}"><i class="la la-pencil-alt text-success mr-5"></i></a>
                                            @elseif($userRole->id == 4)
                                                <a href="{{route('subAdminEditUser', $user->id)}}"><i class="la la-pencil-alt text-success mr-5"></i></a>
                                            @endif

                                                @if($userRole->id == 1)
                                                    <a style="cursor: pointer" onclick="deleteFunction('{{$user->id}}') "><i class="la la-trash text-danger mr-5"></i></a>
                                                @elseif($userRole->id == 4)
                                                    <a style="cursor: pointer" onclick="deleteFunctionSubAdmin('{{$user->id}}') "><i class="la la-trash text-danger mr-5"></i></a>
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
						url: "{{route('deleteUser')}}",
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

        function deleteFunctionSubAdmin(id) {
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
                            url: "{{route('subAdminDeleteUser')}}",
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
