<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Notifications\Notifiable;
use App\Notifications\WelcomeEmail;
use App\Mail\UserCreated;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use Notifiable;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $content = [

            'title'=> 'Itsolutionstuff.com mail', 

            'body'=> 'The body of your message.',

            'button' => 'Click Here'

        ];


        // Mail::to('vatsalgadhiya777@gmail.com')
        //  ->queue(new UserCreated($content));

        $user->notify(new WelcomeEmail($content));

        // Send the activation email
        // $email = $data['email'];
        // $first_name = $data['name'];

        // Mail::send(
        //         'email_template.welcome', ['code' => $code, 'email' => $email, 'first_name' => $first_name], function ($message) use ($email) {
        //     $message->to($email)
        //             ->subject('Welcome to Life Process');
        //     $bcc = explode(',', config('srtpl.bccmail'));
        //     if (!empty($bcc)) {
        //         $message->bcc($bcc);
        //     }
        // });
        session()->flash('success', "You are registered successfully. Check Your Mail Activation Link Send to Your Mail.");
        //return $user;
        return redirect()->route('login');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
