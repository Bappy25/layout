<?php

namespace App\Http\Controllers\Backend;

use Log;
use App\Models\User;
use App\Models\UserDetail;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $api;
    protected $user;
    protected $detail;

    function __construct(User $user, UserDetail $detail, ApiHelper $api)
    {
        $this->middleware('auth.back');
        $this->api = $api;
        $this->user = $user;
        $this->detail = $detail;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Log::info('Req=UserController@index called');

        $search = $request->search;
        $users = $this->user->search($search)->orderBy('created_at', 'desc')->paginate(10);
        return view('backend.users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::info('Req=UserController@index called');

        $user = $this->user;
        return view('backend.users.form', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $input['email_verified_at'] = date('Y-m-d H:i:s');
        $input['user_id'] = $this->user->create($input)->id;
        $this->detail->create($input);

        Log::info('Req=UserController@store Success=User added OK');

        return redirect()->route('back.users.show', $input['user_id'])->with('success', [ 'Success' => 'New user has been added!' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('Req=UserController@index called user_id='.$id);

        $user = $this->user->findOrFail($id);
        return view('backend.users.show', compact('user'));
    }

    /**
     * Update user image.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateImage(Request $request, $id)
    {
        $error_response = $this->api->validator($request->all(), [
            'image' => 'required|image|dimensions:min_width=100,min_height=200|max:1000'
        ]);
        if ($error_response) return $error_response;

        try {
            $user = $this->detail->where('user_id', $id)->firstOrFail();
            $path = $this->uploadImage($request->file('image'), 'all_images/user_images/', 300, 300);
            $user->avatar = $path;
            $user->save();

            Log::info('Req=UserController@updateImage Success=Image updated OK');

            return $this->api->success('Image has been successfully updated!');
            
        }catch(\Exception $e){
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
        Log::info('Req=UserController@edit called user_id='.$id);

        $user = $this->user->findOrFail($id);
        return view('backend.users.form', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = $this->user->findOrFail($id);
        $detail = $this->detail->where('user_id', $id)->firstOrFail();

        $input = $request->all();
        $input['dob'] = date('Y-m-d', strtotime(str_replace('/', '-', $request->dob)));
        if($request->password){
            $input['password'] = bcrypt($request->password);
        }

        $user->update($input);
        $detail->update($input);   

        Log::info('Req=UserController@update Success=User updated OK');

        return redirect()->route('back.users.show', $id)->with('success', [ 'Success' => 'User has been updated!' ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->findOrFail($id)->delete();

        Log::info('Req=UserController@delete Success=User deleted OK user_id='.$id);

        return redirect()->route('back.users.index')->with('warning', array('User has been removed!'=>''));
    }
}
