<!doctype html>
<html lang="en">
    @include('frontend.layouts.head')
    <body>
        @yield('main-content')

        @include('frontend.layouts.login_modal')

        @include('frontend.layouts.footer')
        @include('frontend.layouts.scripts')
    </body>
</html>