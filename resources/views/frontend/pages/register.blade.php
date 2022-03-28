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
		<title>register</title>
		<link rel="shortcut icon" href="{{ asset('/public/frontend/img/logo-color.png') }}">
		<style>
			.hidden{
				display: none;
			}
		</style>
	</head>
	<body>
		<section class="welcome">
			<a href="#" class="welcome-logo">
				<img src="{{ asset('/public/frontend/img/logo-white.png') }}" alt="main-logo" />
			</a>

			<div class="register-wrapper">
				<main class="main register">
					<div class="main-header register-header">
						<a href="{{ route('login') }}" onclick="back()"><i class="fas fa-chevron-left"></i></a>
						<p>Register to joblot</p>
					</div>
					<div class="main-content">
						<form class="main-form" action="{{ route('user-register') }}" method="post">
							@csrf
							<div class="main-form-control" id="f_name">
								<input type="text" name="first_name" value="{{old('first_name') }}"  placeholder="First name"  />
								@if ($errors->has('first_name'))
									<div> <span  class="text-danger" id="first_nameError">{{ $errors->first('first_name') }}</span></div>
								@endif
							</div>
							<div class="main-form-control"  id="l_name">
								<input type="text" name="last_name"  value="{{old('last_name') }}"   placeholder="Last name" />
								@if ($errors->has('last_name'))
									<div> <span  class="text-danger"id="last_nameError">{{ $errors->first('last_name') }}</span></div>
								@endif
							</div>
							<div class="main-form-control" id="dob">
								<input type="date" name="dob"  value="{{old('dob') }}"  placeholder="Birth date"  />
								@if ($errors->has('dob'))
									<div> <span  class="text-danger" id="dobError">{{ $errors->first('dob') }}</span></div>
								@endif
							</div>
							<div class="main-form-control" id="phone"> 
								<input type="text" name="phone_number" value="{{old('phone_number') }}" placeholder="Phone number"  />
								@if ($errors->has('phone_number'))
									<div> <span  class="text-danger" id="phone_numberError">{{ $errors->first('phone_number') }}</span></div>
								@endif
							</div>
                            <div class="main-form-control hidden" id="email">
								<input type="email" name="email" value="{{old('email') }}"  placeholder="Email"  />
								<small>Your email will be used as your username</small>
								@if ($errors->has('email'))
									<div> <span  class="text-danger" id="emailError">{{ $errors->first('email') }}</span></div>
								@endif
							</div>
							<div class="main-form-control hidden" id="password" >
								<input type="password" name="password" value="{{old('password') }}"  placeholder="Password" />
								<small>Must be atleast 8 characters</small>
								@if ($errors->has('password'))
									<div> <span  class="text-danger" id="passwordError">{{ $errors->first('password') }}</span></div>
								@endif
							</div>
							<div class="main-form-control hidden"  id="zip">
								<input type="text" name="zip_code" value="{{old('zip_code') }}"  placeholder="Zipcode" />
								@if ($errors->has('zip_code'))
									<div> <span  class="text-danger" id="zip_codeError">{{ $errors->first('zip_code') }}</span></div>
								@endif
							</div>
							<div class="main-form-control hidden"  id="address">
								<input type="text" name="street_address"  value="{{old('street_address') }}" placeholder="Street Address"  />
								@if ($errors->has('street_address'))
									<div> <span  class="text-danger" id="street_addressError">{{ $errors->first('street_address') }}</span></div>
								@endif
							</div>
                            
							<div class="div hidden " id="terms">
								<div class="main-form-control main-form-terms hidden">
									<input type="radio" name="terms_and_conditions"  />
									@if ($errors->has('terms_and_conditions'))
										<div> <span  class="text-danger" id="terms_and_conditionsError">{{ $errors->first('terms_and_conditions') }}</span></div>
									@endif
									<p>
										By checking this. I acknowledge, i have read, and understand, and agree to
										Joblot's
										<a href="#">Terms of Uses and Privacy Policy</a>
									</p>
								</div>
								<div class="main-form-control main-form-terms hidden ">
									<input type="radio"/>
									<p>
										Yes, i want to receive email job alerts from Joblot that are personalized based on
										my interests.
									</p>
								</div>
							</div>  
                            <button class="mt-5" type="button" onclick="fields_show()" id="continue">Continue <i class="fas fa-chevron-right ml-2"></i></button>
						   <div class="form-navigation">
                               {{-- <button type="button" class="previous btn">Next <i class="fas fa-chevron-right ml-2"></i></button> --}}
                               {{-- <button type="button" class="previous btn">Previous <i class="fas fa-chevron-right ml-2"></i></button> --}}
                               <button type="submit" class="previous btn hidden" id="submit">Submit <i class="fas fa-chevron-right ml-2"></i></button>
                           </div>
						</form>
					</div>
				</main>
			</div>
		</section>

            <script>
			function fields_show(){
				$('#f_name').addClass("hidden");
				$('#l_name').addClass("hidden");
				$('#dob').addClass("hidden");
				$('#phone').addClass("hidden");
				$('#continue').addClass("hidden");
			    // remove class
				$('#email').removeClass("hidden");
				$('#password').removeClass("hidden");
				$('#zip').removeClass("hidden");
				$('#address').removeClass("hidden");
				$('#terms').removeClass("hidden");
				$('#submit').removeClass("hidden");
			}
			// Bcak function
			function back(){
				$('#f_name').removeClass("hidden");
				$('#l_name').removeClass("hidden");
				$('#dob').removeClass("hidden");
				$('#phone').removeClass("hidden");
				$('#continue').removeClass("hidden");
		       
				$('#email').addClass("hidden");
				$('#password').addClass("hidden");
				$('#zip').addClass("hidden");
				$('#address').addClass("hidden");
				$('#terms').addClass("hidden");
				$('#submit').addClass("hidden");
				



				

			}
                
            </script>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="{{ asset('/public/frontend/js/jquery.js') }}"></script>
		<script src="{{ asset('/public/frontend/js/popper.js') }}"></script>
		<script src="{{ asset('/public/frontend/js/bootstrap.min.js') }}"></script>

		<!-- Custom JS -->
		<script src="{{ asset('/public/frontend/js/main.js') }}"></script>
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
