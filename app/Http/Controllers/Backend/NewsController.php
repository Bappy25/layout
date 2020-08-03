<?php

namespace App\Http\Controllers\Backend;

use Log;
use App\Models\News;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    protected $api;
    protected $news;

    function __construct(News $news, ApiHelper $api)
    {
        $this->middleware('auth.back');
        $this->api = $api;
        $this->news = $news;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        Log::info('Req=NewsController@index called');

        $all_news = $this->news->all();
        return view('backend.news.index', compact('all_news'));
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::info('Req=NewsController@create called');

        $tags = $this->news->allTags();
        return view('backend.news.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $news = $this->news;
        $news->title = $request->title;
        $news->tags = $request->tags;
        $news->admin_id = \Auth::guard('admin')->user()->id;
        $news->save();

        Log::info('Req=NewsController@store Success=news has been added!');

        return redirect()->route('back.news.edit', $news->id)->with('success', [ 'Success' => 'Draft has been saved!' ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Log::info('Req=NewsController@edit called news_id='.$id);

        $tags = $this->news->allTags();
        $news = $this->news->findOrFail($id);
        return view('backend.news.edit', compact('news', 'tags'));
    }

    /**
     * Update news image
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateImage(Request $request, $id)
    {
        $this->api->validator($request->all(), [
            'image' => 'required|image|dimensions:min_width=100,min_height=200|max:1000'
        ]);

        try {
            $news = $this->news->findOrFail($id);
            $path = $this->uploadImage($request->file('image'), 'all_images/news_images/', 640, 360);
            $news->image_path = $path;
            $news->save();

            Log::info('Req=NewsController@updateImage Success=Image updated OK');

            return $this->api->success('Image has been successfully updated!');
            
        }catch(\Exception $e){
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {
        try {

            $news = $this->news->findOrFail($id);
            $input = $request->all();
            $news->update($input);

            Log::info('Req=NewsController@update Success=News updated OK');

            return $this->api->success('News has been updated!');
            
        }catch(\Exception $e){
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function publish(Request $request, $id)
    {
        $news = $this->news->findOrFail($id);
        $news->status = 1;
        $news->save();

        Log::info('Req=NewsController@publish Success=News published OK');

        return redirect()->route('back.news.edit', $id)->with('success', [ 'Success' => 'News has been published!' ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->news->findOrFail($id)->delete();

        Log::info('Req=NewsController@delete Success=News deleted OK news_id='.$id);

        return redirect()->route('back.news.index')->with('warning', array('News has been removed!'=>''));
    }
}
