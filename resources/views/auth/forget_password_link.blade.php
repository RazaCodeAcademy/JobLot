<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<!-- Font Awesome Css -->
		<link rel="stylesheet" href="{{ asset('/public/frontend/css/font-awesome/css/all.css') }}" />
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('/public/frontend/css/bootstrap.min.css') }}" />
		<!-- Custom CSS -->
		<link rel="stylesheet" href="{{ asset('/public/frontend/css/main.css') }}" />
		{{-- Toaster --}}
		<link href="{{asset('public/toast/toastr1.css')}}" rel="stylesheet">
    	<link href="{{asset('public/toast/toastr2.css')}}" rel="styleshee">
    	<title>Reset Password</title>
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
					
					<h6>Recover Your Account</h6>

					<form class="main-form" action="{{ route('ResetPasswordPost') }}" method="POST">
						@csrf
                        <input type="hidden" name="token" value="{{ $token }}">

            
						<input type="text" id="email_address" class="form-control" name="email" required autofocus placeholder="Email">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    
                        <input type="password" id="password" class="form-control" name="password" required autofocus placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif

                        <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus placeholder="Comfirm Password">
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif

                        <button type="submit" class="btn btn-primary">
                            Reset Password
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

		<script src="{{asset('public/toast/toastr.js')}}"></script>
		<script src="{{asset('public/toast/toastr.min.js')}}"></script>
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
	</body>
</html>
