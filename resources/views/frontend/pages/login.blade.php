<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
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
    	<title>Login</title>
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
					<p>
						Find the perfect job and explore<br />
						thousands of vacancies daily
					</p>
					<h6>Log in your account</h6>

					<form class="main-form" action="{{ route('user-login') }}" method="post">
						@csrf
						<input type="text" name="email" placeholder="Username" />
						@if ($errors->has('email'))
							<div> <span  class="text-danger" id="emailError">{{ $errors->first('email') }}</span></div>
							{{-- <span class="fa fa-info-circle errspan"></span> --}}
                        @endif
						<input type="password" name="password" placeholder="Password" />
						@if ($errors->has('password'))
							<div> <span  class="text-danger" id="passwordError">{{ $errors->first('password') }}</span></div>
							{{-- <span class="fa fa-info-circle errspan"></span> --}}
                        @endif
						<button>Log in</button>
						<div class="main-bottom">
							<a href="#">Forgot your password ?</a>
							<a href="{{ route('register') }}">New member ?</a>
						</div>
					</form>

					<footer class="main-footer">
						<p>Or continue with social accounts</p>
						<ul>
							<li>
								<a href="{{ url('/login/facebook') }}"> <i class="fab fa-facebook-f"></i></a>
							</li>
							<li>
								<a href="{{ url('/login/twitter') }}"><i class="fab fa-twitter"></i></a>
							</li>
							<li>
								<a href="{{ url('/login/google') }}">
									<i class="fab fa-google"></i>
								</a>
							</li>
						</ul>
					</footer>
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
