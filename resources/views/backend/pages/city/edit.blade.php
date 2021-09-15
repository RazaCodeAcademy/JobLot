@extends('backend.layouts.master')

@section('title')	
	List Cities
@endsection

@section('css')
@endsection

@section('main-content')
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

		<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
			<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
				<div class="d-flex align-items-center flex-wrap mr-1">
					<div class="d-flex align-items-baseline flex-wrap mr-5">
						<h5 class="text-dark font-weight-bold my-1 mr-5">{{__('Cities')}}</h5>
						<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
							<li class="breadcrumb-item">
								<a href="{{route('editCity', $city->id)}}" class="text-muted">{{__('Edit City')}}</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="d-flex flex-column-fluid">
			<div class="container">
				<div class="card card-custom">
					<div class="card-header">
						<h3 class="card-title">{{__('Edit City')}}</h3>
						<div class="card-toolbar">
							<div class="example-tools justify-content-center">
								<span class="example-toggle" data-toggle="tooltip" title="View code"></span>
								<span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
							</div>
						</div>
					</div>

					<form method="POST" action="{{route('updateCity')}}" enctype="multipart/form-data">
						@csrf
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<label>{{__('Country')}}<span class="text-danger">*</span></label>
										<select name="country_id" class="form-control" required>
											<option value="" disabled selected>{{__('Select Country')}}</option>
											@foreach ($countries as $country)
												<option value="{{$country->id}}" {{ ($country->id == $city->country_id) ? 'selected' : '' }}>{{ (session()->has('language')) ? $country->name_ar : $country->name }}</option>
											@endforeach
										</select>
										@error('country_id')
											<span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
										@enderror
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label>{{__('Name')}} {{__('in English')}}<span class="text-danger">*</span></label>
										<input type="text" class="form-control"  placeholder="Enter City Name" name="name" value="{{$city->name}}" required />
										@error('name')
											<span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
										@enderror
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label>{{__('Name')}} {{__('in Arabic')}}<span class="text-danger">*</span></label>
										<input type="text" class="form-control"  placeholder="Enter City Name" name="name_ar" value="{{$city->name_ar}}" required />
										@error('name_ar')
											<span class="invalid-feedback" role="alert">
												{{ $message }}
											</span>
										@enderror
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer" style="text-align: end">
							<input type="hidden" name="id" value="{{$city->id}}"/>
							<button type="submit" class="btn btn-primary mr-2">{{__('Submit')}}</button>
							<button type="reset" class="btn btn-secondary">{{__('Cancel')}}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
@endsection