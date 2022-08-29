<?php

// use facades
use App\Models\Notification;
use App\Models\User;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

// send notifications
if (!function_exists("notifications")) {
    function notifications($id=null, $notifiable, $parent_type, $message){
        $data = [
            'id'            => $id,
            'parent_id'     => user()->id,
            'parent_type'   => $parent_type,
            'message'       => $message,
            'username'      => user()->get_name(),
            'image'         => user()->get_image(),
        ];

        $data = [
            "type"              => $parent_type,
            "notifiable_type"   => User::class,
            "notifiable_id"     => $notifiable,
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

// get current url name
if(!function_exists('getUser'))
{
    function getUser($users, $id)
    {
        foreach ($users as $user) {
            $user->saved = $user->isSavedListed($id);
            $user->shortListed = $user->isShortListed($id);
            $user->applied = $user->isAppliedListed($id);
        }
        return $users;
    }
}

// get current url name
if(!function_exists('getJob'))
{
    function getJob($jobs, $id)
    {
        if(is_countable($jobs)){
            foreach ($jobs as $job) {
                $job->saved = $job->isSavedListed($id);
                $job->shortListed = $job->isShortListed($id);
                $job->applied = $job->isAppliedListed($id);
            }
            return $jobs;
        }else{
            $jobs->saved = $jobs->isSavedListed($id);
            $jobs->shortListed = $jobs->isShortListed($id);
            $jobs->applied = $jobs->isAppliedListed($id);
            return $jobs;
        }
    }
}

// get current url name
if(!function_exists('formatJob'))
{
    function formatJob($jobs)
    {
        $jobs_array = [];
        foreach ($jobs as $key => $value) {
            $job = Job::find($value);
            if($job){
                array_push($jobs_array, $job);
            }
        }

        return $jobs_array;
    }
}