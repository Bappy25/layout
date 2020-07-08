<?php

namespace App\Http\Controllers\Backend;

use Log;
use Auth;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    protected $user;
    protected $detail;

    function __construct(User $user, UserDetail $detail)
    {
        $this->middleware('auth.back');
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
        Log::info('UserController.index Request=User_list called');

        $search = $request->search;
        $users = $this->user->search($search)->orderBy('created_at', 'desc')->paginate(10);

        Log::info('UserController.index Success=User_list created OK');

        return view('backend.users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::info('UserController.index Request=User_create called');

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

        \Log::info('UserController.store Success=User added OK');

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
        Log::info('UserController.index Request=User_show called user_id='.$id);

        $user = $this->user->findOrFail($id);
        return view('backend.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Log::info('UserController.edit Request=User_edit called user_id='.$id);

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
        $input = $request->all();
        if($request->password){
            $input['password'] = bcrypt($request->password);
        }
        $user->update($input);

        $detail = $this->detail->where('user_id', $id)->first();
        $detail->contact = $request->contact;
        $detail->gender = $request->gender;
        $detail->dob = date('Y-m-d', strtotime($request->dob));
        $detail->address = $request->address;
        $detail->save();   

        \Log::info('UserController.update Success=User updated OK');

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

        \Log::info('UserController.delete Success=User deleted OK');

        return redirect()->route('back.users.index')->with('warning', array('User has been removed!'=>''));
    }
}
