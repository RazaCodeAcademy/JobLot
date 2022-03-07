<nav class="main-nav">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('/public/frontend/img/logo-color.png')}}" alt="" />
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="ml-auto navbar-nav">
                {{-- <li class="nav-item">
                    <a class="button button--find" href="">
                        <img src="{{ asset('/public/frontend/img/icons/find.svg')}}" alt="" />
                        Find a job</a
                    >
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Daily matches</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Favorite jobs</a>
                </li> --}}
                <li class="nav-item">
                    <div class="nav-profile-box">
                        <div class="nav-avatar">
                            <img style="width: 50px;height:50px; border-radius: 50%;" src="{{  user()->get_image() }}" alt="" />
                        </div>
                        <div class="nav-tooltip-box">
                            <div class="tooltip-tip"></div>
                            <div class="nav-tooltip-content">
                                <div class="tooltip-header">
                                    <div class="tooltip-desc">
                                        <h2>{{Auth::user()->first_name}}</h2>
                                        {{-- <p>Graphic desinger</p> --}}
                                        <a href="{{ route('update-employee-details-page') }}">Manage your profile</a>
                                    </div>
                                    <div class="tooltip-avatar">
                                        <img src="{{  user()->get_image() }}" alt="" />
                                    </div>
                                </div>
                                <div class="tooltip-main">
                                    <ul>
                                        <li>
                                            <a href="{{ route('saved-job') }}">
                                                <img src="{{ asset('/public/frontend/img/icons/saved-jobs.svg')}}" alt="icon" />
                                                <span>Saved jobs</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('notifications') }}">
                                                <img src="{{ asset('/public/frontend/img/icons/notification.svg')}}" alt="icon" />
                                                <span>Notifications</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('settings') }}">
                                                <img src="{{ asset('/public/frontend/img/icons/settings.svg')}}" alt="icon" />
                                                <span>Settings</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}">
                                                <img src="{{ asset('/public/frontend/img/icons/sign-out.svg')}}" alt="icon" />
                                                <span>Sign out</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</nav>