<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Yajra\Datatables\Datatables;
use Validator;
use Illuminate\Support\Facades\Hash;
use Response;

class DashboardController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home.index',[
            'title' => 'Login',
            'createUser' => 'admin.users',
            'createBook' => 'admin.books'
        ]);
    }


    public function showUser($value='')
    {
    	$users = User::select('id','name', 'email', 'phoneNumber');
    	if(request()->ajax()) {
        return Datatables::of($users)
            ->addColumn('action', 'home.action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
    	return view('home.users',[
    		'storeUser' => 'admin.storeUser',
    		'createUser' => 'admin.users',
    		'createBook' => 'admin.books'

    	]);
    }

    public function storeUser(Request $request)
    {
    	$rules = array(
    		'id' => '',
            'email'=>'required',
            'password'=>'required',
            'name'=>'required',
            'phoneNumber'=>'required'

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $Id = $request->id;
        User::updateOrCreate(['id' => $Id],
        	['name'=>$request->name,  'email'=>$request->email, 'password'=> Hash::make($request->password), 'phoneNumber'=>$request->phoneNumber ]);

        return response()->json(['success' => 'Telah Ditambahkan.']);
    }

    public function edit($id)
    {
       $where = array('id' => $id);
	    $users  = User::where($where)->first();
	  
	    return Response::json($users);
    }


    public function destroy($id)
    {
        $user = User::where('id',$id)->delete();
    	return Response::json($user);
    }

}
