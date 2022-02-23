@extends('backend.layouts.master')

@section('title')
	Update User
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
                                @php $user_role_id = DB::table('model_has_roles')->where('model_id', Auth::user()->id)->first();
                                      $userRole = DB::table('roles')->where('id', $user_role_id->role_id)->first();
                                @endphp

                                @if($userRole->id == 1)
								<a href="{{route('editUser', $user->id)}}" class="text-muted">{{__('Update User')}}</a>
                                @elseif($userRole->id == 4)
                                    <a href="{{route('subAdminEditUser', $user->id)}}" class="text-muted">{{__('Update User')}}</a>
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
						<h3 class="card-title">{{__('Update User')}}</h3>
						<div class="card-toolbar">
							<div class="example-tools justify-content-center">
								<span class="example-toggle" data-toggle="tooltip" title="View code"></span>
								<span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
							</div>
                            <div class="card-toolbar">
                                @if($userRole->id == 1)
                                    <a href="{{route('listUsers')}}" class="btn btn-primary font-weight-bolder"><i class="la la-eye"></i> {{__('Users List')}}</a>
                                @elseif($userRole->id == 4)
                                    <a href="{{route('subAdminListUsers')}}" class="btn btn-primary font-weight-bolder"><i class="la la-eye"></i> {{__('Users List')}}</a>
                                @endif
                            </div>
						</div>
					</div>

                    @if($userRole->id == 1)
                        <form method="POST" action="{{route('updateUser',$user->id)}}" enctype="multipart/form-data">
                    @elseif($userRole->id == 4)
                        <form method="POST" action="{{route('subAdminUpdateUser')}}" enctype="multipart/form-data">
                    @endif

						@csrf
						<div class="card-body">
							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<label>{{__('Account Type')}} <span class="text-danger">*</span></label>
                                        @if ($user->roles->first()->id == 1)
                                            <select name="accountTypeUser" disabled class="form-control" required>
                                                @if($user->roles->first()->id == 1)    <option selected="selected" disabled="disabled">{{__('Admin')}}</option>
                                                @elseif($user->roles->first()->id == 2) <option selected="selected" disabled="disabled">{{__('Employer')}}</option>
                                                @elseif($user->roles->first()->id == 3) <option selected="selected" disabled="disabled">{{__('Employee')}}</option>
                                                @endif
                                            </select>
                                        @else
                                            <select name="accountTypeUser" disabled class="form-control" required>
                                                @if($user->roles->first()->id == 2) <option selected="selected" disabled="disabled">{{__('Employer')}}</option>
                                                @elseif($user->roles->first()->id == 3) <option selected="selected" disabled="disabled">{{__('Employee')}}</option>
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
								
								<div class="col-6">
								<div class="form-group">
									<label>{{__('First_name')}} <span class="text-danger">*</span></label>
									<input type="text" name="first_name"  value="{{ $user->first_name }}" class="form-control" required>
									  
									@error('first_name')
									<span class="invalid-feedback" role="alert">
										{{ $message }}
									</span>
									@enderror
								</div>
							</div>
							

							<div class="col-6">
								<div class="form-group">
									<label>{{__('Last_Name')}} <span class="text-danger">*</span></label>
									<input type="text" class="form-control" value="{{ $user->last_name }}"  placeholder="Enter last Name" name="last_name"  required />
									@error('last_name')
										<span class="invalid-feedback" role="alert">
											{{ $message }}
										</span>
									@enderror
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>{{__('Street Address')}} <span class="text-danger">*</span></label>
									<input type="text" class="form-control"  placeholder="Enter Name" name="street_address" value="{{ $user->street_address  }}" required />
									@error('street_address')
										<span class="invalid-feedback" role="alert">
											{{ $message }}
										</span>
									@enderror
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>{{__('State')}} <span class="text-danger">*</span></label>
									<select name="state_id"  class="form-control" required>
										<option selected="selected" disabled="disabled" value="">{{__('Select State')}}</option>
										@foreach($countries as $country)
										<option value='{{$country->id}}' {{ $user->state_id == $country->id ? 'selected' : ""}}>{{$country->name}}</option>
										@endforeach
									</select>
									@error('State')
										<span class="invalid-feedback" role="alert">
											{{ $message }}
										</span>
									@enderror
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>{{__('City Name')}} <span class="text-danger">*</span></label>
									<select name="city_name"  class="form-control" required>
										<option selected="selected" disabled="disabled" value="">{{__('Select State')}}</option>
										@foreach($cities as $city)
										<option value='{{$city->id}}' {{ $user->city_name == $city->id ? 'selected' : ""}}>{{$city->name}}</option>
										@endforeach
									</select>
									@error('last_name')
										<span class="invalid-feedback" role="alert">
											{{ $message }}
										</span>
									@enderror
								</div>
							</div>
							
							<div class="col-6">
								<div class="form-group">
									<label>{{__('Zip Code')}} <span class="text-danger">*</span></label>
									<input type="number" class="form-control"   placeholder="Enter Name" name="zip_code" value="{{ $user->zip_code }}" required />
									@error('State')
										<span class="invalid-feedback" role="alert">
											{{ $message }}
										</span>
									@enderror
								</div>
							</div>

							<div class="col-6">
								<div class="form-group">
									<label>{{__('Email')}} <span class="text-danger">*</span></label>
									<input type="email" class="form-control"  placeholder="Enter Email" name="UserEmail" value="{{ $user->email }}" required />
									@error('UserEmail')
										<span class="invalid-feedback" role="alert">
											{{ $message }}
										</span>
									@enderror
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label>{{__('Phone Number')}} <span class="text-danger">*</span></label>
									<input type="number" class="form-control"  placeholder="Enter Name" name="phone_number" value="{{$user->phone_number}}" required />
									@error('State')
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
							<input type="hidden" type="number" name="free_jobs" value="{{$user->free_jobs}}"/>
							<button type="submit" class="btn btn-primary mr-2">{{__('Update')}}</button>
							<button type="reset" class="btn btn-secondary">{{__('Cancel')}}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
@endsection
