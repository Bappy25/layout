<?php

namespace App\Http\Controllers\Frontend\Account;

use DB;
use Log;
use Auth;
use Validator;
use App\Models\User;
use App\Models\Message;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Models\MessageViewer;
use App\Models\MessageSubject;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    protected $api;
    protected $user;
    protected $view;
    protected $message;
    protected $subject;

    public function __construct(Message $message, MessageSubject $subject, MessageViewer $view, User $user, ApiHelper $api)
    {
        $this->middleware('auth');
        $this->middleware('messaging.belongs')->only('show', 'editSubject');
        $this->api = $api;
        $this->user = $user;
        $this->view = $view;
        $this->message = $message;
        $this->subject = $subject;
    }

    private function saveViewer($message_id, $user_id){
        $view = $this->view;
        $view->message_id = $message_id;
        $view->user_id = $user_id;
        $view->save();
    }

    private function getReceipents($id)
    {
        $allParticipants = array();
        $subject = $this->subject->findOrFail($id);
        foreach($subject->participants as $participant){ 
            array_push($allParticipants, $participant->id);
        }
        return $allParticipants;
    }

    private function unreadMessages()
    {
        $unreadMessages = array();
        $user = $this->user->find(Auth::user()->id);
        foreach($user->message_subjects as $subject){
            $message = $this->message->where('message_subject_id','=', $subject->id)->orderBy('created_at', 'DESC')->first();
            if((isset($message) && count($message->viewers) == 0) || (isset($message) && count($message->viewers) > 0 && !$message->viewers->contains('user_id', $user->id))){
                $unreadMessages[] = array(
                    'user'=>$message->user->name, 
                    'link'=>route('messages.show', $message->message_subject->id), 
                    'message'=>strip_tags(substr($message->message_text,0,20))."...", 
                    'date'=>date('l d F Y, h:i A', strtotime($message->created_at))
                );
            }
        }
        return $unreadMessages;
    }

    /**
     * Display new message count.
     *
     * @return \Illuminate\Http\Response
     */
    public function newMessagesCount()
    {
        try {
            $count = count($this->unreadMessages());

            Log::info('Req=MessageController@newMessagesCount message count='.$count);

            return $this->api->success($count);
        }
        catch (\Exception $e) {
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }

    /**
     * Display a listing of new messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function newMessages()
    {
        try {
            $unreadMessages = $this->unreadMessages();
            if(count($unreadMessages) > 0){
                $unreadMessages = array_values(\Arr::sort($unreadMessages, function ($value) {
                    return $value['date'];
                }));            
            }

            Log::info('Req=MessageController@newMessages list generated');

            return $this->api->success('New message list generated!', array_reverse($unreadMessages));
        }
        catch (\Exception $e) {
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Log::info('Req=MessageController@index called');

        $keyword = $request->search;
        $user = $this->user->find(Auth::user()->id);
        $messages = $user->message_subjects()->withCount(['messages as latest_message' => function($query) {
            $query->select(DB::raw('max(messages.created_at)'));
        }])->search($keyword)->orderByDesc('latest_message')->paginate(15);
        return view('frontend.account.messaging.index', compact('messages', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($username)
    {
        Log::info('Req=MessageController@create called');

        $recipient = $this->user->where('username', $username)->first();
        return view('frontend.account.messaging.form', compact('recipient'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addMessageSubject(Request $request)
    {
        $this->validate(request(),[
            'subject' => 'required|string|max:500',
            'message_text' => 'required|string|max:5000'
        ]);

        $subject = $this->subject;
        $subject->subject = $request->subject;
        $subject->save();
        $message = $this->message;
        $message->message_subject_id = $subject->id;
        $message->message_text = $request->message_text;
        $message->user_id = Auth::user()->id;
        $message->save();
        $subject->participants()->attach(Auth::user()->id);
        $subject->participants()->attach($request->receipent);

        Log::info('Req=MessageController@addMessageSubject message subject added OK');

        return redirect()->route('messages.show', $subject->id)->with('success', array('Success'=>'Your message has been added!'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'message_text' => 'required|string|max:5000'
        ]);
        $input = $request->all();
        $this->message->create($input);

        Log::info('Req=MessageController@store message added OK');

        return redirect()->route('messages.show', $request->message_subject_id)->with('success', array('Success'=>'Your message has been added!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('Req=MessageController@show called message_subject_id='.$id);

        $subject = $this->subject->findOrFail($id);
        $messages = $this->message->where('message_subject_id', '=', $id)->orderBy('created_at', 'desc')->paginate(10);
        if($messages->onFirstPage() && $messages->isNotEmpty() && !$messages->first()->viewers->contains('user_id', Auth::user()->id)){
            $this->saveViewer($messages->first()->id, Auth::user()->id);
        }
        return view('frontend.account.messaging.show', compact('subject', 'messages'));
    }

    /**
     * Get status.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStatus(Request $request)
    {
        try {
            $status = 0;
            $total = $this->message->where('message_subject_id', '=', $request->subject_id)->count();
            if($total > $request->total){
                $status = 1;
            }

            Log::info('Req=MessageController@getStatus status found subject_id='.$request->subject_id);

            return $this->api->success('Status found!', ['status'=> $status, 'total' => $total]);
        }
        catch (\Exception $e) {
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }  

    /**
     * Edit subjet.
     *
     * @return \Illuminate\Http\Response
     */
    public function editSubject($id)
    {
        try {
            $subject = $this->subject->findOrFail($id);

            Log::info('Req=MessageController@editSubject subject found subject_id='.$id);

            return $this->api->success($subject->subject);
        }
        catch (\Exception $e) {
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }

    /**
     * Update subject.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateSubject(Request $request, $id)
    {        
        $error_response = $this->api->validator($request->all(), [
            'subject' => 'required|string|max:5000'
        ]);
        if ($error_response) return $error_response;

        try {
            $input = $request->all();
            $subject = $this->subject->findOrFail($id);
            $subject->update($input);

            Log::info('Req=MessageController@updateSubject subject updated OK subject_id='.$id);

            return $this->api->success($request->subject);

        }
        catch (\Exception $e) {
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $message = $this->message->find($id);
            if(!$message->message_subject->participants->contains(Auth::user()->id)){
                throw new \Exception("You cannot access this conversation!");
            }

            Log::info('Req=MessageController@edit message found message_id='.$id);

            return $this->api->success($message->message_text);
        }
        catch (\Exception $e) {
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
    public function update(Request $request, $id)
    {
        $error_response = $this->api->validator($request->all(), [
            'message_text' => 'required|string|max:5000'
        ]);
        if ($error_response) return $error_response;

        try {
            $input = $request->all();
            $message = $this->message->findOrFail($id);
            $message->update($input);

            Log::info('Req=MessageController@update message updated OK message_id='.$id);

            return $this->api->success($message->message_text, ['id'=> $message->id, 'user' => $message->user->name, 'avatar' => $message->user->user_detail->avatar, 'created_at' => date('l d F Y, h:i A', strtotime($message->created_at))]);
        }
        catch (\Exception $e) {
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }

    /**
     * Get intended list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserList(Request $request)
    {
        try {
            $usersList = $this->user->whereNotIn('id', $this->getReceipents($request->id))
            ->where(function ($query) use ($request) {
                $query
                ->where('username', $request->keyword)
                ->orWhere('email', $request->keyword)
                ->orWhere('name', 'LIKE', '%' . $request->keyword . '%');
            })
            ->take(30)->get();
            if(count($usersList) > 0){
                $list = array();
                foreach($usersList as $user){
                    $list[] = array('subject_id'=>$request->id, 'user_id'=>$user->id, 'name'=> $user->name, 'avatar'=> $user->user_detail->avatar);
                }

                Log::info('Req=MessageController@getUserList user list genereted subject_id='.$request->id);

                return $this->api->success('user list genereted', $list);
            }
        }
        catch (\Exception $e) {
            Log::error('Error caught msg='.$e->getMessage());
            return $this->api->fail($e->getMessage());
        }
    }

    
    /**
     * add participant.
     *
     * @return \Illuminate\Http\Response
     */
    public function addParticipant(Request $request)
    {
        $subject = $this->subject->findOrFail($request->id);
        $subject->participants()->attach($request->user);

        Log::info('Req=MessageController@addParticipant participant added OK subject_id='.$request->id);

        return redirect()->route('messages.show', $request->id)->with('success', array('Success'=>'The user has been added to this conversation!')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeReceipent($id)
    {
        $user = $this->user->findOrFail(Auth::user()->id);
        $user->message_subjects()->detach($id);

        Log::info('Req=MessageController@removeReceipent participant removed OK subject_id='.$request->id);

        return redirect()->route('messages.index')->with('success', array('Success'=>'You have removed yourself from the conversation!')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = $this->message->findOrFail($id);
        $message->delete();

        Log::info('Req=MessageController@destroy message deleted OK message_id='.$id);

        return redirect()->route('messages.show', $message->message_subject->id)->with('success', array('Success'=>'The message has been removed!'));
    }
}
