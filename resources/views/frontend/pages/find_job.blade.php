@extends('frontend.layouts.master')
@section('content')
<main class="main-head">
    <div class="container-fluid">
        <div class="main-head-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Find a job</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{  $job->title  }}</li>
                </ol>
            </nav>

            <div class="main-head-icons">
                    <a href="javascript:void(0)" onclick="savejob('{{ $job->id }}')"><i class="fas fa-star {{ user()->isSavedJob($job->id) ? 'icon-color' : ''  }}" id="save-job-{{ $job->id }}"></i></a>
                    <a data-toggle="modal" data-target="#exampleModal" href="#"><i class="far fa-share-square"></i></a>
            </div>
        </div>

        <div class="main-head-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="main-head-desc">
                            <div class="head-desc-row">
                                <img src={{ $job->user->get_image() }} alt="image" />
                                <div class="head-desc">
                                    <h3>{{  $job->title  }}</h3>
                                    <span>updated {{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}</span>
                                </div>
                                <div class="head-desc-cta">
                                    {{-- <button class="button-secondary"  onclick="deleteFunction('{{$job->id}}')">Dismiss</button> --}}
                                    <button class="{{ user()->isAppliedJob($job->id) ? 'button-success' : 'button-main' }}" id="apply-job-{{ $job->id }}" onclick="apply_job('{{ $job->id }}')">{{ user()->isAppliedJob($job->id) ? 'Applied' : 'Apply' }}</button>
                                </div>
                            </div>
                            <div class="head-location">
                                <div class="head-location-row">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div class="">
                                        <h4>{{$job->user->street_address ? $job->user->street_address :'N/A'  }}</h4>
                                        {{-- <p>Alsalmia, Kuwait city, Kuwait</p> --}}
                                    </div>
                                </div>
                                <div class="head-location-row">
                                    <i class="far fa-clock"></i>
                                    <div class="">
                                        <p>From {{ \Carbon\Carbon::parse($job->user->job_schedual_from)->format('h:i A') }} - {{ \Carbon\Carbon::parse($job->user->job_schedual_to)->format('g:i A') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="head-content">
                                <h4>{{__('Job Description')}}</h4>
                                <p>
                                    <br />
                                    {!! htmlspecialchars_decode($job->description) !!} <br />
                                </p>
                            </div>
                            {{-- <div class="head-content">
                                <h4>Requirements</h4>
                                <p>
                                    <div class="edication-and-experience details-section">
                                        <h4><i data-feather="book"></i>1:{{__('Education')}}</h4>
                                        <ul>
                                            <h3> {!! htmlspecialchars_decode($job->get_qualification()) !!} </h3>
                                        </ul>
                                    </div>
                                    <h4><i data-feather="book"></i>2:{{__('Salary')}}</h4>
                                     {{($job->salary)}} <br />
                                </p>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="main-head-map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1781287.9077480363!2d46.414478775959395!3d29.30938918651801!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fc5363fbeea51a1%3A0x74726bcd92d8edd2!2sKuwait!5e0!3m2!1sen!2s!4v1608982153470!5m2!1sen!2s"
                                allowfullscreen=""
                                aria-hidden="false"
                                tabindex="0"
                            ></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

    {{-- modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Share Job</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <ul class="d-flex justify-content-center align-items-center gap-5">
                    <li class="flex-grow-1 text-center">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{route('jobDetails', $job->slug)}}" target="_blank"></i>
                            <i class='bx bxl-facebook-circle socail-icon'></i>
                        </a>
                    </li>
                    <li class="flex-grow-1 text-center">
                        <a href="whatsapp://send?text={{route('jobDetails', $job->slug)}}" target="_blank" data-action="share/whatsapp/share">
                            <i class='bx bxl-whatsapp socail-icon text-success'></i>
                        </a>
                    </li>
                    <li class="flex-grow-1 text-center">
                        <a href="https://twitter.com/intent/tweet?url={{route('jobDetails', $job->slug)}}" target="_blank">
                            <i class='bx bxl-twitter socail-icon'></i>
                        </a>
                    </li>
                </ul>
               
            </div>
            {{-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
          </div>
        </div>
      </div>
      
@endsection

@section('scripts')
@endsection