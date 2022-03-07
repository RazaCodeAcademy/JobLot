<script src="{{ asset('/public/frontend/js/jquery.js') }}"></script>
<script src="{{ asset('/public/frontend/js/popper.js') }}"></script>
<script src="{{ asset('/public/frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/public/frontend/js/main.js') }}"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" 
 href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{!! session('success') !!}
<script>
    @if(Session::has('message'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.success("{{ session('message') }}");
    @endif
  
    @if(Session::has('error'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.error("{{ session('error') }}");
    @endif
  
    @if(Session::has('info'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.info("{{ session('info') }}");
    @endif
  
    @if(Session::has('warning'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.warning("{{ session('warning') }}");
    @endif  

    // get element by id
    const ele = (id) => {
        return document.getElementById(id);
    }

    //  Saved Job
    const savejob = (id) => {
        var url = '{{ route("save-job", ":id") }}',
        url = url.replace(':id', id);
        $.ajax({
            type: "POST",
            url : url,
            data: { 
                "_token" : "{{ csrf_token() }}"
             },
            success: function (res) {
                if(res.method == 'create' && res.success == true){
                    ele(`save-job-${id}`).classList.add('icon-color');
                }
                if(res.method == 'delete' && res.success == true){
                    ele(`save-job-${id}`).classList.remove('icon-color');
                }
            },
            erro: function () {
                alert("Error");
            },
        });
    }

    const apply_job = (id) => {
        var url = '{{ route("apply-job", ":id") }}',
        url = url.replace(':id', id);
        $.ajax({
            type: "POST",
            url : url,
            data: { 
                "_token" : "{{ csrf_token() }}"
             },
            success: function (res) {
                if(res.method == 'create' && res.success == true){
                    ele(`apply-job-${id}`).classList.remove('button-main');
                    ele(`apply-job-${id}`).classList.add('button-success');
                    ele(`apply-job-${id}`).innerText = 'Applied';
                }
                if(res.method == 'delete' && res.success == true){
                    ele(`apply-job-${id}`).classList.remove('button-success');
                    ele(`apply-job-${id}`).classList.add('button-main');
                    ele(`apply-job-${id}`).innerText = 'Apply';
                }
            },
            erro: function () {
                alert("Error");
            },
        });
    }
  </script>

  @yield('scripts')