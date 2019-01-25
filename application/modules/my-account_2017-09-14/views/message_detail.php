<div class="row scroll chatelement">
     <div class="chatstyleup hidden">
                     <div class="user_a up">
                      <div class="col-md-1">
                        <img class="cover_image" src="" />
                      </div> 
                      <div class="col-md-11 dtl">
                        <span class="u_name"></span> 
                        <span class="tym"></span>
                        <div class="p">
                          <em class="message"> </em>
                        </div>
                      </div>
                    </div> 
    </div>  
   <div class="chatstyledown hidden">
                    <div class="user_b text-right ">
                      <div class="col-md-1 f_right">
                        <img class="cover_image" src="" />
                      </div> 
                      <div class="col-md-11 dtl">
                        <span class="u_name"></span> 
                        <span class="tym"></span>
                        <div class="p pull-right">

                          <em class="message"> </em>


                        </div>
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


foreach($data as $communication){
    $datetime = new DateTime($communication->messagedate);
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
                  {?>
                <div class="chatstyleup">
                     <div class="user_a up">
                      <div class="col-md-1">
                        <img class="cover_image" src="<?php echo site_url(USER_IMG_DIR.$communication->sender_image)?>" />
                      </div> 
                      <div class="col-md-11 dtl">
                        <span class="u_name"><?php echo $communication->sender_name;?></span> 
                        <span class="tym"><?php echo $ddate.' '.$time;?></span>
                        <div class="p">

                          <em class="message"><?php echo $communication->message;?>

                          </em>


                        </div>
                      </div>
                    </div> 
                </div>  
                <?php }
                
                else
                {
                
                  ?>
                    
                <div class="chatstyledown">
                    <div class="user_b text-right ">
                      <div class="col-md-1 f_right">
                        <img src="<?php echo site_url(USER_IMG_DIR.$communication->sender_image)?>" />
                      </div> 
                      <div class="col-md-11 dtl">
                        <span class="u_name"><?php echo $communication->sender_name;?></span> 
                        <span class="tym"><?php echo $ddate.' '.$time;?></span>
                        <div class="p pull-right">

                          <em class="message"><?php echo $communication->message;?>
                          </em>


                        </div>
                      </div>
                    </div>  
                </div>  
                    <?php                    
                }
              }
          }
                ?>



 </div>
<!--  <form name="send_message" id="send_message" method="post">
<div clas="row">
<div class="col-sm-10">

<input  type="hidden" id="htmltype" value="<?php echo $type;?>">
  <textarea name="message" id="message" class="form-control messagecontent"  placeholder="Type message here.." rows="3"></textarea>
 </div>
 <div class="col-sm-2">
 <button data-bidid="<?php echo $bid_id;?>" class="btn-success btn btn-large messagesend" style="margin-top:20px;">Send</button><div class="error_message text-danger"></div>
 </div>
</div>
</form> -->
 
