@extends('layouts.app')

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
                    <button type="button" name="create_record" id="addBook" class="btn btn-success btn-sm">Tambah Buku</button>
                     <div class="table-responsive">
                        <table  class="table table-striped table-bordered table-hover" id="books-table">
                            <thead>
                                <tr>
                                  <th style="text-align: center;">Id</th>
                                    <th style="text-align: center;">Kode Buku</th>
                                    <th style="text-align: center;">Judul</th>
                                    <th style="text-align: center;">Penulis</th>
                                    <th style="text-align: center;">Tahun</th>
                                    <th style="text-align: center;">Stok</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                                
                            </thead>
                            
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div id="formModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tambah Buku Baru</h4>
        </div>
        <div class="modal-body">
         <span id="form_result"></span>
         <form id="registBookForm" class="form-horizontal">
          <input type="hidden" name="id" id="id">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4" >Kode Buku: </label>
            <div class="col-md-8">
             <input type="text" name="bookcode" id="code" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Judul: </label>
            <div class="col-md-8">
             <input type="text" name="title" id="title" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Penulis: </label>
            <div class="col-md-8">
             <input type="text" name="writer" id="writer" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Tahun: </label>
            <div class="col-md-8">
             <input type="year" name="year" id="year" class="form-control" />
            </div>
           </div><div class="form-group">
            <label class="control-label col-md-4">Stok: </label>
            <div class="col-md-8">
             <input type="number" name="stock" id="stock" class="form-control" />
            </div>
           </div>
                <br />
                <div class="form-group" align="center">
                 
                 <input type="submit" name="btn_save" id="btn_save" class="btn btn-warning" value="Add" />
                </div>
         </form>
        </div>
     </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

$(document).ready(function() {
$.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
    $('#books-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.books') !!}',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'bookcode', name: 'bookcode'},
            { data: 'title', name: 'title' },
            { data: 'writer', name: 'writer' },
            { data: 'year', name: 'year' },
            { data: 'stock', name: 'stock' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
    $('#addBook').click(function(){
        $('#btn-save').val("create-book");
        $('#id').val('');
        $('#action').val('Add');
        $('#registBookForm').trigger("reset");
        $('#form_result').html("");
        $('#formModal').modal('show');
     });

     $('body').on('click', '.editBook', function () {
      var code = $(this).data('id');
      var title = "Edit Buku";
      $.get('/admin/book/' + code +'/edit', function (data) {
          $('.modal-title').html(title);
          $('#btn-save').val("edit-product");
          $('#formModal').modal('show');
          $('#book').val(data.bookcode);
          $('#title').val(data.title);
          $('#writer').val(data.writer);
          $('#year').val(data.year);
          $('#stock').val(data.stock);
      })
   });
 
    $('body').on('click', '#deleteBook', function () {
  
        var del = $(this).data("id");
        
        if(confirm("Are You sure want to delete !")){
          $.ajax({
              type: "get",
              url:"/admin/book/deleteBook/"+del,
              success: function (data) {
              var oTable = $('#books-table').dataTable(); 
              oTable.fnDraw(false);
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        }
    }); 

});

if ($("#registBookForm").length > 0) {
      $("#registBookForm").validate({
  
     submitHandler: function(form) {
    var actionType = $('#btn-save').val();
     
      $('#btn-save').html('Sending..');
     
      $.ajax({
          data: $('#registBookForm').serialize(),
          url:  '{{url('/admin/book/storeBook')}}',
          type: "POST",
          dataType: 'json',
          success: function (data) {
  
              $('#registBookForm').trigger("reset");
              $('#formModal').modal('hide');
              $('#btn-save').html('Save Changes');
              var oTable = $('#books-table').dataTable();
              oTable.fnDraw(false);
               
          },
          error: function (data) {
              console.log('Error:', data);
              $('#btn-save').html('Save Changes');
          }
      });
    }
  })
}

</script>
@endpush
