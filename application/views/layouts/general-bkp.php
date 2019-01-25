<?php $this->load->library('general'); ?>
<?php
	//check cookie
	if(!$this->session->userdata(SESSION.'user_id'))
	{
		if(isset ($_COOKIE['email']) && $_COOKIE['email']!='' && isset($_COOKIE['password']) && $_COOKIE['password']!='')
		{
		//login by cookie value
			$this->general->check_login_process($_COOKIE['email'],$_COOKIE['password']);
			//echo "<pre>"; print_r($_COOKIE); echo "</pre>"; exit;
		}
	}

	//load header
	$this->load->view('common/header');
	
	//load static banner if it is to be place in page
	if(isset($static_banner) && $static_banner=='yes'){
		$this->load->view('common/static_banner');
	}
?>

<section class="breadcrumb_sec">
  <div class="container">
  	<?php echo $this->breadcrumbs->show(); ?>
   <?php if($this->session->userdata(SESSION.'user_id') && $this->router->fetch_class()=='user' && isset($user_type) && $user_type=='seller'){ ?>
    <div class="pull-right btn-breadcrum">
          <span class="btn-green">
                <a href="<?php echo site_url('/'.MY_ACCOUNT.'add_inventory_item'); ?>">List an Item</a>
         </span>
          <span class="btn-gray">
                <a href="<?php echo site_url('/'.MY_ACCOUNT.'host_an_auction'); ?>">Host an Auction</a>
          </span>
        </div>
    <?php } ?>
    
    </div>
  <div class="clearfix"></div>
</section>


<section class="mid_part common-error">
    <div class="container">
    	<div class="error_message text-center">
        <div class="alert alert-danger alert-dismissible" role="alert" style="display:none;" id="errorSuccessMesageArea">
        	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            	<span aria-hidden="true">&times;</span>
          	</button>
            <div id="errorSuccessMesage"><!--Error/Success Message--></div>
        </div>
         
        <?php if($this->session->flashdata('success_message')){ ?>
         	<div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
                <div><?php echo $this->session->flashdata('success_message'); ?></div>
        	</div>
        <?php }else if($this->session->flashdata('error_message')){ ?>
         	<div class="alert alert-success alert-dismissible" role="alert">
            	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
            	</button>
            	<div><?php echo $this->session->flashdata('success_message'); ?></div>
         	</div>
		<?php } ?>
    </div>
    </div>
</section>



<?php if(($this->router->fetch_class()=='home' && $this->router->fetch_method()=='auctions') OR ($this->router->fetch_class()=='users' && ($this->router->fetch_method()=='index' OR $this->router->fetch_method()=='host_auction_detail'))){ ?>
	<?php echo $template['body']; ?>
<?php }else{ ?>
<section class="mid_part content_sec">
    <div class="container">
   	<?php if($this->session->userdata(SESSION.'user_id') && $this->router->fetch_class()=='user' && $this->router->fetch_method()!='verify_paypal'){ ?>
       	<div class="row">
        	<?php $this->load->view('common/account_left_sidebar'); ?>
            <?php echo $template['body']; ?>
        </div>
       	<?php }else{ ?>
       	<?php echo $template['body']; ?>
       	<?php } ?>
    </div>
    <div class="clearfix"></div> 
</section>
<?php } ?>




<!--Load how it works static content if it is to be loaded-->
<?php
	if(isset($how_it_works) && $how_it_works=='yes'){
		$this->load->view('common/how_it_works');
	}
?>

<!--load footer-->
<?php echo $this->load->view('common/footer');?>