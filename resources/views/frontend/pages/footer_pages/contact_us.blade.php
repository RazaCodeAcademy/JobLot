@extends('frontend.layouts.master')

@section('title', 'Contact-us')

<style>
  .error{
    color: #a7b7b7;
    font-size: 1.2rem;
  }
</style>

@section('content')

  <!--content starts here-->
    <div class="contact-form">
      <div class="contact-form-wrapper">
        <h1 class="text-center display-3 mb-2">Contact Us</h1>
        <div class="container bg-danger px-0">
           <div class="row mx-0"> 
             <div class="col-md-6 px-0 bg-form">
               <form method="post" action="{{ route('contact.store') }}">
                 @csrf
                  <div class="contact-form-layout">
                    <h1>Send us a message</h1>
                    <div class="mb-3">  
                      <input type="text" class="form-control {{ $errors->has('name') ? 'error' : '' }}" name="name" id="name" placeholder="Name">
                      @if ($errors->has('name'))
                        <div class="error">
                          {{ $errors->first('name') }}
                        </div>
                      @endif
                    </div>
                    <div class="mb-3">
                      <input type="email" class="form-control {{ $errors->has('email') ? 'error' : '' }}" name="email" id="email" placeholder="Email">
                      @if ($errors->has('email'))
                        <div class="error">
                          {{ $errors->first('email') }}
                        </div>
                      @endif
                    </div>
                    <div class="mb-3">
                      <input type="text" class="form-control {{ $errors->has('subject') ? 'error' : '' }}" name="subject" id="subject" placeholder="Subject">
                      @if ($errors->has('subject'))
                        <div class="error">
                          {{ $errors->first('subject') }}
                        </div>
                      @endif
                    </div>
                      <div class="mb-3">
                        <textarea class="form-control {{ $errors->has('msg') ? 'error' : '' }}" name="msg" id="msg" rows="3" placeholder="Message"></textarea>
                        @if ($errors->has('msg'))
                          <div class="error">
                            {{ $errors->first('msg') }}
                          </div>
                        @endif
                      </div>
                      <button type="submit"  class="btn btn-primary btn-lg send-btn">Send Us</button>
                  </div>
               </form>
             </div>
             <div class="col-md-6 px-0 bg-light">
               <div class="socail-info">
               <h1>Contact us</h1>
               <p>We'r open for any suggestion or just to have a chat</p>
                  <div class="sl-wrapper mt-5">
                    <div>
                    <i class="fa fa-map-marker"></i>
                    </div>
                    <div>
                      <P class=""><b>Address:</b> 198 West 21th Street, Suite 721 New York NY 10016</P>
                    </div>
                  </div>
                  <div class="sl-wrapper">
                    <div>
                    <i class="fa fa-phone"></i>
                    </div>
                    <div>
                      <p>
                      <b>Phone:</b> + 1235 2355 98</p>
                    </div>
                  </div>
                  <div class="sl-wrapper">
                    <div><i class="fa fa-envelope"></i></div>
                    <div>
                      <p><b>Email:</b> info@yoursite.com</p>
                    </div>
                  </div>
                  <div class="sl-wrapper">
                    <div>
                    <i class="fa fa-globe"></i>
                    </div>
                    <div>
                      <p><b>Website</b>Website yoursite.com</p>
                    </div>
                  </div>
               </div>
             </div>
           </div>
        </div>
      </div>
    </div>
@endsection