<?php

namespace App\Http\Controllers\Frontend\Account;

use Log;
use Auth;
use App\Models\User;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\UserNotification;

class NotificationController extends Controller
{
    protected $api;
    protected $notification;

    public function __construct(UserNotification $notification, User $user, ApiHelper $api)
    {
        $this->middleware('auth');
        $this->notification = $notification;        
        $this->user = $user;
        $this->api = $api;
    }
    
    public function allNotifications()
    {
        Log::info('Req=NotificationController@allNotifications called');

        $user = $this->user->find(Auth::user()->id);
        $notifications = $user->notifications()->paginate(15);
        return view('frontend.account.notifications', compact('user', 'notifications'));
    }

    public function countNotifications()
    {
        try {
	    	$user = $this->user->find(Auth::user()->id);
	    	$count = count($user->unreadNotifications()->pluck('data'));

            Log::info('Req=NotificationController@newMessagesCount notifications count='.$count);

            return $this->api->success($count);
        }
        catch (\Exception $e) {
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }

    public function newNotifications()
    {
        try {
	    	$user = $this->user->find(Auth::user()->id);
	    	$notifications = $user->unreadNotifications()->pluck('data');

            Log::info('Req=NotificationController@newNotifications list generated');

            return $this->api->success('New notifications list generated!', $notifications);
        }
        catch (\Exception $e) {
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }

    public function markNotificationsAsRead()
    {
        try {
            $user = $this->user->find(Auth::user()->id);
            $user->unreadNotifications->markAsRead();

            Log::info('Req=NotificationController@markNotificationsAsRead notifications marked as read OK');

            return $this->api->success('Notifications marked as read!');
        }
        catch (\Exception $e) {
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }
}
