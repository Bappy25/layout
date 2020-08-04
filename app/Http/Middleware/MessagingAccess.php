<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Models\User;

class MessagingAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = empty($request->route('message')) ? $request->route('id') : $request->route('message');

        $user = User::findOrFail(Auth::user()->id);

        if($user->message_subjects->contains($id)) return $next($request); 

        return redirect()->back(); 
    }
}
