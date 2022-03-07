@extends('frontend.layouts.master')
@section('content')
<div class="notification">
    <div class="container" style="background-color: #e9ecef;">
        <div class="row p-4">
            <h1>Notification <i class="fa fa-bell text-warning"></i></h1>
        </div>
    </div>
    <div class="container notification-wrapper">
        @foreach ($notifications as $notification)
        {{-- @dd($notification) --}}
            <div class="row my-3">
                <div class="col-md-12 bg-light notifi-item">
                    <div>
                   <div class="d-flex gap-3">
                         <img class="notification-img" src="{{ $notification->data['image'] }}" alt="icon" />
                         <div>
                             <h3 class="noti-title mb-0">{{ $notification->data['username'] }}</h3>
                             <p class="" style="font-size: 1.4rem;">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste deleniti excepturi voluptates error Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti quam reprehenderit eos possimus obcaecati, ab et magni suscipit officia assumenda unde pariatur laborum consectetur veritatis dicta dolor, architecto recusandae itaque. fa cilis voluptate hic officia tenetur labore praesentium.</p>
                             <p class="time mb-0">{{  $notification->created_at->format('d-M-y') }}</p>
                         </div>
                   </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection