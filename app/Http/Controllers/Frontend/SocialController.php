<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Auth;
use DB;
class SocialController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    
    /**
     * Obtain the user information from Twitter.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect()->route('dashboard');
    }
    
    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('social_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        $user = User::create([

            'first_name' => $user->name,
            'last_name' => $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'social_id' => $user->id,
            'social_type'=>$provider,
        ]);
        $data = array('role_id' => '3', "model_type" => 'App\Models\User', "model_id" => $user->id);
        DB::table('model_has_roles')->insert($data);
        return $user;
    }
}
