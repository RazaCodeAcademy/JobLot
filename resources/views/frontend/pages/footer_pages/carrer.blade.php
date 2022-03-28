@extends('frontend.layouts.master')

@section('title', 'Career')

@section('content')
  <!--content starts here-->
  <section class="abouts-us">
    <div class="about-us-text">
      <h1>ABOUT US</h1>
      <p>WE CAN GET YOUR IDEAL JOB</p>
      <button class="btn btn-primary send-btn">Learn More</button>
    </div>
  </section>
  <div class="container">
     <div class="row silde-by">
        <div class="col-md-6" style="padding:3rem">
           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
           <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat </p>
           <button class="btn btn-primary send-btn my-3">Learn More</button>
        </div>
        <div class="col-md-6" >
          <figure class="contact-img"style=" padding:3rem">
             <img src="{{ asset('/public/frontend/img/contact-side.jpg')}}" class="img-fluid c-img" alt="">
          </figure>
        </div>
     </div>
  </div>
    <div class="container">
     <div class="row silde-by">
     <div class="col-md-6" >
          <figure class="contact-img"style=" padding:3rem">
             <img src="{{ asset('/public/frontend/img/contact-side.jpg')}}" class="img-fluid c-img" alt="">
          </figure>
        </div>
        <div class="col-md-6" style="padding:3rem">
           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
           <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat </p>
           <button class="btn btn-primary send-btn my-3">Learn More</button>
        </div>
     </div>
  </div>


@endsection