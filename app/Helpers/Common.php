<?php

// use facades
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// send notifications
if (!function_exists("notifications")) {
    function notifications($parent_id, $parent_type, $message){
        $data = [
            'parent_id'     => $parent_id,
            'parent_type'   => $parent_type,
            'message'       => $message,
            'route'         => current_url(),
            'image'         => user()->get_image(),
        ];

        $data = [
            "type"              => $parent_type,
            "notifiable_type"   => User::class,
            "notifiable_id"     => user()->id,
            "data"              => serialize($data),
        ];

        Notification::create($data);
    }
}

// send notifications
if (!function_exists("unserialized_notification")) {
    function unserialized_notification($notifications){
        if(!empty($notifications)){

            foreach ($notifications as $key => $value) {
                $value->data = unserialize($value->data);
            }
        }

        return $notifications;
    }
}

// get current route name
if(!function_exists('user'))
{
    function user()
    {
        return Auth::user();
    }
}

// get current route name
if(!function_exists('current_route'))
{
    function current_route()
    {
        return \Request::route()->getName();
    }
}

// get current url name
if(!function_exists('current_url'))
{
    function current_url()
    {
        return \Request::url();
    }
}