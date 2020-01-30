<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use Yajra\Datatables\Datatables;
use Validator;
use Response;
use App\Borrow;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{

	public function __construct()
	
    {
        $this->middleware('auth:users');
    }

    public function index()
    {
        $books = Book::all();
        if(request()->ajax()) {
            return Datatables::of($books)
                ->addColumn('action', 'user.home.bookaction')
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('user.home.index');
    }

    public function edit($id)
    {
        $books  = Book::where('id',$id)->first();
        return Response::json($books);
    }

    public function store(Request $request)
    {
        $rules = array(
            'id' => 'required',
            'bookcode'=>'required',
            'title'=>'required',
            'writer'=>'required',
            'year'=>'required',
            'stock'=>'required',
            'start'=>'required',
            'returning'=>'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $userId = Auth::id();
        $response=Borrow::updatrOrCreate(['id'=>'adanjuiofa'],[
            'admin_id'=> '1',
            'user_id' => '1',
            'book_id' => '4',
            'date' => '2022-01-09',
            'returning' => '2022-01-09'
        ]);
        return Response::json($response);
    }
}
