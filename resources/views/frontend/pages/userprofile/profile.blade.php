@extends('frontend.layouts.master')
@section('content')
    <div class="profile">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8" style="box-shadow: 0 0 1rem #cccc;">
                    <div class="my-profile d-flex justify-content-between">
                        <p class="">My Profile</p>
                        <img src="./img/icons/Icon material-edit.svg" class="img-fluid" alt="">
                    </div>
                    <div class="profile-box">
                        <div class="user-img">
                            <img src="{{  user()->get_image() }}" class="img-fluid" alt="">
                            <h2 class="name">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h2>
                            <span>{{Auth::user()->street_address}}|</span><span>{{Auth::user()->zip_code}}</span>
                        </div>
                        <form class="main-form" method="POST" action="{{route('update-employee-details-page')}}" enctype="multipart/form-data">
                            @csrf 
                            <div class="profile-fields">
                                <div class="mb-3">
                                    <label for="email">Email</label><br>
                                    <input type="email" name="email" value="{{Auth::user()->email}}" readonly="" id="exampleFormControlInput1" placeholder="Email">
                                </div>
                                <div class="input-group mb-5">
                                    <label for="phone">Phone Number</label><br>
                                    <input type="text" name="phone_number" value="{{Auth::user()->phone_number}}" class="form-control" placeholder="Number">
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="first_name">First Name</label><br>
                                        <input type="text" name="first_name"  value="{{Auth::user()->first_name}}" placeholder="First name" aria-label="First name">
                                        @if ($errors->has('first_name'))
                                            <div> <span  class="text-danger" id="first_nameError">{{ $errors->first('first_name') }}</span></div>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <label for="last_name">Last Name</label><br>
                                        <input type="text" name="last_name" value="{{Auth::user()->last_name}}" placeholder="Last name" aria-label="Last name">
                                        @if ($errors->has('last_name'))
                                         <div> <span  class="text-danger" id="last_nameError">{{ $errors->first('last_name') }}</span></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Profile Image</label>
                                    <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*"/>
                                </div>    
                                <div class="main-form-control">
                                    <label for="Zipcode">Zipcode</label><br>
                                    <input type="text" name="zip_code" value="{{Auth::user()->zip_code}}"  placeholder="Zipcode">
                                </div>
                                <div class="main-form-control">
                                    <label for="Date of Birth">Date of Birth</label><br>
                                    <input type="text" name="dob" value="{{Auth::user()->dob}}" placeholder="Date of Birth">
                                </div>
                                <div class="mb-3">
                                    <label for="Street Address">Street Address</label><br>
                                    <input type="text" name="street_address" value="{{Auth::user()->street_address}}" id="exampleFormControlInput1" placeholder="Street Address">
                                    @if ($errors->has('street_address'))
                                        <div> <span  class="text-danger" id="street_addressError">{{ $errors->first('street_address') }}</span></div>
                                    @endif  
                                </div>
                                <div class="form-actions right">
                                    <button type="submit" class="btn btn-primary">
                                      <i class="la la-check-square-o"></i> Save
                                    </button>
                                    <button type="button" class="btn btn-warning mr-1">
                                      <i class="ft-x"></i> Cancel
                                    </button>
                                  </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection