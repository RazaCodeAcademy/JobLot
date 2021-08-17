<script src="{{asset('/public/asset/js/jquery.min.js')}}"></script>
<script src="{{asset('/public/asset/js/popper.min.js')}}"></script>
<script src="{{asset('/public/asset/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/public/asset/js/feather.min.js')}}"></script>
<script src="{{asset('/public/asset/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('/public/asset/js/jquery.nstSlider.min.js')}}"></script>
<script src="{{asset('/public/asset/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('/public/asset/js/visible.js')}}"></script>
<script src="{{asset('/public/asset/js/jquery.countTo.js')}}"></script>
<script src="{{asset('/public/asset/js/chart.js')}}"></script>
<script src="{{asset('/public/asset/js/plyr.js')}}"></script>
<script src="{{asset('/public/asset/js/tinymce.min.js')}}"></script>
<script src="{{asset('/public/asset/js/slick.min.js')}}"></script>
<script src="{{asset('/public/asset/js/jquery.ajaxchimp.min.js')}}"></script>

<script src="{{asset('/public/js/custom.js')}}"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC87gjXWLqrHuLKR0CTV5jNLdP4pEHMhmg"></script>
<script src="{{asset('/public/js/map.js')}}"></script>


<script src="{{asset('/public/dashboard/js/dashboard.js')}}"></script>
<script src="{{asset('/public/dashboard/js/datePicker.js')}}"></script>
<script src="{{asset('/public/dashboard/js/upload-input.js')}}"></script>

<script src="{{asset('/public/public/toast/toastr.js')}}"></script>
<script src="{{asset('/public/public/toast/toastr.min.js')}}"></script>

@if(Session::has('error'))
    <script>
        toastr.options.positionClass = 'toast-top-center';
        toastr.error('{{  Session::get('error') }}')
    </script>
@endif

@yield('script')
