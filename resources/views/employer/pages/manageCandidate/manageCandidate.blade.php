@extends('employer.layouts.master')

@section('title')
    Manage Candidates
@endsection

@section('css')
@endsection

@section('main-content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{__('Manage Jobs')}}</h5>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label"> {{__('List of Candidates')}}
                                <span class="d-block text-muted pt-2 font-size-sm"></span></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-separate table-head-custom table-checkable" id="myCustomTableCandidate">
                            <thead>
                            <tr>
                                <th style="text-align: center">{{__(' Name')}}</th>
                                <th style="text-align: center"> {{__('Current location')}}</th>
                                <th style="text-align: center"> {{__('Degree')}}</th>
                                <th  style="text-align: center" class="action">{{__('Last Company')}}</th>
                                <th  style="text-align: center" class="action">{{__('Nationality')}}</th>
                                <th  style="text-align: center" class="action">{{__('Age')}}</th>
                                <th  style="text-align: center" class="action">{{__('Years of experience')}}</th>
                                <th  style="text-align: center" class="action">{{__('University')}}</th>
                                <th  style="text-align: center; width: 120px" class="action">{{__('Status')}}</th>
                                <th  style="text-align: center" class="action">{{__('Email application')}}</th>
                                <th  style="text-align: center" class="action">{{__('Note Pop up')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php use Carbon\Carbon; use Illuminate\Support\Facades\DB; @endphp
                            @foreach($candidate_jobs as $candidate_job)
                                @php
                                    $applicant  = DB::table('users')->where('id', $candidate_job->user_id)->first();
                                    $applicant_personal  = DB::table('candidate_personal_informations')->where('user_id', $candidate_job->user_id)->first();
                                    $applicant_nationality  = DB::table('nationalities')->where('id', $applicant_personal->nationality)->first();
                                    $applicant_about_us  = DB::table('candidate_abouts')->where('user_id', $candidate_job->user_id)->first();
                                    $current_location = DB::table('countries')->where('id', $applicant_about_us->location)->first();
                                    $applicant_education  = DB::table('candidate_educations')->where('user_id', $candidate_job->user_id)->first();
                                    $experiences = DB::table('candidate_experiences')
                                    ->where('user_id', $candidate_job->user_id)
                                    ->get();

                                    $total = 0;

                                    if(count($experiences)>0){
                                        foreach ($experiences as $key=>$value)
                                        {
                                            $datetime1 = Carbon::createFromDate($value->experience_starting_date);
                                            $datetime2 = Carbon::createFromDate($value->experience_ending_date);
                                            $intervals[] = $datetime1->diffInDays($datetime2);
                                        }

                                        foreach ($intervals as $key => $value)
                                        {
                                            $total += $value;
                                        }
                                    }

                                    $candidateDegree = DB::table('candidate_educations')
                                    ->where('user_id', $candidate_job->user_id)
                                    ->max('degree');

                                    $degree = DB::table('job_qualifications')->where('id', $applicant_about_us->qualification)->first();
                                @endphp
                                <tr>
                                    <td style="text-align: center">
                                       <a href="{{route('candidateCV', encrypt($applicant->id))}}">{{$applicant->name}}</a>
                                    </td>
                                    <td style="text-align: center">
                                        {{(session()->has('language')) ? $current_location->name_ar : $current_location->name}}
                                    </td>
                                    <td style="text-align: center">
                                        @if(isset($degree)) {{(session()->has('language')) ? $degree->name_ar : $degree->name}} @endif
                                    </td>
                                    <td style="text-align: center">
                                        N/A
                                    </td>
                                    <td style="text-align: center">
                                        {{(session()->has('language')) ? $applicant_nationality->name_ar : $applicant_nationality->name}}
                                    </td>
                                    <td style="text-align: center">
                                        {{$applicant_personal->age}}
                                    </td>
                                    <td style="text-align: center">
                                        @if($total <= 0)
                                            0 Year
                                        @elseif($total <= 365)
                                            Less than one year
                                        @elseif($total > 365 && $total <= 730)
                                            1 Year
                                        @elseif($total > 730 && $total <= 1095)
                                            2 Years
                                        @elseif($total > 1095 && $total <= 1460)
                                            3 Years
                                        @elseif($total > 1460 && $total <= 1825)
                                            4 Years
                                        @elseif($total > 1825)
                                            5+ Years
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if(isset($applicant_education)) {{$applicant_education->institution}} @endif
                                    </td>
                                    <td style="text-align: center; width: 120px">
                                        <select class="form-control" id="status" data-class="{{$candidate_job->job_id}}" data-id="{{$candidate_job->user_id}}">
                                            <option value="" disabled selected>-- Status --</option>
                                            <option @if ($candidate_job->application_status == 'Shortlisted') selected @endif  value="Shortlisted">{{__('Shortlisted')}}</option>
                                            <option @if ($candidate_job->application_status == 'Interview') selected @endif value="Interview">{{__('Interview')}}</option>
                                            <option @if ($candidate_job->application_status == 'Hired') selected @endif value="Hired">{{__('Hired')}}</option>
                                            <option @if ($candidate_job->application_status == 'Rejected') selected @endif value="Rejected">{{__('Rejected')}}</option>
                                            <option @if ($candidate_job->application_status == 'Not Interested') selected @endif value="Not Interested">{{__('Not Interested')}}</option>
                                        </select>
                                    </td>
                                    <td style="text-align: center">
                                        <a  href="mailto:{{$applicant->email}}">{{__('Email')}}</a>
                                    </td>
                                    <td style="text-align: center">
                                        <a onclick="popUp('{{$candidate_job->id}}','{{$candidate_job->note}}')" style="cursor: pointer;color:blue">{{__('Pop up')}}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="popUpModal" tabindex="-1" role="dialog" aria-labelledby="popUpModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('employerUpdateNoteCandidate')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="popUpModalLabel">Note</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" value="" id="popUpRowId" name="popUpRowId">
                        <textarea rows="4" name="popUpRowNote" id="popUpRowNote" style="width: 100%"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#status').on('change', function ()
        {
            let job_id = $(this).data('class');
            let candidate_id = $(this).data('id');
            let status = $(this).val();
            $.ajax({
                method: "POST",
                url: "{{route('jobFeedback')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    'job_id': job_id,
                    'status_id': status,
                    'candidate_id': candidate_id,
                },
                success: function (response) {
                    if (response.status === 1) {
                        swal("Successfully Updated", {
                            icon: "success",
                        });
                    } else {
                        swal("Error While Updating", {
                            icon: "error",
                        });
                    }
                }
            });
        });

        function popUp(id, note){
            $('#popUpRowId').val(id);
            $('#popUpRowNote').val(note);
            $('#popUpModal').modal();
        }
    </script>
@endsection