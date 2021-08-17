@extends('backend.layouts.master')

@section('title')
	Path | Create Users
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
                                      $user = DB::table('roles')->where('id', $user_role_id->role_id)->first();
                                @endphp

                                @if($user->id == 1)
								    <a href="{{route('createUser')}}" class="text-muted">{{__('Create User')}}</a>
                                @elseif($user->id == 4)
                                    <a href="{{route('subAdminCreateUser')}}" class="text-muted">{{__('Create User')}}</a>
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
						<h3 class="card-title">{{__('Create User')}}</h3>
						<div class="card-toolbar">
							<div class="example-tools justify-content-center">
								<span class="example-toggle" data-toggle="tooltip" title="View code"></span>
								<span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
							</div>
                            <div class="card-toolbar">
                                @if($user->id == 1)
                                    <a href="{{route('listUsers')}}" class="btn btn-primary font-weight-bolder"><i class="la la-eye"></i>{{__('View Users')}}</a>
                                @elseif($user->id == 4)
                                    <a href="{{route('subAdminListUsers')}}" class="btn btn-primary font-weight-bolder"><i class="la la-eye"></i>{{__('View Users')}}</a>
                                @endif
                            </div>
						</div>
					</div>

                    @if($user->id == 1)
                        <form method="POST" action="{{route('storeUser')}}" enctype="multipart/form-data">
                    @elseif($user->id == 4)
                      <form method="POST" action="{{route('subAdminStoreUser')}}" enctype="multipart/form-data">
                    @endif
						@csrf
						<div class="card-body">
							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<label>{{__('Account Type')}} <span class="text-danger">*</span></label>
										<select name="accountTypeUser"  class="form-control" required>
											<option selected="selected" disabled="disabled" value="">{{__('Please Select Account Type')}}</option>
                                            @if ($user->id == 1)
                                                <option @if(old('accountTypeUser') == 'Admin') selected @endif value='Admin'>{{__('Admin')}}</option>
                                            @endif
											<option @if(old('accountTypeUser') == 'Employer') selected @endif value='Employer'>{{__('Employer')}}</option>
											<option @if(old('accountTypeUser') == 'Candidate') selected @endif value='Candidate'>{{__('Candidate')}}</option>
										</select>
										@error('accountTypeUser')
											<span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
										@enderror
									</div>
								</div>

                                @if ($user->id ==1)
                                    <div class="col-6">
                                    <div class="form-group">
                                        <label>{{__('Country')}} <span class="text-danger">*</span></label>
                                        <select name="country_name"  class="form-control" required>
                                            <option selected="selected" disabled="disabled" value="">{{__('Select Country')}}</option>
                                            @foreach($countries as $country)
                                            <option @if(old('country') == $country->id) selected @endif value='{{$country->id}}'>{{$country->name}}</option>
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
										<label>{{__('Name')}} <span class="text-danger">*</span></label>
										<input type="text" class="form-control"  placeholder="Enter Name" name="Username" value="{{old('Username')}}" required />
										@error('Username')
											<span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
										@enderror
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label>{{__('Email')}} <span class="text-danger">*</span></label>
										<input type="email" class="form-control"  placeholder="Enter Email" name="UserEmail" value="{{old('UserEmail')}}" required />
										@error('UserEmail')
											<span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
										@enderror
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label>{{__('Password')}}<span class="text-danger">*</span></label>
										<input type="password" class="form-control"  placeholder="Enter Password" name="user_password" value="{{old('user_password')}}" required />
										@error('user_password')
											<span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
										@enderror
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label>{{__('Confirm Password')}} <span class="text-danger">*</span></label>
										<input type="password" class="form-control"  placeholder="Confirm Password" name="user_password_confirmation" value="{{old('user_password_confirmation')}}" required />
										@error('user_password_confirmation')
											<span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
										@enderror
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer" style="text-align: end">
							<button type="submit" class="btn btn-primary mr-2">{{__('Submit')}}</button>
							<button type="reset" class="btn btn-secondary">{{__('Reset')}}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
@endsection
