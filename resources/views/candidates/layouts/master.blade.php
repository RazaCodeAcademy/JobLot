<!DOCTYPE html>

<html lang="en">
	@include('candidates.layouts.head')

	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		@include('candidates.layouts.mobileheader')

		<div class="d-flex flex-column flex-root">
			<div class="d-flex flex-row flex-column-fluid page">
				@include('candidates.layouts.leftsidebar')

				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					@include('candidates.layouts.webheader')

					@yield('main-content')

					@include('candidates.layouts.footer')
				</div>
			</div>
		</div>

{{--		@include('candidates.layouts.rightsidebar')--}}

		@include('candidates.layouts.script')
	</body>

</html>
