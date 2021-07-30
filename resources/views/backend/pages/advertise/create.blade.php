@extends('backend.layouts.master')

@section('title')
    Path | Create Advertise
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        @php $user_role_id = DB::table('model_has_roles')->where('model_id', Auth::user()->id)->first();
             $user = DB::table('roles')->where('id', $user_role_id->role_id)->first();
        @endphp

        <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Advertise</h5>
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                @if ($user->id == 1)
                                    <a href="{{route('createAdvertise')}}" class="text-muted">Create Advertise</a>
                                @elseif($user->id  == 4)
                                    <a href="{{route('subAdminCreateAdvertise')}}" class="text-muted">Create Advertise</a>
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
                        <h3 class="card-title">Create Advertise</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                            <div class="card-toolbar">
                            @if ($user->id == 1)
                                <a href="{{route('listAdvertise')}}" class="btn btn-primary font-weight-bolder"><i class="la la-eye"></i> View Advertise</a>
                            @elseif($user->id  == 4)
                                    <a href="{{route('subAdminListAdvertise')}}" class="btn btn-primary font-weight-bolder"><i class="la la-eye"></i> View Advertise</a>
                            @endif
                            </div>
                        </div>
                    </div>

                    @if ($user->id == 1)
                            <form method="POST" action="{{route('storeAdvertise')}}" enctype="multipart/form-data">
                    @elseif($user->id  == 4)
                            <form method="POST" action="{{route('subAdminStoreAdvertise')}}" enctype="multipart/form-data">
                    @endif
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"  placeholder="Enter Title" name="title" value="{{old('title')}}" required/>
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
                                        @enderror
                                    </div>
                                </div>

                                @if($user->id == 1)
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Country <span class="text-danger">*</span></label>
                                        <select name="countries[]" class="form-control js-example-basic-multiple" multiple="multiple" required>
                                            @foreach($countries as $country)
                                                <option {{ (collect(old('countries'))->contains($country->id)) ? 'selected':'' }} value='{{$country->id}}'>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('countries')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                @endif

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Employer <span class="text-danger">*</span></label>
                                        <select name="employer" class="form-control" required>
                                            <option selected disabled value="">Select</option>
                                            @foreach($employers as $employer)
                                                @php $user = DB::table('users')->where('id',$employer->model_id)->first(); @endphp
                                                <option @if(old('employer') == $user->id) selected @endif value='{{$user->id}}'>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('employer')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Start Date <span class="text-danger">*</span></label>
                                        <input class="form-control datepickerk disableKey" type="text"  name="start_date" value="{{old('start_date')}}" required/>
                                        @error('start_date')
                                        <span class="invalid-feedback" role="alert">
												{{ $message }}
										</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>End Date <span class="text-danger">*</span></label>
                                        <input class="form-control datepickerk disableKey" type="text"  name="end_date" value="{{old('end_date')}}" required/>
                                        @error('end_date')
                                        <span class="invalid-feedback" role="alert">
												{{ $message }}
										</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label> Upload Files: <span class="text-danger">*</span></label>
                                        <input type="file" id="image" name="images[]" class="form-control" accept="image/*" multiple required>
                                    </div>
                                    <div class="form-group row col-md-12" id="preview_img">

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer" style="text-align: end">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
{{--    <script src="{{asset('public/backend/dist/assets/js/pages/crud/file-upload/dropzonejs.js')}}"></script>--}}
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        $('#image').on('change', function(){ //on file input change
            $("#preview_img").empty();
            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {
                var data = $(this)[0].files; //this file data
                $.each(data, function(index, file){ //loop though each file
                    if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                        var fRead = new FileReader(); //new filereader
                        fRead.onload = (function(file){ //trigger function on successful read
                            return function(e) {
                                var img = $('<img width="100px" height="100px"/>').addClass('thumb').attr('src', e.target.result); //create image element
                                $('#preview_img').append(img); //append image to output element
                            };
                        })(file);
                        fRead.readAsDataURL(file); //URL representing the file's data.
                    }
                });

            }else{
                alert("Your browser doesn't support File API!"); //if File API is absent
            }
        });
    </script>
@endsection
