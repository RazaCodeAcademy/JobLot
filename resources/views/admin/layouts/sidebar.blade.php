
  <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="menu-item">
            <a href="{{ route('admin.dashboard') }}">
                <i class="la la-home"></i>
                <span class="menu-title" data-i18n="nav.dash.main">Dashboard</span>
                {{-- <span class="badge badge badge-info badge-pill float-right mr-2">3</span> --}}
            </a>
        </li>
        <li class=" navigation-header">
          <span data-i18n="nav.category.layouts">Components</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip"
          data-placement="right" data-original-title="Layouts"></i>
        </li>
        <li class=" nav-item"><a href="#"><i class="la la-navicon"></i><span class="menu-title" data-i18n="nav.navbars.main">Navbars</span></a>
          <ul class="menu-content">
            <li>
                <a class="menu-item" href="navbar-light.html" data-i18n="nav.navbars.nav_light">Navbar Light</a>
            </li>
            <li>
                <a class="menu-item" href="navbar-dark.html" data-i18n="nav.navbars.nav_dark">Navbar Dark</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>