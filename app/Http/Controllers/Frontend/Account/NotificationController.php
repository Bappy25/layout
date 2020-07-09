<?php

namespace App\Http\Controllers\Frontend\Account;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\UserNotification;

class NotificationController extends Controller
{protected $notification;

    public function __construct(UserNotification $notification, User $user)
    {
        $this->middleware('auth');
        $this->notification = $notification;        
        $this->user = $user;
    }
    
    public function allNotifications()
    {
        $user = $this->user->find(Auth::user()->id);
        $notifications = $user->notifications()->paginate(15);
        return view('front.account.notifications', compact('user', 'notifications'));
    }

    public function countNotifications()
    {
        try {
	    	$user = $this->user->find(Auth::user()->id);
	    	$notifications = $user->unreadNotifications()->pluck('data');
            return json_encode(['status'=>200, 'count' => count($notifications)]);
        }
        catch (\Exception $e) {
            return ['status'=>401, 'reason'=>$e->getMessage()];
        }
    }

    public function newNotifications()
    {
        try {
	    	$user = $this->user->find(Auth::user()->id);
	    	$notifications = $user->unreadNotifications()->pluck('data');
            return json_encode(['status'=>200, 'notifications' => $notifications]);
        }
        catch (\Exception $e) {
            return ['status'=>401, 'reason'=>$e->getMessage()];
        }
    }

    public function markNotificationsAsRead()
    {
        $user = $this->user->find(Auth::user()->id);
        $user->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', [ 'Success'=>'All notifications are marked as read!' ]);
    }
}
