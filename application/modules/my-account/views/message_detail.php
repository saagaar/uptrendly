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
// print_r($data);

if(!is_array($data)){
  echo 'No Records Found';
  $type="chatstyleup";
 ?>  

<?php
}else{


foreach($data as $communication)
{

             $datetime = new DateTime($communication->messagedate);
  
                $date = $datetime->format('Y-m-d');
                $time = $datetime->format('H:i');
                if($date<date('Y-m-d')){
                  $ddate=$date;
                }else $ddate='';
                $product_id=$communication->product_id;
                        // echo $date;
                if($date==date('Y-m-d')){
                  $date='';
                }
                 $user= $data[0]->sender_id;
                if($communication->sender_id=='1')
                {
                  $sender_name='Admin';
                  $image='';
                }
                else
                {
                  $sender_name=$communication->sender_name; 
                  $image=$communication->sender_image;
                }
                $coverimage=$this->general->get_profile_image($image);
                if($user==$this->session->userdata(SESSION.'user_id')) $type="chatstyleup";
                else $type='chatstyledown';
                if($user==$communication->sender_id)
                  {?>
                <div class="chatstyleup">
                     <div class="user_a up">
                      <div class="col-md-1">
                        <img class="cover_image" src="<?php echo $coverimage?>" />
                      </div> 
                      <div class="col-md-11 dtl">
                        <span class="u_name"><?php echo $sender_name;?></span> 
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
                        <img src="<?php echo $coverimage?>" />
                      </div> 
                      <div class="col-md-11 dtl">
                        <span class="u_name"><?php echo $sender_name;?></span> 
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
 <button data-bidid="<?php echo $product_id;?>" class="btn-success btn btn-large messagesend" style="margin-top:20px;">Send</button><div class="error_message text-danger"></div>
 </div>
</div>
</form> -->
 
