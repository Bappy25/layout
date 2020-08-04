<?php

namespace App\Http\Controllers\Backend;

use Log;
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
        Log::info('Req=ContentController@welcome called');

        $content = $this->content->where('headline', 'welcome')->firstOrFail();
        return view('backend.contents.welcome', compact('content'));
    }

    public function aboutUs()
    {
        Log::info('Req=ContentController@aboutUs called');

        $content = $this->content->where('headline', 'about_us')->firstOrFail();
        return view('backend.contents.about_us', compact('content'));
    }

    public function termsOfUse()
    {
        Log::info('Req=ContentController@termsOfUse called');

        $content = $this->content->where('headline', 'terms_of_use')->firstOrFail();
        return view('backend.contents.terms_of_use', compact('content'));
    }

    public function privacyPolicy()
    {
        Log::info('Req=ContentController@privacyPolicy called');

        $content = $this->content->where('headline', 'privacy_policy')->firstOrFail();
        return view('backend.contents.privacy_policy', compact('content'));
    }

    public function update(Request $request, $id)
    {
        $content = $this->content->findOrFail($id);

        $input = $request->all();
        unset($input['_token']); unset($input['_method']);
        $content->web_contents = json_encode($input);
        $content->save();

        Log::info('Req=ContentController@update Success=Content updated OK');

        return redirect()->back()->with('success', [ 'Success' => 'Content has been updated!' ]);
    	
    }
}
