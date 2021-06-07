<!DOCTYPE html>
<html lang="en">
    <head>

		@include('admin.layouts.head')

    </head>
    <body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar"data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
        @include('admin.layouts.header')

        @include('admin.layouts.sidebar')

        @yield('content')

        @include('admin.layouts.footer')

        @include('admin.layouts.scripts')
    </body>
</html>