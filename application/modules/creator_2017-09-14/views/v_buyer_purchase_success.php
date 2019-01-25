<div class="mid_part">
  <div class="container">
    <div class="white_box cms_sec">
    	<div class="cms_ttl"><?php if($status=='Completed') echo "<div class='alert alert-success fade in'>
    
    <strong>Payment Successful</strong></div>";
    								else echo "Transaction Failure"; ?>
    	</div>
       <p><?php if($status=='Completed') echo "<div class='alert alert-success fade in'>
    
    Your transaction is completed and membership package is also upgraded.
</div>";
       			else echo "<div class='alert alert-danger fade in'>
    
    <strong>Error!</strong> Your transaction could not be completed
</div>";
       			?> 
					
       			</p>
       			<?php if($status=='completed'){ ?><button type="button" class="btn btn-success">View Detail</button><?php } ?>
	</div>
    </div>
  <div class="clearfix"></div>
</div>
