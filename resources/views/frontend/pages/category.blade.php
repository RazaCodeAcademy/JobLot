@extends('frontend.layouts.master')
@section('content')
	<!-- header -->
    <header class="header category">
        <div class="category-breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Categories</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->category }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="header-wrapper">
            <div class="container">
                <div class="header-content">
                    <div class="header-description category-description">
                        <div class="">
                            <h1>{{  $category->category }}</h1>
                            <p>{{ count($jobs) }} jobs found</p>
                        </div>
                        <div class="">
                            <img src="{{ asset('/public/frontend/img/icons/cash-icon.svg')}}" alt="icon" />
                        </div>
                    </div>
                    <div class="header-search">
                        <form class="header-filter-box">
                            <img src="{{ asset('/public/frontend/img/icons/search-icon.svg')}}" alt="icon" />
                            <input type="text" name="search" id="search-jobs" autocomplete="off" placeholder="Search for jobs" onkeyup="search_jobs(this.value)" />
                            <img src="{{ asset('/public/frontend/img/icons/filter-icon.svg')}}" alt="icon" />
                            <span>Filter</span>
                        </form>
                        <div class="header-search-dropdown">
                            <div class="pill-box">
                                <p>Trending filters</p>
                                <div class="pill-row">
                                    @foreach ( $trends as $trend )
                                        <a href="javascript:void(0)" onclick="fetch_jobs('{{ $trend->title }}')" class="button button--pill">{{ $trend->title }}</a>
                                    @endforeach
                                   
                                </div>
                            </div>
                            <section class="recent">
                                <div class="container">
                                    <h5>Recently added</h5>

                                    <div class="recent-content">
                                        <div class="row" id="display-search-jobs"></div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
     <div class="overlay">
    </div>

    <main class="shadow">
        <!-- recent -->
        <section class="recent">
            <div class="container">
                <h5>Jobs by Category</h5>

                <div class="recent-content">
                    <div class="row">
                        {{-- @dd($jobs) --}}
                        @foreach($jobs as $job)
                        
                            <div class="col-lg-4">
                                <div class="recent-box">
                                    <div class="recent-img">
                                       <img src="{{ $job->user->get_image() }}" alt="" /> 
                                    </div>
                                    <div class="recent-description">
                                        <div class="recent-header">
                                          <a href="{{ route('jobDetails',$job->slug) }}"><h4>{{ $job->title ? $job->title :'N/A'}}</h4></a> 
                                          <a href="javascript:void(0)" onclick="savejob('{{ $job->id }}')"><i class="fas fa-star {{ user()->isSavedJob($job->id) ? 'icon-color' : ''  }}" id="save-job-{{ $job->id }}"></i></a>
                                        </div>
                                        <div class="recent-main">
                                            <p>{{ $job->user->first_name }} {{ $job->user->last_name  }}</p>
                                            <p>{{$job->user->street_address ? $job->user->street_address :'N/A'  }}</p>
                                        </div>
                                        <div class="recent-footer" style="column-gap:1rem; align-items:flex-start;">
                                            <i class="far fa-clock" style="font-size:1.9rem;"></i>
                                            <p style="font-size: 1.3rem;">From {{ \Carbon\Carbon::parse($job->user->job_schedual_from)->format('h:i A') }} - {{ \Carbon\Carbon::parse($job->user->job_schedual_to)->format('g:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
<script>

    const get_image = (image) => {
        console.log(image);
        var myImage = "{{ asset('storage/app/showImage') }}";
        return myImage.replace('showImage', image)
    }
    // const getDate = () => {
    // return moment().format("D MMM YYYY");;
    // };

    var timer;
    function search_jobs(query = ''){
        clearTimeout(timer);
        timer = setTimeout(function() {
            fetch_jobs(query)
        }, 500);
    }

    function fetch_jobs(query = '')
    {
        if(query.length > 3) {
            $.ajax({
                url:"{{ route('category-job-search') }}",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:(res) => {
                    if(res.success == true){
                        searched_jobs(res.jobs);
                        ele(`jobs-heading`).innerText = `Search result : ${query}`
                    }else{
                        toastr.error(`there is no jobs against ${query}`)
                    }
                }
            });
        }
    }
   
   function searched_jobs(jobs){
        var html = '';
        jobs.forEach((job) => {
            html += `
                <div class="col-lg-6">
                <div class="recent-box">
                    <div class="recent-img">
                        <img src="${get_image(job.user.profile_image)}" alt="" />
                    </div>
                    <div class="recent-description">
                        <div class="recent-header">
                            <h4>${job.title}</h4>
                            <a href="javascript:void(0)" onclick="savejob('{{ $job->id }}')"><i class="fas fa-star {{ user()->isSavedJob($job->id) ? 'icon-color' : ''  }}" id="save-job-{{ $job->id }}"></i></a>
                        </div>
                        <div class="recent-main">
                            <p>${job.user.first_name} ${job.user.last_name}</p>
                            <span>${job.user.street_address}</span>
                        </div>
                        <div class="recent-footer" style="column-gap:1rem; align-items:flex-start;">
                        <i class="far fa-clock"></i>
                      <p style="font-size: 1.2rem;">From ${moment(job.user.job_schedual_from).format('LT')} - ${moment(job.user.job_schedual_to).format('LT')}</p>
                        </div>
                    </div>
                </div>
            </div>
                      `
        });

        ele(`display-search-jobs`).innerHTML = html;
    }
</script>
@endsection