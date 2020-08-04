<?php

namespace App\Http\Controllers\Frontend;

use Log;
use Cache;
use App\Models\User;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $api;
    private $user;

    public function __construct(User $user, ApiHelper $api)
    {
        $this->middleware('auth')->only('getStatus');
        $this->user = $user;
        $this->api = $api;
    }
	/**
     * Display user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile($username)
    {
        Log::info('Req=UserController@profile called username='.$username);

    	$user = $this->user->where('username', $username)->firstOrFail();
    	dd($user);
    }

    /**
     * get online status.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStatus(Request $request)
    {
        try {
            $status = 0;
            $user = $this->user->where('username', $request->username)->first();

            if (Cache::has('user-is-online-' . $user->id))
                $status = 1;

            Log::info('Req=UserController@getStatus status found user_id='.$user->id);

            return $this->api->success($status);
        }
        catch (\Exception $e) {
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }  
}
