    <div class="col-md-8 col-sm-7">

            	<div class="log-form">

                    <form method="post" action="" enctype="multipart/form-data">

                    <div class="row">

                    	<div class="col-md-6">  

                               	

    						
                                        


                                <?php if($this->session->flashdata('success_message')) { ?>

                            <div class="alert alert-success fade in">
        
                              <strong>Success!</strong> <span class="text-success"><?php echo $this->session->flashdata('success_message'); ?></span>

                             </div>


                        
                    <?php  } else if($this->session->flashdata('error_message')) { ?>
                    <div class="alert alert-danger fade in">
        
        <strong>Error!</strong> <span class="text-danger"><?php echo $this->session->flashdata('error_message'); ?></span>

    </div>

                        
                        

                    <?php } ?>
                    <!-- <pre>
                        <?php //print_r($product_name);?>
                    </pre> -->
                    <h4 style="text-transform:capitalize;">Invite Supplier to the Auction: <?php if(isset($product_name)){echo $product_name->name;}?></h4>

    						<div class="form-group">

                            <label><em>*</em> Email</label>

    						<input type="text" name="user_email" class="form-control" >

                            <?php echo form_error('user_email'); ?>                        

    						</div>

                         	<div class="form-group">

                            <label><em>*</em>Covering Note</label>

    						<textarea name="message" class="form-control" rows="4"></textarea>

                            <?php echo form_error('message'); ?>

    						</div>

                   		    <button type="submit" name="button" class="btn">Send</button>     

                    	    <div class="clearfix"></div>

                            <b>(<em>*</em> ) is mandatory field.</b>                     

                        </div>

                        <div class="col-md-6 send_invite">

                        	<h4>Sent Invites</h4>

                            <div class="row">

                            <?php 

                                    foreach ($invitedaccounts as $key => $value) { ?>

                            	<div class="col-md-8">

                                	<?php

                                        $datetimeinvite = new DateTime($value['invite_date']);

                                        $date = $datetimeinvite->format('Y-j-n');

                                        $time = $datetimeinvite->format('H:i');

                                        echo '<em>'.$value['user_email'].'</em>';?>

                                        <p><?php echo $date;?><span><?php echo $time;?></span></p>

                                   

                                     

                                    

                                </div>

                                 <div class="col-md-4"><a href="<?php echo site_url('/'.MY_ACCOUNT.'resend_email_invitation/'.$value['id']);?>" class="btn btn_resend">Resend</a></div>

                                <?php 

                                    }

                                    ?>

                               

                            </div>

                          

                        </div>

                    </div>

                	</form>

                </div>

            </div>

            