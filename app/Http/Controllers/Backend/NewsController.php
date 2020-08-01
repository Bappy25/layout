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

        return view('backend.news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::info('Req=NewsController@create called');
        return view('backend.news.create');
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

        $news = $this->news->findOrFail($id);
        return view('backend.news.edit', compact('news'));
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

            \Log::info('Req=NewsController@update Success=News updated OK');

            return $this->api->success('Draft has been updated!');
            
        }catch(\Exception $e){
            return $this->api->fail($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
