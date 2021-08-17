@extends('backend.layouts.master')

@section('title')
	Path | View User
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
								<a href="{{route('viewUser', $user->id)}}" class="text-muted">{{__('View User')}}</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		@php 
			$user_role_id = DB::table('model_has_roles')->where('model_id', Auth::user()->id)->first();
			$myRole = DB::table('roles')->where('id', $user_role_id->role_id)->first();

			if($myRole->id == 4){
				$routeUrl = route('subAdminUpdateUser');
			}
			else{
				$routeUrl = route('updateUser');
			}
		@endphp

		@if($user->role_id == 2)
			<div class="d-flex flex-column-fluid">
				<div class="container">
					<!--begin::Profile Personal Information-->
					<div class="d-flex flex-row">
						<!--begin::Aside-->
						<div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
							<!--begin::Profile Card-->
							<div class="card card-custom card-stretch">
								<!--begin::Body-->
								<div class="card-body pt-4 mt-1">
									<!--begin::User-->
									<div class="d-flex align-items-center">
										<div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
											<div class="symbol-label" @if($user->avatar != null) style="background-image:url({{ asset('images/'.$user->avatar) }})" @endif></div>
											<i class="symbol-badge bg-success"></i>
										</div>
										<div>
											<a href="{{route('viewUser', $user->id)}}" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{$user->name}}</a>
										</div>
									</div>
									<div class="py-9">
										<div class="d-flex align-items-center justify-content-between mb-2">
											<span class="font-weight-bold mr-2">{{__('Email:')}}</span>
											<a href="mailto:{{$user->email}}" class="text-muted text-hover-primary">{{$user->email}}</a>
										</div>
										@if($user->phoneNo != null)
											<div class="d-flex align-items-center justify-content-between mb-2">
												<span class="font-weight-bold mr-2">{{__('Phone 1:')}}</span>
												<span class="text-muted">{{$user->phoneNo}}</span>
											</div>
										@endif
										@if($user->phoneNo2 != null)
											<div class="d-flex align-items-center justify-content-between mb-2">
												<span class="font-weight-bold mr-2">{{__('Phone 2:')}}</span>
												<span class="text-muted">{{$user->phoneNo2}}</span>
											</div>
										@endif
										@if($user->companyPhoneNo != null)
											<div class="d-flex align-items-center justify-content-between mb-2">
												<span class="font-weight-bold mr-2">{{__('Phone 3:')}}</span>
												<span class="text-muted">{{$user->companyPhoneNo}}</span>
											</div>
										@endif
										@if($user->country_name != null)
											@php
												$country = DB::Table('countries')->select('name')->where('id',$user->country_name)->first();
											@endphp
											<div class="d-flex align-items-center justify-content-between">
												<span class="font-weight-bold mr-2">{{__('Location:')}}</span>
												<span class="text-muted">{{$country->name}}</span>
											</div>
										@endif
									</div>
								</div>
							</div>
						</div>
						<!--begin::Content-->
						<div class="flex-row-fluid ml-lg-8">
							<div class="card card-custom card-stretch">
								<div class="card-header py-3">
									<div class="card-title align-items-start flex-column">
										<h3 class="card-label font-weight-bolder text-dark">{{__('Personal Information')}}</h3>
										<span class="text-muted font-weight-bold font-size-sm mt-1">{{__('Update Informaiton')}}</span>
									</div>
									<div class="card-toolbar">
										<button type="button" id="submitButton" class="btn btn-success mr-2">{{__('Save Changes')}}</button>
									</div>
								</div>
								<form method="POST" action="{{$routeUrl}}" class="form" id="submitForm" enctype="multipart/form-data">
									<input type="hidden" name="id" value="{{$user->id}}">
									@csrf
									<div class="card-body">
										<div class="row">
											<label class="col-xl-3"></label>
											<div class="col-lg-9 col-xl-6">
												<h5 class="font-weight-bold mb-6">{{__('Customer Info')}}</h5>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Avatar')}}</label>
											<div class="col-lg-9 col-xl-6">
												<div class="image-input image-input-outline" id="kt_profile_avatar" style="background-image: url({{asset('public/backend/dist/assets/media/users/blank.png')}})">
													<div class="image-input-wrapper" @if($user->avatar != null) style="background-image: url({{ asset('images/'.$user->avatar) }})" @endif></div>
													<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
														<i class="fa fa-pen icon-sm text-muted"></i>
														<input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" required/>
														<input type="hidden" name="profile_avatar_remove" />
													</label>
													<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
														<i class="ki ki-bold-close icon-xs text-muted"></i>
													</span>
												</div>
												<span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Name')}}</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control form-control-lg form-control-solid" name="Username" type="text" value="{{$user->name}}" required/>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Email')}}</label>
											<div class="col-lg-9 col-xl-6">
												<input disabled class="form-control form-control-lg form-control-solid" name="userEmail" type="email" value="{{$user->email}}" />
											</div>
										</div>

										@if($myRole->id == 1)
											<div class="form-group row">
												<label class="col-xl-3 col-lg-3 col-form-label">{{__('No. of free jobs')}}</label>
												<div class="col-lg-9 col-xl-6">
													<input class="form-control form-control-lg form-control-solid" name="free_jobs" type="number" min="0" step="1" value="{{$user->free_jobs}}" />
													@error('free_jobs')
														<span class="" style="color: red">{{$message}}</span>
													@enderror
												</div>
											</div>
										@endif

										<div class="row">
											<label class="col-xl-3"></label>
											<div class="col-lg-9 col-xl-6">
												<h5 class="font-weight-bold mt-10 mb-6">{{__('Contact Info')}}</h5>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Phone 1')}}</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group input-group-lg input-group-solid">
													<div class="input-group-prepend">
														<span class="input-group-text">
															<i class="la la-phone"></i>
														</span>
													</div>
													<input type="text" class="form-control form-control-lg form-control-solid" value="{{$user->phoneNo}}" placeholder="Phone 1" name="phoneNo" />
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Phone 2')}}</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group input-group-lg input-group-solid">
													<div class="input-group-prepend">
														<span class="input-group-text">
															<i class="la la-phone"></i>
														</span>
													</div>
													<input type="text" class="form-control form-control-lg form-control-solid" value="{{$user->phoneNo2}}" placeholder="Phone 2" name="phoneNo2" />
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Phone 3')}}</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group input-group-lg input-group-solid">
													<div class="input-group-prepend">
														<span class="input-group-text">
															<i class="la la-phone"></i>
														</span>
													</div>
													<input type="text" class="form-control form-control-lg form-control-solid" value="{{$user->companyPhoneNo}}" placeholder="Phone 3" name="companyPhoneNo" />
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif

		@if($user->role_id == 3)
			<div class="d-flex flex-column-fluid">
				<div class="container">
					<!--begin::Profile Personal Information-->
					<div class="d-flex flex-row">
						<!--begin::Aside-->
						<div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
							<!--begin::Profile Card-->
							<div class="card card-custom card-stretch">
								<!--begin::Body-->
								<div class="card-body pt-4 mt-1">
									<!--begin::User-->
									<div class="d-flex align-items-center">
										<div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
											<div class="symbol-label" @if($user->avatar != null) style="background-image:url({{ asset('images/'.$user->avatar) }})" @endif></div>
											<i class="symbol-badge bg-success"></i>
										</div>
										<div>
											<a href="{{route('viewUser', $user->id)}}" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{$user->name}}</a>
										</div>
									</div>
									<div class="py-9">
										<div class="d-flex align-items-center justify-content-between mb-2">
											<span class="font-weight-bold mr-2">{{__('Email:')}}</span>
											<a href="mailto:{{$user->email}}" class="text-muted text-hover-primary">{{$user->email}}</a>
										</div>
										@if($user->phoneNo != null)
											<div class="d-flex align-items-center justify-content-between mb-2">
												<span class="font-weight-bold mr-2">{{__('Phone 1:')}}</span>
												<span class="text-muted">{{$user->phoneNo}}</span>
											</div>
										@endif
										@if($user->phoneNo2 != null)
											<div class="d-flex align-items-center justify-content-between mb-2">
												<span class="font-weight-bold mr-2">{{__('Phone 2:')}}</span>
												<span class="text-muted">{{$user->phoneNo2}}</span>
											</div>
										@endif
										@if($user->companyPhoneNo != null)
											<div class="d-flex align-items-center justify-content-between mb-2">
												<span class="font-weight-bold mr-2">{{__('Phone 3:')}}</span>
												<span class="text-muted">{{$user->companyPhoneNo}}</span>
											</div>
										@endif
										@if($user->country_name != null)
											@php
												$country = DB::Table('countries')->select('name')->where('id',$user->country_name)->first();
											@endphp
											<div class="d-flex align-items-center justify-content-between">
												<span class="font-weight-bold mr-2">{{__('Location:')}}</span>
												<span class="text-muted">{{$country->name}}</span>
											</div>
										@endif
									</div>
								</div>
							</div>
						</div>
						<!--begin::Content-->
						<div class="flex-row-fluid ml-lg-8">
							<div class="card card-custom card-stretch">
								<div class="card-header py-3">
									<div class="card-title align-items-start flex-column">
										<h3 class="card-label font-weight-bolder text-dark">{{__('Personal Information')}}</h3>
										<span class="text-muted font-weight-bold font-size-sm mt-1">{{__('Update Informaiton')}}</span>
									</div>
									<div class="card-toolbar">
										<button type="button" id="submitButton" class="btn btn-success mr-2">{{__('Save Changes')}}</button>
									</div>
								</div>
								<form method="POST" action="{{$routeUrl}}" class="form" id="submitForm" enctype="multipart/form-data">
									<input type="hidden" name="id" value="{{$user->id}}">
									@csrf
									<div class="card-body">
										<div class="row">
											<label class="col-xl-3"></label>
											<div class="col-lg-9 col-xl-6">
												<h5 class="font-weight-bold mb-6">{{__('Customer Info')}}</h5>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Avatar')}}</label>
											<div class="col-lg-9 col-xl-6">
												<div class="image-input image-input-outline" id="kt_profile_avatar" style="background-image: url({{asset('public/backend/dist/assets/media/users/blank.png')}})">
													<div class="image-input-wrapper" @if($user->avatar != null) style="background-image: url({{ asset('images/'.$user->avatar) }})" @endif></div>
													<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
														<i class="fa fa-pen icon-sm text-muted"></i>
														<input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" required/>
														<input type="hidden" name="profile_avatar_remove" />
													</label>
													<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
														<i class="ki ki-bold-close icon-xs text-muted"></i>
													</span>
												</div>
												<span class="form-text text-muted">{{__('Allowed file types: png, jpg, jpeg.')}}</span>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Name')}}</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control form-control-lg form-control-solid" name="Username" type="text" value="{{$user->name}}" required/>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Email')}}</label>
											<div class="col-lg-9 col-xl-6">
												<input disabled class="form-control form-control-lg form-control-solid" name="userEmail" type="email" value="{{$user->email}}" />
											</div>
										</div>
										<div class="row">
											<label class="col-xl-3"></label>
											<div class="col-lg-9 col-xl-6">
												<h5 class="font-weight-bold mt-10 mb-6">{{__('Contact Info')}}</h5>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Phone 1')}}</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group input-group-lg input-group-solid">
													<div class="input-group-prepend">
														<span class="input-group-text">
															<i class="la la-phone"></i>
														</span>
													</div>
													<input type="text" class="form-control form-control-lg form-control-solid" value="{{$user->phoneNo}}" placeholder="Phone 1" name="phoneNo" />
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Phone 2')}}</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group input-group-lg input-group-solid">
													<div class="input-group-prepend">
														<span class="input-group-text">
															<i class="la la-phone"></i>
														</span>
													</div>
													<input type="text" class="form-control form-control-lg form-control-solid" value="{{$user->phoneNo2}}" placeholder="Phone 2" name="phoneNo2" />
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Phone 3')}}</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group input-group-lg input-group-solid">
													<div class="input-group-prepend">
														<span class="input-group-text">
															<i class="la la-phone"></i>
														</span>
													</div>
													<input type="text" class="form-control form-control-lg form-control-solid" value="{{$user->companyPhoneNo}}" placeholder="Phone 3" name="companyPhoneNo" />
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif

        @if ($user->role_id == 4)
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Account Type <span class="text-danger">*</span></label>
                            <select name="accountTypeUser" disabled class="form-control" required>
                                @if($user->role_id == 4)    <option selected="selected" disabled="disabled">{{__('Admin')}}</option>
                                @elseif($user->role_id == 2) <option selected="selected" disabled="disabled">{{__('Employer')}}</option>
                                @elseif($user->role_id == 3) <option selected="selected" disabled="disabled">{{__('Candidate')}}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label>{{__('Country')}} <span class="text-danger">*</span></label>
                            @php
								$country = DB::Table('countries')->select('name')->where('id',$user->country_name)->first();
                            @endphp
                            <select name="country" disabled class="form-control" >
                                    <option selected disabled="disabled">{{$country->name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label>{{__('Name')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control"  placeholder="Enter Name" disabled name="Username" value="{{$user->name}}" required />
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label>{{__('Email')}} <span class="text-danger">*</span></label>
                            <input type="email" disabled class="form-control"  placeholder="Enter Email" name="UserEmail" value="{{$user->email}}" required />
                        </div>
                    </div>
                </div>
            </div>
        @endif
	</div>
@endsection

@section('script')
	<script>
		$(document).ready(function(){
			$("#submitButton").click(function(){
				$("#submitForm").submit();
			});
		});
	</script>
@endsection
