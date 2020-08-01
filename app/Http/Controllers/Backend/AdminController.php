<?php

namespace App\Http\Controllers\Backend;

use Log;
use Auth;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    protected $admin;

    function __construct(Admin $admin)
    {
        $this->middleware('auth.back');
        $this->admin = $admin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info('Req=AdminController@index called');

        $admins = $this->admin->all();
        return view('backend.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::info('Req=AdminController@index called');

        $admin = $this->admin;
        return view('backend.admins.form', compact('admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $this->admin->create($input);

        \Log::info('Req=AdminController@store Success=Admin added OK');

        return redirect()->route('back.admins.index')->with('success', [ 'Success' => 'New admin has been added!' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('Req=AdminController@index called admin_id='.$id);

        $admin = $this->admin->findOrFail($id);
        return view('backend.admins.form', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Log::info('Req=AdminController@index called admin_id='.$id);

        $admin = $this->admin->findOrFail($id);
        return view('backend.admins.form', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, $id)
    {
        $admin = $this->admin->findOrFail($id);

        $input = $request->all();
        if($request->password){
            $input['password'] = bcrypt($request->password);
        }
        $admin->update($input);

        \Log::info('Req=AdminController@update Success=Admin updated OK');

        return redirect()->route('back.admins.index')->with('success', [ 'Success' => 'Admin has been updated!' ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->admin->findOrFail($id)->delete();

        \Log::info('Req=AdminController@delete Success=Admin deleted OK');

        return redirect()->route('back.admins.index')->with('warning', array('Admin has been removed!'=>''));
    }
}
