<!DOCTYPE html>

<html lang="en">
	@include('backend.layouts.head')

	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		@include('backend.layouts.mobileheader')

		<div class="d-flex flex-column flex-root">
			<div class="d-flex flex-row flex-column-fluid page">
				@include('backend.layouts.leftsidebar')

				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					@include('backend.layouts.webheader')
 
					@yield('main-content')

					@include('backend.layouts.footer')
				</div>
			</div>
		</div>

		@include('backend.layouts.rightsidebar')

		@include('backend.layouts.script')
	</body>

</html>