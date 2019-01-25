
 <?php  


if((($message)))
{

 foreach($message as $messagedetail){
    $class='';
    
  if($messagedetail->ismsgseen=='0'){
    $class="unseenmsg";
  }
  ?>
                         <tr data-view="<?php echo $view;?>" data-productid="<?php echo $messagedetail->product_id;?>" class="msglist <?php echo $class;?> clickablemessagedetail">
                           
                                  
                                <td width="5%"><input type="checkbox"></td>
                                <td width="35%" class="relative"><a href="#open_msz" data-toggle="tab"> <?php echo 'admin'?><?php if($class=='unseenmsg' && $view=='inbox'){?><span class="new_msg">New</span> <?php } ?></a>
                                </td>
                                <td width="60%"><b> <a href="#open_msz" data-toggle="tab">   <?php echo substr($messagedetail->message,0,50).'...';?></a></b></td>
                                
</a>
                            </tr>
 <?php               } 
}else{
    ?>
  <tr>  <td colspan="3"><?php echo 'No Records found';?></td></tr>
    <?php 
}
?>
