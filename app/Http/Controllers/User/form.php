<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Borrow;
class form extends Controller
{

	public function __construct()
	
    {
        $this->middleware('auth:users');
    }
	public function index()
	{
		$status = Borrow::all();
     return view('user.home.form',['status'=>$status]);
	}
	
}
