<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.back');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        \Log::info('Req=HomeController@index called!');

        $users = \App\Models\User::all()->count();
        $admins = \App\Models\Admin::all()->count();
        $news = \App\Models\News::where('status', '<>', 0)->count();
        $unpublished_news = \App\Models\News::where('status', 0)->count();
        return view('backend.home', compact('users', 'admins', 'news', 'unpublished_news'));
    }
}
