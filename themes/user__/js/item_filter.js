
    

  $('.sort_item').on('click', function(){

    var val=$(this).val();
     var cat=$('#cat').val();
     var subcat=$('#subcat').val();

     submitValues(val, cat, subcat);

     $('.sort_item').removeClass('active');
     $(this).addClass('active');

     
  });

  function addCategory (name, cat, subcat) {
    var id = (subcat != 0 && subcat != 'undefined') ? subcat : cat;
   $('#cat').val(cat);
   $('#subcat').val(subcat);
   $('#hiddenCatField').val(id);
   $('#hiddenCatName').val(name);
   $('#chooseCategory').html(name + '<span class="fa fa-angle-down"></span>');
  // $('#filter-form').submit();
  var order = $('.sort_item.active').val();
  if(order == undefined){
    order == '';
  }

   submitValues(order, cat, subcat);
 }

 //summit values 
 function submitValues(order, cat, subcat){
  $.ajax({
            url:BASE_URL+"my-account/filtered_item",
            type: 'POST',
            dataType: 'html',
            data : {order_data : order, cat:cat,subcat:subcat },
            success: function (data) {
                //console.log(data);
                $('#f_content').html('');
                $('#f_content').html(data);
            },
            error : function(error) {
                console.log(error);
            },
          
        });
 }
 