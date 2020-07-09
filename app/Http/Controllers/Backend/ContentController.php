<?php

namespace App\Http\Controllers\Backend;

use App\Models\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    protected $content;

    function __construct(Content $content)
    {
        $this->middleware('auth.back');
        $this->content = $content;
    }

    public function welcome()
    {
        return view('backend.contents.welcome');
    }

    public function aboutUs()
    {
        return view('backend.contents.about_us');
    }

    public function termsOfUse()
    {
        return view('backend.contents.terms_of_use');
    }

    public function privacyPolicy()
    {
        return view('backend.contents.privacy_policy');
    }

    public function update($id)
    {
    	
    }
}
