@extends('candidates.layouts.master')

@section('title')
    Path | Profile
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{__('Profile')}}</h5>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <div class="container">
                <!--begin::Profile Personal Information-->
                <div class="d-flex flex-row">
                    <div class="flex-row-fluid ml-lg-8">
                        <div class="card card-custom card-stretch">
                            <div class="card-header py-3">
                                <div class="card-title align-items-start flex-column">
                                    <h3 class="card-label font-weight-bolder text-dark">{{__('Personal Information')}}</h3>
                                    <span class="text-muted font-weight-bold font-size-sm mt-1">{{__('Update Information')}}</span>
                                </div>
                            </div>
                            <form method="POST" action="{{route('candidateProfile')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Avatar')}}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="image-input image-input-outline" id="kt_profile_avatar" style="background-image: url({{asset('public/backend/dist/assets/media/users/blank.png')}})">
                                                <div class="image-input-wrapper" @if(Auth::user()->avatar != null) style="background-image: url({{ asset('images/'.Auth::user()->avatar) }})" @endif></div>
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                    <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg"/>
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
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Name')}}<span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control" name="name" type="text" value="@if(isset(Auth::user()->name)) {{Auth::user()->name }} @else {{old('name') || ''}}  @endif" placeholder="Name" required/>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Email')}}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group input-group-lg input-group-solid">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="la la-at"></i>
                                                    </span>
                                                </div>
                                                <input disabled name="userEmail" type="email" class="form-control form-control-lg form-control-solid" value="{{\Illuminate\Support\Facades\Auth::user()->email}}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Match CV')}}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group ">
                                                <input name="match_cv" type="checkbox" class="form-control " @if(auth()->user()->match_cv == 1) checked @endif/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Active Account')}}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group ">
                                                <input name="account_active" type="checkbox" class="form-control " @if(auth()->user()->account_active == 1) checked @endif/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-xl-3"></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <h5 class="font-weight-bold mb-6"><i class="la la-phone"></i> {{__('Contact Info')}}</h5>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Phone 1')}}<span class="text-danger">*</span></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group ">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="la la-phone"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Phone"
                                                       @if(isset(Auth::user()->phoneNo)) value=" {{Auth::user()->phoneNo }} " @else value="{{old('phoneNo')}}" @endif name="phoneNo" required/>
                                                @error('phoneNo')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Phone 2')}}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
														<span class="input-group-text">
															<i class="la la-phone"></i>
														</span>
                                                </div>
                                                <input type="text" class="form-control" @if(isset(Auth::user()->phoneNo2)) value=" {{Auth::user()->phoneNo2 }} " @else value="{{old('phoneNo2')}}" @endif placeholder="Phone 2" name="phoneNo2" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Phone 3')}}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="la la-phone"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" @if(isset(Auth::user()->companyPhoneNo)) value=" {{Auth::user()->companyPhoneNo }} " @else value="{{old('companyPhoneNo')}}" @endif placeholder="Phone 3" name="companyPhoneNo" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Date Joined')}}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control" disabled="disabled" type="text" value="{{\Carbon\Carbon::parse(Auth::user()->created_at)->format('d M Y')}}"/>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label class="col-xl-3"></label>
                                        <div class="col-lg-9 col-xl-6">
                                            <h5 class="font-weight-bold mb-6"> <i class="la la-lock"></i> {{' '}} {{__('Change Password')}}</h5>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Current Password')}}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control" placeholder="Enter current password" name="current_password" type="password"/>
                                            @error('current_password')
                                            <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('New Password')}}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control" placeholder="Enter new password" name="new_password" type="password"/>
                                            @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">{{__('Confirm Password')}}</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control" placeholder="Confirm new password" name="new_password_confirmation" type="password"/>
                                            @error('new_password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer" style="text-align: end">
                                    <button type="submit" class="btn btn-primary mr-2">{{__('Update')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
@endsection
