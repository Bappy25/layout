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
        $content = $this->content->where('headline', 'welcome')->firstOrFail();
        return view('backend.contents.welcome', compact('content'));
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

    public function update(Request $request, $id)
    {
        $content = $this->content->findOrFail($id);

        $input = $request->all();
        unset($input['_token']); unset($input['_method']);
        $content->web_contents = json_encode($input);
        $content->save();

        \Log::info('Req=ContentController@update Success=Content updated OK');

        return redirect()->back()->with('success', [ 'Success' => 'Content has been updated!' ]);
    	
    }
}
