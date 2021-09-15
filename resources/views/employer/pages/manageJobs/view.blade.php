@extends('employer.layouts.master')

@section('title')
    Job
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
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Job</h5>
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
                                    <h3 class="card-label font-weight-bolder text-dark">{{__('Job Details')}}</h3>
                                </div>
                                <div class="card-toolbar">
                                        <a href="{{route('manageJobs')}}" class="btn btn-primary font-weight-bolder"><i class="la la-eye"></i> {{__('View Jobs')}}</a>
                                </div>
                            </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Position/Title')}} in English <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"  placeholder="Enter" name="title" disabled value="{{$job->title}}" required/>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Position/Title')}} in Arabic <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control"  placeholder="Enter" name="title_ar" disabled value="{{$job->title_ar}}" required/>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                {{-- @php $jobSalary = DB::table('job_salary_ranges')->where('id', $job->salary)->first(); @endphp --}}
                                                <label>{{__('Salary Range')}}<span class="text-danger">*</span></label>
                                                {{-- <select name="salary" class="form-control" disabled required>
                                                        <option disabled selected>{{$jobSalary->range}}</option>
                                                </select> --}}
                                                <input type="text" class="form-control" name="salary" disabled value="{{$job->salary}}">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                @php $location = DB::table('countries')->where('id', $job->job_location)->first(); @endphp
                                                <label>{{__('Job location')}} <span class="text-danger">*</span></label>
                                                <select name="job_location" class="form-control" disabled required>
                                                        <option disabled selected>{{(session()->has('language')) ? $location->name_ar : $location->name}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                @php 
                                                    $nationality  = DB::table('nationalities')->where('id', $job->candidate_nationality)->first();
                                                @endphp

                                                <label>{{__('Candidate nationality')}} <span class="text-danger">*</span></label>
                                                <select name="candidate_nationality" class="form-control" disabled required>
                                                    @if(!empty($nationality)) <option disabled selected>{{(session()->has('language')) ? $nationality->name_ar : $nationality->name}}</option> @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                @php $jobQualification = DB::table('job_qualifications')->where('id', $job->qualification)->first(); @endphp
                                                <label>{{__('Degree Level')}} <span class="text-danger">*</span></label>
                                                <select name="qualification" class="form-control" disabled required>
                                                        <option disabled selected>{{(session()->has('language')) ? $jobQualification->name_ar : $jobQualification->name}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                @php $jobExperience = DB::table('job_experiences')->where('id', $job->experience)->first(); @endphp
                                                <label>{{__('Experience')}}<span class="text-danger">*</span></label>
                                                <select name="experience" class="form-control" disabled="disabled" required>
                                                            <option disabled selected>{{$jobExperience->year}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                @php $career = DB::table('job_career_levels')->where('id', $job->career_level)->first(); @endphp
                                                <label>{{__('Career Level')}}<span class="text-danger">*</span></label>
                                                <select disabled name="career_level" class="form-control" required>
                                                        <option disabled selected>{{(session()->has('language')) ? $career->name_ar : $career->name}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Job Type')}} <span class="text-danger">*</span></label>
                                                <select name="type" class="form-control" required disabled>
                                                    @foreach($jobTypes as $jobType)
                                                        <option {{ ($job->type == $jobType->id) ? 'selected':'' }} value='{{$jobType->id}}'>{{(session()->has('language')) ? $jobType->name_ar : $jobType->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                @php
                                                    $jobSkills = explode(',' , $job->skills);
                                                @endphp
                                                <label>{{__('Skills')}}<span class="text-danger">*</span></label>
                                                <select name="skills[]" class="form-control js-example-basic-multiple" multiple="multiple" disabled required>
                                                    @foreach ($skills as $skill)
                                                        <option disabled @foreach($jobSkills as $key => $value){{$value == $skill->id ? 'selected': ''}} @endforeach>{{(session()->has('language')) ? $skill->name_ar : $skill->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Gender')}}<span class="text-danger">*</span></label>
                                                <select name="gender" class="form-control" disabled required>
                                                    <option disabled selected>{{$job->gender}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                @php $jobCandidateLocation = DB::table('job_candidate_locations')->where('id', $job->candidate_location)->first(); @endphp
                                                <label>{{__('Candidate Location')}}<span class="text-danger">*</span></label>
                                                <select name="candidate_location" class="form-control" disabled required>
                                                    @if(!empty($jobCandidateLocation)) <option disabled="disabled" selected>{{(session()->has('language')) ? $jobCandidateLocation->location_ar : $jobCandidateLocation->location}}</option> @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                @php $jobCategory = DB::table('employee_bussiness_categories')->where('id', $job->category)->first(); @endphp
                                                <label>{{__('Field/industry')}}<span class="text-danger">*</span></label>
                                                <select name="category" class="form-control" disabled required>
                                                        <option disabled selected>{{(session()->has('language')) ? $jobCategory->category_ar : $jobCategory->category}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Posting Date')}}<span class="text-danger">*</span></label>
                                                <input class="form-control datepickerk" readonly type="text" name="date" value="{{$job->date}}" disabled min="<?php echo date('Y-m-d') ?>"  required/>
                                            </div>
                                        </div>

                                        {{-- <div class="col-6">
                                            <div class="form-group">
                                                <label>{{__('Ending Date')}}<span class="text-danger">*</span></label>
                                                <input class="form-control datepickerk" readonly type="text" name="endingDate" value="{{$job->endingDate}}" disabled min="<?php echo date('Y-m-d') ?>"  required/>
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
                                                    <span>{!! htmlspecialchars_decode($job->description) !!}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <!--begin::Card-->
                                            <div class="card card-custom">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                    {{__(' Responsibilities')}} <span class="text-danger">*</span>
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <span>{!! htmlspecialchars_decode($job->responsibilities) !!}</span>
                                                </div>
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
                                                    <span>{!! htmlspecialchars_decode($job->education) !!}</span>
                                                </div>
                                            </div>
                                            <!--end::Card-->
                                        </div>
                                    </div>

                                </div>
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
            KTCkeditor2.instances['description'].setReadOnly(true);


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
            KTCkeditor2.instances['responsibilities'].setReadOnly(true);

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
            KTCkeditor2.instances['education'].setReadOnly(true);

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

    </script>
@endsection
