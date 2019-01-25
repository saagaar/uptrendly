  function verifyaction(){

        if(confirm('Are you sure you want to perform this action?'))

        {

            return true;

        }else

        {

            return false;

        }

    }



    $(function(){

         $(document).on({

            mouseleave:function(){

                 $('.ratestar').each(function(i,v){

                    $(this).removeClass('rate-tempactive');

                   });

            },

            mouseenter:function(){

                 $('.ratestar').each(function(i,v){

                    $(this).removeClass('rate-tempactive');

                   });

                 var clickbtn=$(this).attr('id');

                 var result=clickbtn.split('-');

                for(var j = 1; j <=parseInt(result); j++) {

                    $('#'+j+'-rate').addClass('rate-tempactive');

                }

            },

            click:function(){

            var cur  =$(this);

                $('.ratestar').each(function(i,v){

                    $(this).removeClass('rate-active');

                    $(this).removeClass('rate-tempactive');

                    $(this).removeClass('rate-final');

                   });

                 var clickrate=$(this).attr('id');

                 cur.addClass('rate-final');

                 var result=clickrate.split('-');

                for(var n = 1; n <=parseInt(result[0]); n++) {

                    $('#'+n+'-rate').addClass('rate-active');

                }

            }

         },'.ratestar');



        $('.ratingsubmit').click(function(e){

            e.preventDefault();
            var comment= $('.comment').val()

            var ratefin=$('.rate-final').attr('id');

            var result=ratefin.split('-');

            var touser=$('#touser').val();

            var fromuser=$('#fromuser').val();

            var product_id=$('#product_id').val();

            var urlsave=$('.saverating').attr('action');

           $.ajax({

                url:urlsave,

                method:"POST",

                dataType:"json",

                data:{ rate:result[0],comment: comment,touser:touser,fromuser:fromuser,product_id:product_id },

                success:function(msg){

                   

                    if(msg.success){

                         $('#myModal').modal('toggle');

                         $('.successinfo').show();

                         $('.successinfo').html(msg.success);

                          setTimeout(function(){

                                $('.successinfo').html('').hide();

                          },5000);

                    }else{

                         $('.errorinfo').show();

                        $('.errorinfo').html(msg.error);

                        setTimeout(function(){

                                $('.errorinfo').html('').hide();

                          },5000);



                    }



                }



           })

        });

    $('.clickmodalrate').click(function(e){

        e.preventDefault();

        $('#myModal').modal();

       $('.ratestar').each(function(i,v){

                    $(this).removeClass('rate-active');

                    $(this).removeClass('rate-tempactive');

                    $(this).removeClass('rate-final');

                   });

       $('.comment').html('');

       var fromuser=$(this).data('sendfrom');

        var sendto=$(this).data('sendto');

        var productid=$(this).data('productid');

        $('#touser').val(sendto);

        $('#product_id').val(productid);
        var getdataurl=$(this).data('getdata');
        $.ajax({

                url:getdataurl,

                method:"POST",

                dataType:"json",

                data:{ touser:sendto,fromuser:fromuser,product_id:productid },

                success:function(msg){



                    if(msg.to_user_id)

                    {

                        

                         $('.comment').val(msg.comment);

                          for(var j = 1; j <=parseInt(msg.overall_rating); j++) {

                                  $('#'+j+'-rate').addClass('rate-active');

                             }



                    }

          }

        });



    })

    })