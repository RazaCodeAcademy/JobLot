@extends('frontend.layouts.master')

@section('title', 'Site-map')

@section('content')

  <!--content starts here-->
<div class="container"style="padding: 12rem 0;">
  <div class="row">
    <div class="col-md-6">
      <div class="site-map-text">
        <h1 class="text-dark">OUR LOCATION</h1>
        <h5 class="text-dark">Just around the corner</h5>
        <ul>
          <li class="text-dark">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed d</li>
          <li class="text-dark">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed d</li>
          <li class="text-dark">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed d</li>
          <li class="text-dark">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed d</li>
          <li class="text-dark">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed d</li>
        </ul>
      </div>
    </div>
    <div class="col-md-6">
       <div class="map-wrapper">
       <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d13600.757890586037!2d74.3000763!3d31.546414349999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1648214674261!5m2!1sen!2s" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
       </div>
    </div>
  </div>
</div>
@endsection