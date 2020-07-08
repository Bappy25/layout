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
    public function index(Request $request)
    {
        Log::info('AdminController.index Request=Admin_list called');

        $admins = $this->admin->search($request->search)->orderBy('created_at', 'desc')->paginate(20);

        Log::info('AdminController.index Success=Admin_list created OK');

        return view('backend.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::info('AdminController.index Request=Admin_create called');

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

        \Log::info('AdminController.store Success=Admin added OK');

        return redirect()->route('admins.index')->with('success', [ 'Success' => 'New admin has been added!' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('AdminController.index Request=Admin_show called admin_id='.$id);

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
        Log::info('AdminController.index Request=Admin_edit called admin_id='.$id);

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
        $input = $request->all();
        if($request->password){
            $input['password'] = bcrypt($request->password);
        }
        $this->admin->update($input);

        \Log::info('AdminController.store Success=Admin added OK');

        return redirect()->route('admins.index')->with('success', [ 'Success' => 'New admin has been added!' ]);
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

        \Log::info('AdminController.delete Success=Admin deleted OK');

        return redirect()->route('admins.index')->with('warning', array('Admin has been removed!'=>''));
    }
}
