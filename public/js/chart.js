$(document).on('click','#show',function(){
    $.ajax({
           type: 'GET',
            url: path_chart_user,
            data: {year : $('#year').val()},
            dataType: "json",
            success: function (data) {
                    if(data.mes==null){
                        $('#user').html("");
                        Morris.Bar({
                            element: 'user',
                            data: data,
                            xkey: 'created',
                            ykeys: ['userid'],
                            labels: [quantity_user],
                            hideHover: 'auto',
                            resize: true
                    });
                    } else {
                        $('#user').html("");                    
                        $('#user').html(data.mes);
                    }
                
            },
            error: function (data) {
                alert('Error:',data);
            }
  });
});
$(document).on('ready',function(){
    $.ajax({
           type: 'GET',
            url: path_chart_borrow,
            data: {yearborrow : year,monthborrow: month},
            dataType: "json",
            success: function (data) {
                    $('#chart').html("");
                    Morris.Bar({
                        element: 'chart',
                        data: data,
                        xkey: 'datecreate',
                        ykeys: ['quantitys','total'],
                        labels: [borrow,quantity],
                        hideHover: 'auto',
                        resize: true
                    });
                
            },
            error: function (data) {
                alert('Error:',data);
            }
  });
});
$(document).on('click','#showborrow',function(){
    $.ajax({
           type: 'GET',
            url: path_chart_borrow,
            data: {yearborrow : $('#yearborrow').val(),monthborrow: $('#monthborrow').val()},
            dataType: "json",
            success: function (data) {
                if(data.mes==null){
                    $('#chart').html("");
                    Morris.Bar({
                        element: 'chart',
                        data: data,
                        xkey: 'datecreate',
                        ykeys: ['quantitys','total'],
                        labels: [borrow,quantity],
                        hideHover: 'auto',
                        resize: true
                    });
                } else {
                    $('#chart').html("");                    
                    $('#chart').html(data.mes);
                }
                
            },
            error: function (data) {
                alert('Error:',data);
            }
  });
});