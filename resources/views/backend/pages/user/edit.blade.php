@extends('backend.layouts.master')

@section('title')
	Path | Update User
@endsection

@section('css')
@endsection

@section('main-content')
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

		<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
			<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
				<div class="d-flex align-items-center flex-wrap mr-1">
					<div class="d-flex align-items-baseline flex-wrap mr-5">
						<h5 class="text-dark font-weight-bold my-1 mr-5">Users</h5>
						<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
							<li class="breadcrumb-item">
                                @php $user_role_id = DB::table('model_has_roles')->where('model_id', Auth::user()->id)->first();
                                      $userRole = DB::table('roles')->where('id', $user_role_id->role_id)->first();
                                @endphp

                                @if($userRole->id == 1)
								<a href="{{route('editUser', $user->id)}}" class="text-muted">Update User</a>
                                @elseif($userRole->id == 4)
                                    <a href="{{route('subAdminEditUser', $user->id)}}" class="text-muted">Update User</a>
                                @endif
                            </li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="d-flex flex-column-fluid">
			<div class="container">
				<div class="card card-custom">
					<div class="card-header">
						<h3 class="card-title">Update User</h3>
						<div class="card-toolbar">
							<div class="example-tools justify-content-center">
								<span class="example-toggle" data-toggle="tooltip" title="View code"></span>
								<span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
							</div>
                            <div class="card-toolbar">
                                @if($userRole->id == 1)
                                    <a href="{{route('listUsers')}}" class="btn btn-primary font-weight-bolder"><i class="la la-eye"></i> Users List</a>
                                @elseif($userRole->id == 4)
                                    <a href="{{route('subAdminListUsers')}}" class="btn btn-primary font-weight-bolder"><i class="la la-eye"></i> Users List</a>
                                @endif
                            </div>
						</div>
					</div>

                    @if($userRole->id == 1)
                        <form method="POST" action="{{route('updateUser')}}" enctype="multipart/form-data">
                    @elseif($userRole->id == 4)
                        <form method="POST" action="{{route('subAdminUpdateUser')}}" enctype="multipart/form-data">
                    @endif

						@csrf
						<div class="card-body">
							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<label>Account Type <span class="text-danger">*</span></label>
                                        @if ($userRole->id == 1)
                                            <select name="accountTypeUser" disabled class="form-control" required>
                                                @if($user->role_id == 4)    <option selected="selected" disabled="disabled">Admin</option>
                                                @elseif($user->role_id == 2) <option selected="selected" disabled="disabled">Employer</option>
                                                @elseif($user->role_id == 3) <option selected="selected" disabled="disabled">Candidate</option>
                                                @endif
                                            </select>
                                        @else
                                            <select name="accountTypeUser" disabled class="form-control" required>
                                                @if($user->role_id == 2) <option selected="selected" disabled="disabled">Employer</option>
                                                @elseif($user->role_id == 3) <option selected="selected" disabled="disabled">Candidate</option>
                                                @endif
                                            </select>
                                        @endif
										@error('accountTypeUser')
											<span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
										@enderror
									</div>
								</div>

                                @if ($userRole->id == 1)
                                 <div class="col-6">
                                    <div class="form-group">
                                        <label>Country <span class="text-danger">*</span></label>
                                        <select name="country_name"  class="form-control" >
                                            <option selected="selected" disabled="disabled" value="">Select Country</option>
                                            @foreach($countries as $country)
                                                <option @if($user->country_name == $country->id) selected @endif value='{{$country->id}}'>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @endif

								<div class="col-6">
									<div class="form-group">
										<label>Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control"  placeholder="Enter Name" name="Username" value="{{$user->name}}" required />
										@error('Username')
											<span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
										@enderror
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label>Email <span class="text-danger">*</span></label>
										<input type="email" disabled class="form-control"  placeholder="Enter Email" name="UserEmail" value="{{$user->email}}" required />
										@error('UserEmail')
											<span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
										@enderror
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer" style="text-align: end">
							<input type="hidden" name="id" value="{{$user->id}}"/>
							<button type="submit" class="btn btn-primary mr-2">Update</button>
							<button type="reset" class="btn btn-secondary">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
@endsection
