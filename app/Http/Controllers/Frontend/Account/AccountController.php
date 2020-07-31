<?php

namespace App\Http\Controllers\Frontend\Account;

use Log;
use Auth;
use App\Models\User;
use App\Models\UserDetail;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
	protected $api;
    protected $user;
    protected $detail;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user, UserDetail $detail, ApiHelper $api)
    {
        $this->middleware(['auth', 'verified']);
        $this->api = $api;
        $this->user = $user;
        $this->detail = $detail;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info('Req=AccountController@index called');
		$id = Auth::user()->id;
        $user = $this->user->findOrFail($id);
        return view('frontend.account.profile', compact('user'));
    }

    /**
     * Update user image.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateImage(Request $request)
    {
        Log::info('Req=AccountController@updateImage called');

        $this->api->validator($request->all(), [
            'image' => 'required|image|dimensions:min_width=100,min_height=200|max:1000'
        ]);

        try {
			$id = Auth::user()->id;
            $user = $this->detail->where('user_id', $id)->firstOrFail();
            $path = $this->uploadImage($request->file('image'), 'all_images/user_images/', 300, 300);
            $user->avatar = $path;
            $user->save();
            return $this->api->success('Image has been successfully updated!');

        }catch(\Exception $e){
            return $this->api->fail($e->getMessage());
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        Log::info('Req=AccountController@edit called');

		$id = Auth::user()->id;
        $user = $this->user->findOrFail($id);
        return view('frontend.account.form', compact('user'));
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
		$id = Auth::user()->id;
        $user = $this->user->findOrFail($id);
        $detail = $this->detail->where('user_id', $id)->firstOrFail();

        $input = $request->all();
        $input['dob'] = date('Y-m-d', strtotime(str_replace('/', '-', $request->dob)));
        if($request->password){
            $input['password'] = bcrypt($request->password);
        }

        $user->update($input);
        $detail->update($input);   

        \Log::info('Req=AccountController@update Success=User updated OK');

        return redirect()->route('account.index', $id)->with('success', [ 'Success' => 'User has been updated!' ]);
    }
}
