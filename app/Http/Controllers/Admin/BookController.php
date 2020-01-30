<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Validator;
use Response;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        if(request()->ajax()) {
            return Datatables::of($books)
                ->addColumn('action', 'home.bookaction')
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('home.books',[
            'storeBook' => 'admin.store',
            'createUser' => 'admin.users',
            'createBook' => 'admin.books'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'id'=>'',
            'bookcode' => 'required',
            'title'=>'required',
            'writer'=>'required',
            'year'=>'required',
            'stock'=>'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $id = $request->id;
        Book::updateOrCreate(['id'=>$id],['bookcode'=>$request->bookcode,'title'=>$request->title,  'writer'=>$request->writer, 'year'=> $request->year, 'stock'=>$request->stock]);

        return Response::json(['success' => 'Telah Ditambahkan.']);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

        $books  = Book::where('id',$id)->first();
      
        return Response::json($books);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::where('id',$id)->delete();
        return Response::json($book);
    }
}
