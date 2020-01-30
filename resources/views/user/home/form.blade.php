@extends('user.layouts.app')

@section('title', 'Main page')

@section('content')
   <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Data Buku</h5>
                </div>
                <div class="ibox-content">
                    @csrf
                     <div class="table-responsive">
                        <table  class="table table-striped table-bordered table-hover" id="books-table">
                            <thead>
                                <tr>
                                  <th style="text-align: center;">Id</th>
                                    <th style="text-align: center;">admin_id</th>
                                    <th style="text-align: center;">user_id</th>
                                    <th style="text-align: center;">buku_id</th>
                                    <th style="text-align: center;">date</th>
                                    <th style="text-align: center;">return</th>
                                    <th style="text-align: center;">approve</th>
                                </tr>
                                @foreach($status as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->admin_id }}</td>
                                <td>{{ $p->user_id }}</td>
                                <td>{{ $p->book_id }}</td>
                                <td>{{ $p->date }}</td>
                                <td>{{ $p->returning }}</td>
                                <td>{{ $p->isApproved }}</td>
                            </tr>
                            @endforeach
                            </thead>
                            
                        </table>
                    </div>
                </div>
            </div>
             
        </div>
    </div>
    </div>
    @endsection
