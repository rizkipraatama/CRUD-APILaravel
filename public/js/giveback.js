$('#rowBook').hide();

$(document).ready(function() {

    $.getJSON( pathjsongiveback, function(data) {
        borrows = data;
    });
    $('#add_button').on('click', function(e) {
        e.preventDefault();
        var request = $('#bookid').val();
        var array = $('tr');
        var error = "";
        var flag = 0;
        if (request == "") {
          error = error_null;
        }
        array.each(function(){
        if ($(this).attr('id') == request) {
          error = error_exist;
          }
        });
        if (error == "") {
        for(i=0; i < borrows.length; i++){
           if ((request == borrows[i].book_item_id)) { 
            var newRow = $('#rowBook').clone(true).attr({'id': borrows[i].book_item_id, 'style': 'display: '}).appendTo('#list-add');
            newRow.find('td:nth-child(1)').html(borrows[i].borrow_id);
            newRow.find('td:nth-child(2)').html(borrows[i].fullname);
            newRow.find('td:nth-child(3)').html(borrows[i].name);
            newRow.find('#borrowdetail_id').attr('value', borrows[i].id);
            newRow.find('#borrow_id').attr('value', borrows[i].borrow_id);
            break; 
            } else {
              flag++;
            }
          }
        }
        if (flag == borrows.length) {
          error = error_notexist;
        }
        $('#errors').html(error);      
    });
    
    $(btn_remove).on("click", function(e) {
        e.preventDefault(); 
        $(this).parent().parent().remove();
    });
    $('#btn_submit').on("click", function(e){
      e.preventDefault();
      var count = 0;
      var data_borrow_detail = [];
      var data_borrow = [];
      var borrow_detail_id = [];
      var borrow_id = [];
    $('#rowBook').remove();
    $("input:hidden[name*='item']").each(function() {
      borrow_detail_id.push($(this).val());
    });
    $("input:hidden[name*='borrowid']").each(function() {
      borrow_id.push($(this).val());
    }); 
    for(i=0; i < borrows.length; i++) {
      data_borrow_detail.push(borrows[i].id);
      data_borrow.push(borrows[i].borrow_id);
    }
    for(i=0; i < borrow_id.length; i++) {
      if((data_borrow_detail.indexOf(parseInt(borrow_detail_id[i])) == -1) || (data_borrow.indexOf(parseInt(borrow_id[i])) == -1)) {
        break;
      } else {
        count++;
      }
    }
    if(count == (borrow_id.length)) {
      $(this.form).submit();
    } else {
      $('#error_submit').html(error_notexist);
    }
  });
});
