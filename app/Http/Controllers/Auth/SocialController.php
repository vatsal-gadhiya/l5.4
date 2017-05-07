<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mail\UserCreated;
use Auth;
use Socialite;
use Mail;

class SocialController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $authUser = $this->findOrCreateUser($user);

        $content = [

            'title'=> 'Itsolutionstuff.com mail', 

            'body'=> 'The body of your message.',

            'button' => 'Click Here'

        ];

        $receiverAddress = $authUser->email;

        Mail::to('vatsalgadhiya777@gmail.com')
        ->send(new UserCreated($content));

        Auth::login($authUser, true);

        return redirect()->to('home');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $fbUser
     * @return User
     */
    private function findOrCreateUser($fbUser)
    {
        $user = User::where('facebook_id', $fbUser->id)->first();
        if(!$user){
            $user=new User();
        }
        $user->name=$fbUser->name;
        $user->email=$fbUser->email;
        $user->facebook_id=$fbUser->id;
        $user->access_token=$fbUser->token;
        $user->password='';
        $user->save();

        return $user;

    }
}