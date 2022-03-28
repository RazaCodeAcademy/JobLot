@extends('backend.layouts.master')

@section('title')
	View User
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

		
			{{--  @dd($user->roles->first()->id)  --}}
			@if($user->roles->first()->id == 2)
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
											<div class="symbol-label" @if(!empty($user->profile_image)) style="background-image:url({{ asset('images/'.$user->profile_image) }})" @endif></div>
											<i class="symbol-badge bg-success"></i>
										</div>
										<div>
											<a href="{{route('viewUser', $user->id)}}" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{$user->first_name}} {{ $user->last_name }}</a>
										</div>
									</div>
									<div class="py-9">
										<div class="d-flex align-items-center justify-content-between mb-2">
											<span class="font-weight-bold mr-2">{{__('Email:')}}</span>
											<a href="mailto:{{$user->email}}" class="text-muted text-hover-primary">{{$user->email}}</a>
										</div>
										@if(!empty($user->phone_number))
											<div class="d-flex align-items-center justify-content-between mb-2">
												<span class="font-weight-bold mr-2">{{__('Phone Number:')}}</span>
												<span class="text-muted">{{$user->phone_number}}</span>
											</div>
										@endif
										
										
										@if(!empty($user->state_id))
											
											<div class="d-flex align-items-center justify-content-between">
												<span class="font-weight-bold mr-2">{{__('Location:')}}</span>
												<span class="text-muted">{{$user->comp_location ?? 'N/a'}}</span>
											</div>
										@endif
										<div class="d-flex align-items-center justify-content-between">
											<span class="font-weight-bold mr-2">{{__('Bussiness Name:')}}</span>
											<span class="text-muted">{{$user->comp_name ?? 'N/a'}}</span>
										</div>
										<div class="d-flex align-items-center justify-content-between">
											<span class="font-weight-bold mr-2">{{__('Bussiness Type:')}}</span>
											<span class="text-muted">N/a</span>
										</div>
										<div class="d-flex align-items-center justify-content-between">
											<span class="font-weight-bold mr-2">{{__('No of Jobs:')}}</span>
											<span class="text-muted">{{count($user->jobs) ?? 'N/a'}}</span>
										</div>
										<div class="d-flex align-items-center justify-content-between">
											<span class="font-weight-bold mr-2">{{__('Joining Date:')}}</span>
											<span class="text-muted">{{$user->created_at->diffForHumans() ?? 'N/a'}}</span>
										</div>
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
								<form method="POST" action="{{route('updateUser',$user->id)}}" class="form" id="submitForm" enctype="multipart/form-data">
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
													<div class="image-input-wrapper" @if(!empty($user->profile_image)) style="background-image: url({{ asset('public/images/'.$user->profile_image) }})" @endif></div>
													<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
														<i class="fa fa-pen icon-sm text-muted"></i>
														<input type="file" name="profile_image" accept=".png, .jpg, .jpeg" required/>
														
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
												<input class="form-control form-control-lg form-control-solid" name="first_name" type="text" value="{{ $user->first_name }}" />
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Email')}}</label>
											<div class="col-lg-9 col-xl-6">
												<input class="form-control form-control-lg form-control-solid" name="email" type="email" value="{{ $user->email }}" disabled />
											</div>
										</div>
									
										<div class="row">
											<label class="col-xl-3"></label>
											<div class="col-lg-9 col-xl-6">
												<h5 class="font-weight-bold mt-10 mb-6">{{__('Contact Info')}}</h5>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-xl-3 col-lg-3 col-form-label">{{__('Phone Number')}}</label>
											<div class="col-lg-9 col-xl-6">
												<div class="input-group input-group-lg input-group-solid">
													<div class="input-group-prepend">
														<span class="input-group-text">
															<i class="la la-phone"></i>
														</span>
													</div>
													<input type="text" class="form-control form-control-lg form-control-solid"placeholder="Phone Number" name="phone_number" value="{{ $user->phone_number }}" />
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
		

			@if($user->roles->first()->id == 3)
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
												<span class="text-muted">{{$user->phone_number}}</span>
											</div>
										@endif
									
										@if(!empty($user->state_id ))
											
											<div class="d-flex align-items-center justify-content-between">
												<span class="font-weight-bold mr-2">{{__('Location:')}}</span>
												<span class="text-muted">{{$user->country->name ?? 'N/A'}}</span>
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
								<form method="POST" action="{{route('updateUser',$user->id)}}" class="form" id="submitForm" enctype="multipart/form-data">
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
										
										
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif
	

			@if($user->roles->first()->id == 1)
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Account Type <span class="text-danger">*</span></label>
                            <select name="accountTypeUser" disabled class="form-control" required>
                                @if($user->roles->first()->id == 1)    <option selected="selected" disabled="disabled">{{__('Admin')}}</option>
                                @elseif($user->roles->first()->id == 2) <option selected="selected" disabled="disabled">{{__('Employer')}}</option>
                                @elseif($user->roles->first()->id == 3) <option selected="selected" disabled="disabled">{{__('Employee')}}</option>
                                @endif
                            </select>
                        </div>
                    </div>
				
						<div class="col-6">
							<div class="form-group">
								<label>{{__('Country')}} <span class="text-danger">*</span></label>
								@php
									$country = DB::Table('countries')->select('name')->where('id',$user->state_id)->first();
									@endphp
									@dd($country)
								<select name="country" disabled class="form-control" >
										<option selected disabled="disabled">{{$user->country->name ?? 'N/A'}}</option>
								</select>
							</div>
						</div>


                    <div class="col-6">
                        <div class="form-group">
                            <label>{{__('Name')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control"  placeholder="Enter Name" disabled name="Username" value="{{$user->first_name}}" required />
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
