$(document).ready(function(){ 
  //datatables
  $('#list_users').DataTable();
  $('#list_books').DataTable();
  $('#list_bookitems').DataTable();
  $('#list_categories').DataTable();
  $('#list_borrows').DataTable();
  $('#list_bookborrow').DataTable( {
    "paging": false,
    "bFilter": false
  });

  //Confirm delete
  $('#confirmDelete').on('show.bs.modal', function (e) {
  	  // set message
      $message = $(e.relatedTarget).attr('data-message');
      $('.modal-body p').text($message);
      // set title for model
      $title = $(e.relatedTarget).attr('data-title');
      $('.modal-title').text($title);

      // Pass form reference to modal for submission on yes/ok
      var form = $(e.relatedTarget).closest('form');
      $('.modal-footer #confirm').data('form', form);
  });
 
      //Form confirm (yes/ok) handler, submits form
  $('#confirmDelete .modal-footer #confirm').on('click', function(){
      $(this).data('form').submit();
  });

  //countdown shutdown alert
  $("div.alert").delay(timeout).slideUp();
});

$('.img_upload').hide();

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image_no').show();
            $('#image_no').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#image").on('change', function(){
    readURL(this);

});

//Borrow book 
$(document).ready(function () {
    $('#rowZero').hide();

    //check user by id
    $('#check').on('click',function(e){
      e.preventDefault();
      $('#error').html("");
      $('#error').removeClass('alert-danger');
      if ($('#rowZero').next().length > 0) {
        $('.clone').each(function(index){
          $(this).remove();
        });
      }
      $('#notice').html("");
      $('#add').attr('disabled',false);
      $('#bookid').attr('disabled',false);
      $('#savelist').attr('disabled',false);
      $('#user_name').attr('value',$('form #username').val());
      $('#notice').hide();
      
      $.ajax({
        type: 'GET',
        url: path_check_user+$('form #username').val(),
        data: {username: $('form #username').val()},
        dataType: "json",
        success: function (data) {
            $('#user_notice').show();

            if(data.allow=='true'){
                $('#user_notice').attr('class','alert-info');
                $('#rowZero input').attr('value',data.user_id);
                $('#message').html(data.mes);
                $('#quantity').show();
                $('#quantitybook').html(data.quantity);
                $('#enterBook').show();
            } else if(data.allow=='false'){
                $('#user_notice').attr('class','alert-warning');
                $('#message').html(data.mes);
                $('#quantitybook').html("0");
                $('#enterBook').hide();
            } else{
                $('#user_notice').attr('class','alert-danger');
                $('#enterBook').hide();
                $('#message').html(data.mes);
                $('#quantity').hide();
            }
        }
        });   
        
    })
    //add new book to borrow list
    $('#add').on('click',function(e){
        e.preventDefault();
        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var book_id=$('form #bookid').val();
        var list_tr=$('#list-add tr');
        var error="";
        var maxBook=$('#quantitybook').text();
        var numBook=list_tr.length;
        //check maximum book to add
        if(numBook<=maxBook){
          list_tr.each(function(){
              if ($(this).attr('id')==book_id){
                  error=book_exist;
                  $('#error').attr('class','alert-danger');
                  $('#error').html(error);
              } else {
                  $('#error').html("");
              }
          });
          if(error==""){
            $.ajax({
                type: 'GET',
                url: path_add_book,
                data: {bookID: $('form #bookid').val()},
                dataType: "json",
                success: function (data) {
                    if(data.mes==null){
                        $('#error').removeClass('alert-danger');
                        var newRow=$('#rowZero').clone(true).attr({'class':'clone' ,'id': data.id,'style': 'display: '}).appendTo('#list-add');
                        newRow.find('td:nth-child(1)').html(data.bookname);
                        newRow.find('td:nth-child(2)').html(data.id);
                        newRow.find('button').attr('value',data.id);
                        newRow.find('input').attr('value', data.id);
                        newRow.find('input').attr('name',"lists_book_item[]");
                        $('#notice').hide();
                    } else{
                        $('#error').attr('class','alert-danger');
                        $('#error').html(data.mes);
                    }
                    
                },
                error: function (data) {
                    alert('Error:',data);
                }
            });
          }
        } else{
            $('#error').attr('class','alert-danger');
            $('#error').html(max_book);
        }          
    });
    // delete bookitem in list add
    $(document).on('click','.btn-delete', function(){
        var id_book = $(this).val();
        $("#"+id_book).remove();
        
    });
    //save to database
    $('#savelist').on('click',function(e){
        var list=[];
        var listdata=$('#list_books_add input');
        listdata.each(function(){
            list.push($(this).attr('value'));
        });
        e.preventDefault();
        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: path_save_borrow,
            data: {listBook: list},
            dataType: "json",
            success: function (data) {
                $('#notice').show();
                if(data.mes=="Succesful"){
                    $('#notice').html(data.mes);
                    $('#notice').attr('class', 'alert-success');
                    $('#add').attr('disabled',true);
                    $('#bookid').attr('disabled',true);
                    $('#savelist').attr('disabled',true);
                } else {
                    $('#notice').html(data.mes);
                    $('#notice').attr('class', 'alert-danger');
                }
            },
            error: function (data) {
                alert('Error:',data);
            }
        });
    });  
});
