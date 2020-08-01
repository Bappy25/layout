<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $content;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Content $content)
    {
        $this->middleware(['auth', 'verified'])->only('home');
        $this->content = $content;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        \Log::info('Req=HomeController@index called!');

        $content = $this->content->where('headline', 'welcome')->firstOrFail();
        $welcome = json_decode($content->web_contents);
        return view('welcome', compact('welcome'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        \Log::info('Req=HomeController@home called!');

        return view('frontend.home');
    }

    /**
     * About Us
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about()
    {
        \Log::info('Req=HomeController@about called!');

        $content = $this->content->where('headline', 'about_us')->firstOrFail();
        $about = json_decode($content->web_contents);
        return view('frontend.about_us', compact('about'));
    }

    /**
     * Privacy Policy
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function privacyPolicy()
    {
        \Log::info('Req=HomeController@privacyPolicy called!');

        $content = $this->content->where('headline', 'privacy_policy')->firstOrFail();
        $privacy = json_decode($content->web_contents);
        return view('frontend.privacy_policy', compact('privacy'));
    }

    /**
     * Terms of Use
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function termsOfUse()
    {
        \Log::info('Req=HomeController@termsOfUse called!');
        
        $content = $this->content->where('headline', 'terms_of_use')->firstOrFail();
        $terms = json_decode($content->web_contents);
        return view('frontend.terms_of_use', compact('terms'));
    }
}
