<?php

namespace App\Http\Controllers\Frontend\Auth;

use Session;
use Socialite;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
    */
    public function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = 'home';
    protected function redirectTo()
    {
        Session::flash('success', array('Login successful!'=>''));
        return route('home');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
      * Redirect the user to the Facebook authentication page.
      *
      * @return \Illuminate\Http\Response
      */
    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookProviderCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user(); 
        } catch (\Exception $e) {
            return redirect('/login');
        }

            // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){

            // Update Email verification
            if($existingUser->email_verified_at == NULL){
                $existingUser->email_verified_at = Carbon::now()->toDateTimeString();
                $existingUser->save();
            }

            // log them in
            auth()->login($existingUser, true);

        } else { 

                // create a new user
            $newUser = User::create([
                'name' => $user->name,
                'username' =>md5(uniqid()),
                'email' => $user->email,
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'facebook_id' => $user->id,
            ]);

            $userDetail = UserDetail::create([
                'user_id' => $newUser->id,
                'avatar' => 'http://graph.facebook.com/'.$user->id.'/picture'
            ]);

            auth()->login($newUser, true);
        }
        return redirect()->route('welcome');
    }

    /**
      * Redirect the user to the Google authentication page.
      *
      * @return \Illuminate\Http\Response
      */
    public function redirectToGoogleProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user(); 
        } catch (\Exception $e) {
            return redirect('/login');
        }

            // only allow people with @company.com to login
        /*if(explode("@", $user->email)[1] !== 'company.com'){
            return redirect()->to('/');
        }*/

            // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){

            // Update Email verification
            if($existingUser->email_verified_at == NULL){
                $existingUser->email_verified_at = Carbon::now()->toDateTimeString();
                $existingUser->save();
            }

            // log them in
            auth()->login($existingUser, true);

        } else {

                // create a new user
            $newUser = User::create([
                'name' => $user->name,
                'username' =>md5(uniqid()),
                'email' => $user->email,
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'google_id' => $user->id,
            ]);

            $userDetail = UserDetail::create([
                'user_id' => $newUser->id,
                'avatar' => $user->avatar,
            ]);

            auth()->login($newUser, true);
        }
        return redirect()->route('welcome');
    }

    public function username()
    {
        $identity  = request()->get('identity');
        $fieldName = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldName => $identity]);
        return $fieldName;
    }

    protected function validateLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'identity' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'identity.required' => 'Username or email is required',
                'password.required' => 'Password is required',
            ]
        );
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $request->session()->put('login_error', trans('auth.failed'));
        throw ValidationException::withMessages(
            [
                'error' => [trans('auth.failed')],
            ]
        );
    }

    public function showLoginForm() {
        return view('frontend.auth.login');
    }
}
