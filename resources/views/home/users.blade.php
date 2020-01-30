@extends('layouts.app')

@section('title', 'Main page')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Data Anggota Perpustakaan</h5>
                </div>
                <div class="ibox-content">
                    <button type="button" name="create_record" id="addUser" class="btn btn-success btn-sm">Tambah Anggota</button>
                     <div class="table-responsive">
                        <table  class="table table-striped table-bordered table-hover" id="users-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Id</th>
                                    <th style="text-align: center;">Nama</th>
                                    <th style="text-align: center;">Email</th>
                                    <th style="text-align: center;">No.Hp</th>
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
          <h4 class="modal-title">Tambah Anggota Baru</h4>
        </div>
        <div class="modal-body">
         <span id="form_result"></span>
         <form id="registrationForm" class="form-horizontal">
            <input type="hidden" name="id" id="id">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4" >Nama: </label>
            <div class="col-md-8">
             <input type="text" name="name" id="name" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Email: </label>
            <div class="col-md-8">
             <input type="email" name="email" id="email" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Password: </label>
            <div class="col-md-8">
             <input type="password" name="password" id="password" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">No. HP: </label>
            <div class="col-md-8">
             <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" />
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
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.users') !!}',
        columns: [
            {data: 'id', name: 'id'},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phoneNumber', name: 'phoneNumber' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
    $('#addUser').click(function(){
        $('#btn-save').val("create-user");
        $('#id').val('');
        $('#action').val('Add');
        $('#registrationForm').trigger("reset");
        $('#form_result').html("");
        $('#formModal').modal('show');
     });

     $('body').on('click', '.editUser', function () {
      var user_id = $(this).data('id');
      var title = "Edit Anggota";
      $.get('/admin/user/' + user_id +'/edit', function (data) {
          $('.modal-title').html(title);
          $('#btn-save').val("edit-product");
          $('#formModal').modal('show');
          $('#id').val(user_id);
          $('#name').val(data.name);
          $('#email').val(data.email);
          $('#phoneNumber').val(data.phoneNumber);
      })
   });
 
    $('body').on('click', '#deleteUser', function () {
  
        var del = $(this).data("id");
        
        if(confirm("Are You sure want to delete !")){
          $.ajax({
              type: "get",
              url:"/admin/user/deleteUser/"+del,
              success: function (data) {
              var oTable = $('#users-table').dataTable(); 
              oTable.fnDraw(false);
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        }
    }); 

});

if ($("#registrationForm").length > 0) {
      $("#registrationForm").validate({
  
     submitHandler: function(form) {
    var actionType = $('#btn-save').val();
     
      $('#btn-save').html('Sending..');
     
      $.ajax({
          data: $('#registrationForm').serialize(),
          url:  '{{url('/admin/user/storeUser')}}',
          type: "POST",
          dataType: 'json',
          success: function (data) {
  
              $('#registrationForm').trigger("reset");
              $('#formModal').modal('hide');
              $('#btn-save').html('Save Changes');
              var oTable = $('#users-table').dataTable();
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
