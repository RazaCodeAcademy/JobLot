<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="../../../">
        <meta charset="utf-8" />
        <title>Register | Employer</title>
        <meta name="description" content="Add user example" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="canonical" href="https://keenthemes.com/metronic" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <link href="{{asset('/public/employer/dist/assets/css/pages/wizard/wizard-4.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/employer/dist/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/employer/dist/assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/employer/dist/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/employer/dist/assets/css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/employer/dist/assets/css/themes/layout/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/employer/dist/assets/css/themes/layout/brand/dark.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('/public/employer/dist/assets/css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" type="text/css" href="{{asset('/public/css/main.css')}}">

        <link rel="icon" href="{{asset('/public/asset/images/logo.png')}}">

        <style>
            .select2-container {
                width: 100% !important;
            }

            .headerSeparator{
                width:100%; height:60px;
            }
        </style>
    </head>

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <header class="header-2" style="position:fixed; top:0; width:100%;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-top">
                        <div class="logo-area">
                            <a href="{{route('welcome')}}"><img src="{{asset('/public/asset/images/logo-2.png')}}" alt=""></a>
                        </div>
                        <div class="header-top-toggler">
                            <div class="header-top-toggler-button"></div>
                        </div>
                        <div class="top-nav">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <div class="headerSeparator"></div>

    <div class="d-flex flex-column flex-root" style="margin-top: 100px;">
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="d-flex flex-column-fluid">
                <div class="container">
                    <div class="card card-custom card-transparent">
                        <div class="card-body p-0">
                            <div class="wizard wizard-4" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="false">
                                {{-- Steps --}}
                                <div class="wizard-nav">
                                    <div class="wizard-steps">
                                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                            <div class="wizard-wrapper">
                                                <div class="wizard-number">1</div>
                                                <div class="wizard-label">
                                                    <div class="wizard-title">{{__('Account Registeration')}}</div>
                                                    <div class="wizard-desc">{{__('Account Details')}}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="wizard-step" data-wizard-type="step">
                                            <div class="wizard-wrapper">
                                                <div class="wizard-number">2</div>
                                                <div class="wizard-label">
                                                    <div class="wizard-title">{{__('Company Information')}}</div>
                                                    <div class="wizard-desc">{{__('Add Details')}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wizard-step" data-wizard-type="step">
                                            <div class="wizard-wrapper">
                                                <div class="wizard-number">3</div>
                                                <div class="wizard-label">
                                                    <div class="wizard-title">{{__('Submission')}}</div>
                                                    <div class="wizard-desc">{{__('Review and Submit')}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Steps Content --}}
                                <div class="card card-custom card-shadowless rounded-top-0">
                                    <div class="card-body p-0">
                                        <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                                            <div class="col-xl-12 col-xxl-10">
                                                <form class="form" action="{{route('employerRegisteration')}}" method="POST" id="kt_form" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row justify-content-center">
                                                        <div class="col-xl-9">

                                                            {{-- Step 1 --}}
                                                            <div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('Email Address')}}</label>
                                                                    <div class="col-lg-9 col-xl-9">
                                                                        <div class="input-group input-group-solid input-group-lg">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="la la-at"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" class="form-control form-control-solid form-control-lg" name="email" placeholder="Email" value="{{ session()->get('register.email') }}" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('Password')}}</label>
                                                                    <div class="col-lg-9 col-xl-9">
                                                                        <div class="input-group input-group-solid input-group-lg">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="la la-lock"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input class="form-control" placeholder="Enter password" name="password" type="password"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label">{{__('Confirm Password')}}</label>
                                                                    <div class="col-lg-9 col-xl-9">
                                                                        <div class="input-group input-group-solid input-group-lg">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="la la-lock"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input class="form-control" placeholder="Confirm password" name="confirmPassword" type="password"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- Step 2 --}}
                                                            <div class="my-5 step" data-wizard-type="step-content">
                                                                <h5 class="text-dark font-weight-bold mb-10">{{__('Company Details:')}}</h5>
                                                                <div class="form-group">
                                                                    <label class="col-form-label">{{__('Company Logo')}}</label><br>
                                                                    <div class="image-input image-input-outline" id="kt_profile_avatar" style="background-image: url({{asset('/public/backend/dist/assets/media/users/blank.png')}})">
                                                                        <div class="image-input-wrapper" ></div>
                                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                                            <input type="file" id="profile_avatar" name="profile_avatar" accept=".png, .jpg, .jpeg"/>
                                                                            <input type="hidden" name="profile_avatar_remove" />
                                                                        </label>
                                                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input  type="hidden" value="" id="imageValue">
                                                                    <span class="form-text text-muted">{{__('Allowed file types: png, jpg, jpeg.')}}</span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>{{__('Company Name')}} <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="name" id="name" placeholder="Enter name" value="" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>{{__('Phone 1')}} <span class="text-danger">*</span></label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="la la-phone"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Phone 1" value="" name="phoneNo" required/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>{{__('Phone 2')}}</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="la la-phone"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Phone 2" value="" name="phoneNo2"/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>{{__('Phone 3')}}</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="la la-phone"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Phone 3" value="" name="companyPhoneNo"/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>{{__('Website')}}</label>
                                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="companyWebAddress" placeholder="Company website link" value="" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>{{__('Company Brief')}} <span class="text-danger">*</span></label>
                                                                    <textarea type="text" class="form-control form-control-solid form-control-lg" name="aboutus" rows="3" maxlength="255" placeholder="Company Description"></textarea>
                                                                    <span class="form-text text-muted">{{__('Description can be of no more than 255 characters')}}</span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>{{__('Location')}} <span class="text-danger">*</span></label>
                                                                    <select name="country_name" id="country_id" class="form-control form-control-solid form-control-lg">
                                                                        <option selected disabled value="">{{__('Select')}}</option>
                                                                        @foreach($countries as $country)
                                                                            <option value="{{$country->id}}">{{(session()->has('language')) ? $country->name_ar : $country->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>{{__('Field/Industry')}}<span class="text-danger">*</span></label>
                                                                    <select name="category" id="category" class="form-control select2-container js-example-basic-multiple" multiple="multiple">
                                                                        @foreach($fields as $field)
                                                                            <option value="{{$field->id}}">{{(session()->has('language')) ? $field->category_ar : $field->category}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <h5 class="text-dark font-weight-bold mb-10">{{__('Social Media Account(s)')}}</h5>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="la la-instagram"></i>
                                                                        </span>
                                                                        </div>
                                                                        <input class="form-control" name="instagramlink" type="text" value="" />
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="la la-twitter"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input class="form-control" name="twitterlink" type="text" value=""/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="la la-linkedin"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input class="form-control" name="linkedinlink" type="text" value=""/>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            {{-- Step 3 --}}
                                                            <div class="my-5 step" data-wizard-type="step-content">
                                                                <div id="sessionData">
                                                                    <h5 class="mb-10 font-weight-bold text-dark" style="text-align: center"> Review your Details and Submit</h5>
                                                                    @if (session()->has('sessionData'))
                                                                    <h6 class="font-weight-bolder mb-3"><mark>{{__('Email address:')}}</mark></h6>
                                                                    <div class="text-dark-50 line-height-lg">
                                                                        <div><strong>{{__('Email:')}}</strong> {{session()->get("sessionData")['email']}}</div>
                                                                    </div>
                                                                    <div class="separator separator-dashed my-5"></div>
                                                                    <h6 class="font-weight-bolder mb-3"><mark>{{__('Company Information:')}}</mark> </h6>
                                                                    <div class="text-dark-50 line-height-lg">
                                                                        <div><strong>{{__('Name:')}} </strong> {{session()->get("sessionData")['name']}}</div>
                                                                        <div><strong>{{__('Phone:')}} </strong>   {{session()->get("sessionData")['phoneNo']}}</div>
                                                                        <div><strong>{{__('Phone 2:')}} </strong> {{session()->get("sessionData")['phoneNo2']}}</div>
                                                                        <div><strong>{{__('Phone 3:')}} </strong>  {{session()->get("sessionData")['companyPhoneNo']}}</div>
                                                                        <div><strong>{{__('Website:')}} </strong>  {{session()->get("sessionData")['companyWebAddress']}}</div>
                                                                        <div><strong>{{__('About:')}} </strong> About: {{session()->get("sessionData")['aboutus']}}</div>
                                                                        <div><strong>{{__('Country:')}} </strong>  {{session()->get("sessionData")['country_name']}}</div>
                                                                        <div><strong>{{__('Business Categories:')}} </strong> @foreach(session()->get("sessionData")['category'] as $item) {{$item->category}} @if (!$loop->last) {{','}} @endif @endforeach</div>
                                                                        <div><strong>{{__('Instagram link:')}} </strong>  {{session()->get("sessionData")['instagramlink']}}</div>
                                                                        <div><strong>{{__('Twitter link:')}} </strong>  {{session()->get("sessionData")['twitterlink']}}</div>
                                                                        <div><strong>{{__('Linkedin link:')}} </strong>  {{session()->get("sessionData")['linkedinlink']}}</div>
                                                                    </div>
                                                                        @endif
                                                                </div>
                                                            </div>

                                                            <div class="d-flex justify-content-between border-top pt-10 mt-15">
                                                                <div class="mr-2">
                                                                    <button type="button" style="background-color: rgba(204, 73, 74, 0.2);border:none;color:rgb(204, 73, 74)" id="prev-step" class="btn btn-light-primary font-weight-bolder px-9 py-4" data-wizard-type="action-prev">{{__('Previous')}}</button>
                                                                </div>
                                                                <div>
                                                                    <button type="submit" style="background-color: rgb(204, 73, 74);border:none" class="btn btn-success font-weight-bolder px-9 py-4" data-wizard-type="action-submit">{{__('Submit')}}</button>
                                                                    <button type="button" style="background-color: rgb(204, 73, 74);border:none" id="next-step" class="btn btn-primary font-weight-bolder px-9 py-4" data-wizard-type="action-next">{{__('Next')}}</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var route="{{route('employerRegister')}}";
        var employerCompanyCheckRoute="{{route('employerCompanyCheck')}}";
        var employerData="{{route('employerData')}}";
    </script>
    <script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
    <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
    <script src="{{asset('/public/employer/dist/assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('/public/employer/dist/assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
    <script src="{{asset('/public/employer/dist/assets/js/scripts.bundle.js')}}"></script>
    <script src="{{asset('/public/employer/dist/assets/js/pages/custom/profile/profile.js')}}"></script>
    <script src="{{asset('/public/employer/dist/assets/js/pages/custom/user/add-user.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.0/flatpickr.min.js"></script>

    <script>
        $('#profile_avatar').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#image1').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
            $('#profile_avatar').val(this.files[0]);
        });
    </script>

    @if(Session::has('error'))
        <script>
            toastr.options.positionClass = 'toast-top-center';
            toastr.error('{{  Session::get('error') }}')
        </script>
    @endif
</body>
</html>
