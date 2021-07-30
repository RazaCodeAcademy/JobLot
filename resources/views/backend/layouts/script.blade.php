<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop">
    <span class="svg-icon">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24" />
                <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
            </g>
        </svg>
    </span>
</div>

<script>
    var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
</script>

<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{asset('public/backend/dist/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('public/backend/dist/assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
<script src="{{asset('public/backend/dist/assets/js/scripts.bundle.js')}}"></script>

<!--begin::Page Vendors(used by this page)-->
<script src="{{asset('public/backend/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>

<!--begin::Page Scripts(used by this page)-->
<script src="{{asset('public/backend/dist/assets/js/pages/widgets.js')}}"></script>
<script src="{{asset('public/backend/dist/assets/js/pages/custom/profile/profile.js')}}"></script>

<script src="{{asset('public/toast/toastr.js')}}"></script>
<script src="{{asset('public/toast/toastr.min.js')}}"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset('public/backend/dist/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(document).ready( function () {
        $('#myCustomTable').DataTable({
            "scrollX": true,
            pageLength: 25
        });
    });

    $(".datepickerk").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: 0,
    });

    $(".disableKey").keypress(function (e) {
        return false;
    });
    $(".disableKey").keydown(function (e) {
            return false;
    });
</script>

@yield('script')

@if(Session::has('success'))
    <script>
        toastr.options.positionClass = 'toast-top-right';
        toastr.success('{{  Session::get('success') }}')
    </script>
@endif

@if(Session::has('error'))
    <script>
        toastr.options.positionClass = 'toast-top-right';
        toastr.error('{{  Session::get('error') }}')
    </script>
@endif
