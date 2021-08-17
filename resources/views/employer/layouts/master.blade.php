<!DOCTYPE html>

<html lang="en">
	@include('employer.layouts.head')

	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		@include('employer.layouts.mobileheader')

		<div class="d-flex flex-column flex-root">
			<div class="d-flex flex-row flex-column-fluid page">
				@include('employer.layouts.leftsidebar')

				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					@include('employer.layouts.webheader')

					@yield('main-content')

					@include('employer.layouts.footer')
				</div>
			</div>
		</div>

		{{--  @include('employer.layouts.rightsidebar')  --}}

		@include('employer.layouts.script')
	</body>

</html>
