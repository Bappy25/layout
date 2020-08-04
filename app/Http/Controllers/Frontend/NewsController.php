<?php

namespace App\Http\Controllers\Frontend;

use Log;
use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    protected $news;

    function __construct(News $news)
    {
        $this->news = $news;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        Log::info('Req=NewsController@index called');
        $all_news = $this->news->search($request->search)->filter(request(['month', 'year']))->where('status', '<>', 0)->orderBy('created_at', 'desc')->paginate(5);
        return view('frontend.news.index', compact('all_news'));
    } 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('Req=NewsController@show called news_id='.$id);

        $news = $this->news->findOrFail($id);

        // Save viewers
        $viewers = (array) json_decode($news->viewers, true);
        array_push($viewers, \Request::ip());
        $news->viewers = json_encode(array_unique($viewers));
        $news->save();
        return view('frontend.news.show', compact('news'));
    }
}
