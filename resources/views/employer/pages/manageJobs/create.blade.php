@extends('employer.layouts.master')

@section('title')
    Path | New Job
@endsection

@section('css')
    <style>
        .ck-editor__editable_inline {
            max-height: 100px;
        }
    </style>
@endsection

@section('main-content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{__('Post a Job')}}</h5>
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
                                    <h3 class="card-label font-weight-bolder text-dark">{{__('Add Job Details')}}</h3>
                                </div>
                            </div>
                            <form method="POST" action="{{route('createJob')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Position/Title')}} in English <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"  placeholder="Enter English Title" name="title" value="{{old('title')}}" required/>
                                                @error('title')
                                                <span class="invalid-feedback" role="alert">
												        {{ $message }}
										    	</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Position/Title')}} in Arabic <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"  placeholder="Enter Arabic title" name="title_ar" value="{{old('title_ar')}}" required/>
                                                @error('title_ar')
                                                <span class="invalid-feedback" role="alert">
												        {{ $message }}
										    	</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Salary Range')}}<span class="text-danger">*</span>   (10-100)</label>
                                                {{-- <select name="salary" class="form-control" required>
                                                    <option disabled selected value="">{{__('Select')}}</option>
                                                    @foreach($salaries as $salary)
                                                        <option {{ (old('salary') == $salary->id) ? 'selected':'' }} value='{{$salary->id}}'>{{$salary->range}}</option>
                                                    @endforeach
                                                </select> --}}
                                                <input type="text" class="form-control" name="salary" value="{{old('salary')}}" required>
                                                @error('salary')
                                                    <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Job location')}} <span class="text-danger">*</span></label>
                                                <select name="job_location" class="form-control" required id="country_id" onchange="countryChange(event)">
                                                    <option disabled selected value="">{{__('Select')}}</option>
                                                    @foreach($countries as $country)
                                                        <option {{ (old('job_location') == $country->id) ? 'selected':'' }} value='{{$country->id}}'>{{(session()->has('language')) ? $country->name_ar : $country->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('job_location')
                                                <span class="invalid-feedback" role="alert">
                                                   {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6" style="display: none" id="cityDiv">
                                            <div class="form-group">
                                                <label>{{__('City')}} <span class="text-danger">*</span></label>
                                                <select name="city_id" class="form-control" id="city_id">
                                                </select>
                                                @error('city_id')
                                                    <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Candidate nationality')}}<span class="text-danger">*</span></label>
                                                <select name="candidate_nationality" class="form-control" required>
                                                    <option disabled selected value="">{{__('Select')}}</option>
                                                    @foreach($nationalities as $nationality)
                                                        <option {{ (old('candidate_nationality') == $nationality->id) ? 'selected':'' }} value='{{$nationality->id}}'>{{(session()->has('language')) ? $nationality->name_ar : $nationality->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('candidate_nationality')
                                                <span class="invalid-feedback" role="alert">
                                                   {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Degree Level')}} <span class="text-danger">*</span></label>
                                                <select name="qualification" class="form-control" required>
                                                    <option disabled selected value="">{{__('Select')}}</option>
                                                    @foreach($qualifications as $qualification)
                                                        <option {{ (old('qualification') == $qualification->id) ? 'selected':'' }} value='{{$qualification->id}}'>{{(session()->has('language')) ? $qualification->name_ar : $qualification->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('qualification')
                                                <span class="invalid-feedback" role="alert">
                                                   {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Career Level')}}<span class="text-danger">*</span></label>
                                                <select name="career_level" class="form-control" required>
                                                    <option disabled selected value="">{{__('Select')}}</option>
                                                    @foreach($careerLevels as $careerLevel)
                                                        <option {{ (old('career_level') == $careerLevel->id) ? 'selected':'' }} value='{{$careerLevel->id}}'>{{(session()->has('language')) ? $careerLevel->name_ar : $careerLevel->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('career_level')
                                                <span class="invalid-feedback" role="alert">
                                                   {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Experience')}}<span class="text-danger">*</span></label>
                                                <select name="experience" class="form-control" required>
                                                    <option disabled selected value="">{{__('Select')}}</option>
                                                    @foreach($experiences as $experience)
                                                        <option {{ (old('experience') == $experience->id) ? 'selected':'' }} value='{{$experience->id}}'>{{$experience->year}}</option>
                                                    @endforeach
                                                </select>
                                                @error('experience')
                                                <span class="invalid-feedback" role="alert">
                                                   {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Job Type')}} <span class="text-danger">*</span></label>
                                                <select name="type" class="form-control" required>
                                                    <option disabled selected value="">{{__('Select')}}</option>
                                                    @foreach($jobTypes as $jobType)
                                                        <option {{ (old('type') == $jobType->id) ? 'selected':'' }} value='{{$jobType->id}}'>{{(session()->has('language')) ? $jobType->name_ar : $jobType->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('type')
                                                    <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Skills')}}<span class="text-danger">*</span></label>
                                                <select name="skills[]" class="form-control js-example-basic-multiple" multiple="multiple" required>
                                                    @foreach($skills as $skill)
                                                        <option {{ (collect(old('skills'))->contains($skill->id)) ? 'selected':'' }} value='{{$skill->id}}'>{{(session()->has('language')) ? $skill->name_ar : $skill->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('skills')
                                                <span class="invalid-feedback" role="alert">
                                                   {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Gender')}} <span class="text-danger">*</span></label>
                                                <select name="gender" class="form-control" required>
                                                    <option disabled selected value="">{{__('Selec')}}t</option>
                                                    <option {{old('gender') == 'Male' ? 'selected' : ''}} value="Male">{{__('Male')}}</option>
                                                    <option {{old('gender') == 'Female' ? 'selected' : ''}} value="Female">{{__('Female')}}</option>
                                                    <option {{old('gender') == 'All' ? 'selected' : ''}} value="All">{{__('All')}}</option>
                                                </select>
                                                @error('gender')
                                                <span class="invalid-feedback" role="alert">
                                                   {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Candidate Location')}}<span class="text-danger">*</span></label>
                                                <select name="candidate_location" class="form-control" required>
                                                    <option disabled selected value="">{{__('Select')}}</option>
                                                    @foreach($candidateLocations as $candidateLocation)
                                                        <option {{ (old('candidate_location') == $candidateLocation->id) ? 'selected':'' }} value='{{$candidateLocation->id}}'>{{(session()->has('language')) ? $candidateLocation->location_ar : $candidateLocation->location}}</option>
                                                    @endforeach
                                                </select>
                                                @error('candidate_location')
                                                <span class="invalid-feedback" role="alert">
                                                   {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Field/industry')}}<span class="text-danger">*</span></label>
                                                <select name="category" class="form-control" required>
                                                    <option disabled selected value="">{{__('Select')}}</option>
                                                    @foreach($categories as $category)
                                                        <option {{ (old('category') == $category->id) ? 'selected':'' }} value='{{$category->id}}'>{{(session()->has('language')) ? $category->category_ar : $category->category}}</option>
                                                    @endforeach
                                                </select>
                                                @error('category')
                                                <span class="invalid-feedback" role="alert">
                                                   {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Posting Date')}} <span class="text-danger">*</span></label>
                                                <input class="form-control datepickerk disableKey" style="width: 100%" type="text" name="date" value="{{old('date')}}" required/>
                                                @error('date')
                                                <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Ending Date')}} <span class="text-danger">*</span></label>
                                                <input class="form-control datepickerk disableKey" style="width: 100%" type="text" name="endingDate" value="{{old('endingDate')}}" required/>
                                                @error('endingDate')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div> --}}

                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <!--begin::Card-->
                                            <div class="card card-custom">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                    {{__('Job Description')}} <span class="text-danger">*</span>
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <textarea name="description" id="kt-ckeditor-1">{{old('description')}}</textarea>
                                                </div>
                                                @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <!--begin::Card-->
                                            <div class="card card-custom">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                    {{__('Responsibilities')}} <span class="text-danger">*</span>
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <textarea name="responsibilities" id="kt-ckeditor-2">{{old('responsibilities')}}</textarea>
                                                </div>
                                                @error('responsibilities')
                                                <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <!--end::Card-->
                                        </div>

                                        <div class="col-6">
                                            <!--begin::Card-->
                                            <div class="card card-custom">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                    {{__('Education')}} <span class="text-danger">*</span>
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <textarea name="education" id="kt-ckeditor-3">{{old('education')}}</textarea>
                                                </div>
                                                @error('education')
                                                <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <!--end::Card-->
                                        </div>
                                    </div>


                                </div>
                                <div class="card-footer" style="text-align: end">
                                    <button type="submit" class="btn btn-primary mr-2">{{__('Submit')}}</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{asset("public/employer/dist/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js")}}"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });
        });

        var KTCkeditor = function () {
            // Private functions
            var demos = function () {
                ClassicEditor
                    .create( document.querySelector( '#kt-ckeditor-1' ),
                        {
                            toolbar: [ 'bold', 'underline','italic', 'bulletedList', 'numberedList', 'blockQuote']
                        } )
                    .then( editor => {
                        console.log( editor );
                    } )
                    .catch( error => {
                        console.error( error );
                    } );
            };

            return {
                // public functions
                init: function() {
                    demos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function() {
            KTCkeditor.init();
        });

        var KTCkeditor1 = function () {
            // Private functions
            var demos = function () {
                ClassicEditor
                    .create( document.querySelector( '#kt-ckeditor-2' ),
                        {
                            toolbar: [ 'bulletedList', 'numberedList']
                        } )
                    .then( editor => {
                        console.log( editor );
                    } )
                    .catch( error => {
                        console.error( error );
                    } );
            };

            return {
                // public functions
                init: function() {
                    demos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function() {
            KTCkeditor1.init();
        });

        var KTCkeditor2 = function () {
            // Private functions
            var demos = function () {
                ClassicEditor
                    .create( document.querySelector( '#kt-ckeditor-3' ),
                        {
                            toolbar: [ 'bulletedList', 'numberedList']
                        } )
                    .then( editor => {
                        console.log( editor );
                    } )
                    .catch( error => {
                        console.error( error );
                    } );
            };

            return {
                // public functions
                init: function() {
                    demos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function() {
            KTCkeditor2.init();
        });

        function countryChange(e){
            var countryId = e.target.value;

            $.ajax({
                method: "POST",
                url: "{{route('getcountryCities')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    'country_id': countryId
                },
                success: function (response) {
                    if(response.status == 1){
                        $('#cityDiv').css('display', 'block');
                        $('#city_id').html('');

                        var option = `<option disabled selected value="">{{__('Select City')}}</option>`;
                        $('#city_id').append(option);

                        response.cities.forEach(city => {
                            var option = `<option value="${city.id}">${city.name}</option>`;
                            $('#city_id').append(option);
                        });
                    }
                    else{
                        $('#cityDiv').css('display', 'none');
                        $('#city_id').html('');
                    }
                }
            });
        }

    </script>
@endsection
