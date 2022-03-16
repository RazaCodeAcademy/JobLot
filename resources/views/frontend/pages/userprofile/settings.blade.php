<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Font Awesome Css -->
    <link rel="stylesheet" href="{{ asset('/public/frontend/css/font-awesome/css/all.css') }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/public/frontend/css/bootstrap.min.css') }}" />
    <!-- Custom CSS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/public/frontend/css/main.css') }}" />
	   {{-- Toaster --}}
   <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0- 
    alpha/css/bootstrap.css" rel="stylesheet">
    <title>{{__('JobLot')}}</title>
    <link rel="shortcut icon" href="{{ asset('/public/frontend/img/logo-color.png') }}">
</head>

<body>
    <section class="welcome">
        <a href="#" class="welcome-logo">
            <img src="{{ asset('/public/frontend/img/logo-white.png') }}" alt="main-logo" />
        </a>

        <main class="main">
            <div class="main-header">
                <img src="{{ asset('/public/frontend/img/logo-color.png') }}" alt="" />
            </div>
            <div class="main-content">
                @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:10px;">
                    {{Session::get('error_message')}}
                    <button type="button" class="close" data-dismiss ="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                 @endif
                @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
                        {{Session::get('success_message')}}
                        <button type="button" class="close" data-dismiss ="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <p>
                    Find the perfect job and explore<br />
                    thousands of vacancies daily
                </p>
                <h6>Reset Your Password</h6>

                <form class="main-form" method="POST" action="{{route('update-current-password')}}" enctype="multipart/form-data">
                    @csrf

                    <label for="Current Password">Current Password</label><br>
                    <input type="password"  id="current_pwd" name="current_pwd" placeholder="Enter Current Password">
                    <span id="chkCurrentpwd"></span>
                    <br>
                    <label for="exampleInputPassword1">New Password</label>
                    <input type="password"  id="new_pwd" name="new_pwd" placeholder="Enter New Password" required>
            
                    
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password"  id="confirm_pwd" name="confirm_pwd" placeholder="Enter Confirm Password" required>
                      
                    <button type="submit" class="btn btn-primary">
                        <i class="la la-check-square-o"></i> Save changes
                    </button>
                </form>
            </div>
        </main>
    </section>

   <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('/public/frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('/public/frontend/js/popper.js') }}"></script>
    <script src="{{ asset('/public/frontend/js/bootstrap.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('/public/frontend/js/main.js') }}"></script>
    {{-- Toaster --}}
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
    </script>

    <script>
    $(document).ready(function () {
        $("#current_pwd").keyup(function () {
            var current_pwd = $("#current_pwd").val();
            // console.log(current_pwd);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                type: "post",
                url: "check_current",
                data: { current_pwd: current_pwd },
                success: function (resp) {
                    if (resp == "false") {
                        $("#chkCurrentpwd").html(
                            "<font color=red>Current password is Incorrect</font>"
                        );
                    } else if (resp == "true") {
                        $("#chkCurrentpwd").html(
                            "<font color=green>Current password is Correct</font>"
                        );
                    }
                },
            });
        });
    });
    </script>

</body>

</html>