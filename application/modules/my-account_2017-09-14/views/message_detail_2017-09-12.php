<script>
  var userid='<?php echo $this->session->userdata(SESSION."user_id");?>'
  var avatar='<?php echo $avatar?>';
</script>

<div class="related_btns relative"> <span class="btn_report">
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#reportModal"><i class="fa fa-exclamation-circle"></i>Report</button>
  </span> </div>
<div class="row scroll chatelement">
  <div class="chatstyleup hidden">
    <div class="user_a up">
      <div class="col-md-1"> <img class="cover_image" src="" /> </div>
      <div class="col-md-11 dtl"> <span class="u_name"></span> <span class="tym"></span>
        <div class="p"> <em class="message"> </em> </div>
      </div>
    </div>
  </div>
  <div class="chatstyledown hidden">
    <div class="user_b text-right ">
      <div class="col-md-1 f_right"> <img class="cover_image" src="" /> </div>
      <div class="col-md-11 dtl"> <span class="u_name"></span> <span class="tym"></span>
        <div class="p pull-right"> <em class="message"> </em> </div>
      </div>
    </div>
  </div>
  <?php 
// echo '<pre>';

 
if(!is_array($data)){
  echo 'No Records Found';
  $type="chatstyleup";
 ?>
  <?php
}else{
 
//   echo '<pre>';
// print_r($data);
$prevdate='';
foreach($data as $communication){

    $datetime = new DateTime($communication->messagedate);
                $coverimage=$this->general->get_profile_image($communication->sender_image);
                $date = $datetime->format('Y-m-d');
                $time = $datetime->format('H:i');
                if($date<date('Y-m-d')){
                  $ddate=$date;
                }else $ddate='';
                $bid_id=$communication->bid_id;
                        // echo $date;
                if($date==date('Y-m-d')){
                  $date='';
                }
                $user= $data[0]->sender_id;
                if($user==$this->session->userdata(SESSION.'user_id')) $type="chatstyleup";
                else $type='chatstyledown';
                if($user==$communication->sender_id)
                  {
                    $past_date
                    ?>
  <div class="chatstyleup">
    <div class="user_a up">
      <div class="col-md-1 col-xs-2 text-right"> <img class="cover_image" src="<?php echo $coverimage?>" /> </div>
      <div class="col-md-11 col-xs-9 dtl"> <span class="u_name"><?php echo $communication->sender_name;?></span>
        <?php if($prevdate!=$datetime): ?>
        <span class="tym"><?php echo $ddate.' '.$time;?></span>
        <?php endif; ?>
        <div class="p"> <em class="message"><?php echo $communication->message;?> </em> </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <?php 
                $prevdate=$datetime;
              }
                
                else
                {
                
                  ?>
  <div class="chatstyledown">
    <div class="user_b text-right">
      <div class="col-md-1 col-xs-2 f_right text-left"> <img src="<?php echo $coverimage?>" /> </div>
      <div class="col-md-11 col-xs-9 dtl f_right"> <span class="u_name"><?php echo $communication->sender_name;?></span> <span class="tym"><?php echo $ddate.' '.$time;?></span>
        <div class="p pull-right"> <em class="message"><?php echo $communication->message;?> </em> </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <?php                    
                }
              }
          }
                ?>
</div>
<form name="send_message" id="send_message" method="post">
      <input  type="hidden" id="htmltype" value="<?php echo $type;?>">
      <textarea name="message" id="message" class="form-control messagecontent"  placeholder="Type message here.." rows="3"></textarea>
      <button data-bidid="<?php echo $bidid;?>" id="globalmessagesend" class="btn btn-primary msg_input_btn messagesend" ><i class="fa fa-send"></i></button>
</form>
<div class="modal fade" id="reportModal" role="dialog">
  <div class="modal-dialog"> <!-- Modal content-->
    <form id="reportuserform" method="post" name="reportuser">
      <div class="modal-content">
        <div class="modal-header text-center">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true" class="fa fa-times"></span> </button>
          <h4 class="modal-title" id="myModalLabel">Report</h4>
          <p>Would you like to report this Creator? Please give us some information below.</p>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input name="bidid" type="hidden" value="<?php echo $bidid;?>">
            <select class="form-control" name="title" id="reporttitle">
              <option value="">Report for?</option>
              <option value="Spam">Spam</option>
              <option value="Harrassment">Harrassment</option>
              <option value="Other">Other</option>
            </select>
            <textarea class="form-control" rows="4" id="reportmessage" name="message" placeholder="Message (Optional)" maxlength="250"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="reportsubmit">
          <div class="btn-img pull-left"><div class="img-loader hidden" style="z-index:1000;"> <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>"> </div></div>
          <i class="fa fa-exclamation-circle defaultico"></i> Report </button>
          </div>
      </div>
    </form>
  </div>
</div>
<script>  
 var socket = io.connect('http://192.168.0.129:8000/');
 socket.on('connect', function(data) {
  console.log('socket connection successful');
  var bidid=$('.messagesend').data('bidid');
  /********************join chat room*************************************/
    socket.emit('connect_chat_room', 
      {
        sender_id:userid,
        bidid:bidid
      });
/********************end of joining chat room************************************/
/********************check if user already connected to chat room********************/

socket.emit('is_user_connected_already',{
          sender_id:userid,
          avatar:avatar,
          bidid:bidid
});
socket.on('already_connected',function(data){
    if(data.msg=='yes')
    {
        if(data.user_count==2)
        {
            $('.available_status').removeClass('offline');
            $('.available_status').addClass('online');
        }

          // console.log('USER Connected Already');
        //  socket.emit('user_connected_already',{
        //     sender_id:userid,
        //     avatar:avatar,
        //     bidid:bidid
        // });
    }
    if(data.msg=='no')
    {
  /**********************connecting user to room***********************************/
       /*Display users online or offline*/
        if(data.user_count==1)
        {
            $('.available_status').removeClass('offline');
            $('.available_status').addClass('online');
        }
        socket.emit('connect_user_to_chatroom',
        {
          sender_id:userid,
          avatar:avatar,
          bidid:bidid
        });

    }
  })
/**********************End of connecting user to room******************************/



/***************In case user not permitted to access chat room******************/
   socket.on('chat_init_error',function(data){
    $('.pop_error').removeClass('hidden');
    $('.pop_error').addClass('error');
    $('.pop_error_container').html(data.error_message);
     setTimeout(function(){
       $('.pop_error').addClass('hidden');
       $('.pop_error').removeClass('error');
       $('.pop_error').removeClass('success');
       $('.pop_error_container').html('');
      },3000);
      });
 /***************End of case user not permitted to access chat room*****************/

 /********************On user disconnection**************************************/
  socket.on('disconnect', function(){
    console.log('user disconnected');
  });
  /**************************End of user Disconnection***********************************/
  /*Triggers on clicking message send */
  // $(function(){

  
  
    // $(document).off('click','.messagesend');
 
     socket.on('available_status_remove',function(data){ 
            $('.available_status').addClass('offline');
            $('.available_status').removeClass('online');
    });
    socket.on('user_status_available',function(data){ 
            $('.available_status').removeClass('offline');
            $('.available_status').addClass('online');
    })

   
 
 

});

 socket.on('message_sent',function(data){
    console.log(userid+'-->'+data.sender_id);
    if(userid==data.sender_id) htmlsamp='chatstyleup';
    else htmlsamp='chatstyledown';
    console.log(htmlsamp);
       // var htmlsamp=$('#htmltype').val();
    $additionhtml=$('.'+htmlsamp).first().clone().appendTo('.chatelement');;
                                // $('.error_message').removeClass('hidden');
                                $additionhtml.removeClass('hidden');
                                $additionhtml.find('.message').html(data.message);

                                // $additionhtml.find('.tym').html(datat.data.messagedate);
                                $additionhtml.find('.u_name').html(data.name);
                                $additionhtml.find('.cover_image').attr('src',data.avatar);
                                var abc=$(".scroll").prop('scrollHeight');
                              $(".scroll").scrollTop(abc);
  });

   /*************************End of socket connect function**************************/

</script> 
<script type="text/javascript">
   var sendmessage='<?php echo site_url('/'.MY_ACCOUNT.'send_message');?>';
   var reportuser='<?php echo site_url('/'.MY_ACCOUNT.'reportuser');?>'
 </script> 
