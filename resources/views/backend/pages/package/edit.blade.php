@extends('backend.layouts.master')

@section('title')
    Create Package
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <h5 class="text-dark font-weight-bold my-1 mr-5">{{__('Packages')}}</h5>
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{route('createPackage')}}" class="text-muted">{{__('Create Package')}}</a>
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
                        <h3 class="card-title">{{__('Create Package')}}</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{route('listPackages')}}" class="btn btn-primary font-weight-bolder"><i class="la la-eye"></i>{{__('View Packages')}}</a>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{route('updatePackage', $packages->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>{{__('Name')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"  placeholder="Enter Name" name="package_name" value="{{$packages->package_name}}" required />
                                        @error('package_name')
                                        <span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        @php $oldCountries = explode(',', $packages->countries);   @endphp
                                        <label>{{__('Country')}} <span class="text-danger">*</span></label>
                                        <select name="countries[]" class="form-control js-example-basic-multiple" multiple="multiple" required>
                                            @foreach($countries as $country)
                                                <option @foreach($oldCountries as $key => $value){{$value == $country->id ? 'selected': ''}} @endforeach value='{{$country->id}}'>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('countries')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>{{__('Description')}}<span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="package_description" placeholder="Enter a description" rows="3" required>{{$packages->package_description}}</textarea>
                                        <span class="form-text text-muted">{{__('Please enter a description within text length range 50 and 100.')}}</span>
                                    </div>
                                    @error('package_description')
                                    <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>{{__('Currency')}} <span class="text-danger">*</span></label>
                                        <select name="currency" class="form-control" required>
                                            <option selected disabled value="">Select</option>
                                            @foreach($package_currencys as $package_currencys)
                                                <option @if($packages->currency == $package_currencys->id) selected @endif value='{{$package_currencys->id}}'>{{$package_currencys->currency_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('currency')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>{{__('Rate')}} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control"  placeholder="Enter Monthly Rate" name="rate" min="0" value="{{$packages->rate}}" required />
                                        @error('rate')
                                        <span class="invalid-feedback" role="alert">
												{{ $message }}
										</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>{{__('Job limit')}} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control"  placeholder="Enter Yearly Rate" name="job_limit" min="1" value="{{$packages->job_limit}}" required />
                                        @error('job_limit')
                                        <span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>{{__('CV limit')}} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control"  placeholder="Enter Yearly Rate" name="cv_limit" min="1" value="{{$packages->cv_limit}}" required />
                                        @error('cv_limit')
                                        <span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
                                        @enderror
                                    </div>
                                </div>

                                @php $packageFeatures = DB::table('package_feature_lists')->where('package_details_id', $packages->package_details_id)->get(); @endphp

                                @if(count($packageFeatures) > 0)
                                    <div class="col-6">
                                        <div class="form-group">
                                                <div id="kt_repeater_1">
                                                    <label>{{__('Features')}} <span class="text-danger">*</span></label>
                                                        <div data-repeater-list="package_feactures">
                                                            @foreach ($packageFeatures as $item)
                                                                <div data-repeater-item="" class="form-group row align-items-center">
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="feature_name" class="form-control" placeholder="Enter " value="{{$item->feature_name}}" required/>
                                                                        @error('feature_name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            {{ $message }}
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                                                                            <i class="la la-trash-o"></i>{{__('Delete')}}</a>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-md-2 col-form-label text-right"></label>
                                                            <div class="col-lg-5">
                                                                <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                                                                    <i class="la la-plus"></i>{{__('Add More Features')}}</a>
                                                            </div>
                                                        </div>
                                                </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div id="kt_repeater_1">
                                                <label>Features <span class="text-danger">*</span></label>
                                                <div data-repeater-list="package_feactures">
                                                    <div data-repeater-item="" class="form-group row align-items-center">
                                                        <div class="col-md-8">
                                                            <input type="text" name="feature_name" class="form-control" placeholder="Enter" required/>
                                                            {{--                                                        <div class="d-md-none mb-2"></div>--}}
                                                            @error('feature_name')
                                                            <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                                                                <i class="la la-trash-o"></i>Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-form-label text-right"></label>
                                                    <div class="col-lg-5">
                                                        <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                                                            <i class="la la-plus"></i>Add More Features</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

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
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });

        var KTFormRepeater = function() {

            // Private functions
            var demo1 = function() {
                $('#kt_repeater_1').repeater({
                    initEmpty: false,

                    defaultValues: {
                        'text-input': 'foo'
                    },

                    show: function () {
                        $(this).slideDown();
                    },

                    hide: function (deleteElement) {
                        if (confirm('Are you sure you want to delete this?')) {
                            $(this).slideUp(deleteElement);
                        }
                    },
                    isFirstItemUndeletable: true
                });
            };

            return {
                // public functions
                init: function() {
                    demo1();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTFormRepeater.init();
        });
    </script>
@endsection
