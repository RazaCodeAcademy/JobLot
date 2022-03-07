<!DOCTYPE html>
<html lang="en">
	@include('frontend.layouts.head')
	<body>
		<!-- navbar -->
		@include('frontend.layouts.navbar')
		<!-- header -->
		@yield('content')
		<!-- Optional JavaScript -->
		@if (current_route() != 'jobDetails' && current_route() !='notifications')  
		  @include('frontend.layouts.footer')
		@endif
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		@include('frontend.layouts.script')
	</body>
</html>
