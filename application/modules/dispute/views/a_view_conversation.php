
<section class="title">

<div class="wrap">
  <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Post Management</h2>
</div>
</section>
<article id="bodysec" class="sep">
  <div class="wrap">
    <aside class="lftsec">
      <?php $this->load->view('menu'); ?>
    </aside>
    <section class="smfull">
      <div class="confrmmsg">
        <?php	

			if($this->session->flashdata('message') != ''){
				echo '<p>'.$this->session->flashdata('message').'</p>';


			} 
		?>
      </div>
      <?php
    // echo '<pre>' ;
    //  print_r($conversation);
     
    
           
     // foreach ($namearrarr as $key => $value) {
     //    $arr[]=$value;
     //  }
      ?>
      <h4 class="convo_title">Conversation of <?php echo Ucfirst($namearr[$reporterid])?>(Reporter) and <?php echo Ucfirst($namearr[$offenderid])?></h4>
      <div class="box_block_convo">
      
      <?php
        if(!$conversation)
      { ?>
 
                        <div class="confrmmsg"><p>No Conversation Started.</p></div>
                      
      <?php
      }
      else
      { 
      $count=count($conversation);
        $mainarr=array();

        // echo '<pre>';
        // print_r($conversation);
        for($i=1;$i<=($count);$i++):
         
          if($i==1)
          {
            // echo 'he';
            $temparr[]=$conversation[$i-1];
            if($count==1)
            {
              $mainarr[][$temparr[0]->sender_id]=$temparr;
            }
          }
          else
          {


             $userid=$conversation[$i-1]->sender_id;
             if($userid==$conversation[$i-2]->sender_id)
            {

              $temparr[]=$conversation[$i-1];
               if(!isset($conversation[$i]))
               {
                $mainarr[][$temparr[0]->sender_id]=$temparr;
               }
            }else
            {

              $mainarr[][$temparr[0]->sender_id]=$temparr;
              $temparr=array();
              $temparr[]=$conversation[$i-1];
              $userid=$conversation[$i-1]->sender_id;
            }

          }
          endfor;

            $userid=$conversation['0']->sender_id;
            
    foreach($mainarr as $keys=>$data):   
      foreach($data as $key=>$val):
     
         if($userid==$key):
          if($key==$reporterid) $tooltipval='Reporter';
          else  $tooltipval='Offender'
      ?>
      	<div class="convo user_a">
      		<span class="frm_msg"><?php echo $namearr[$key]; ?><span class="convo_tooltip"><?php echo $tooltipval;?></span></span>
      		<div class="convo_msg">
          <!-- <span>Message:</span> -->
          <?php foreach($val as $indivualmesage): ?>
      			<p><?php echo $indivualmesage->message;?> <span class="rcv_date"> <?php echo $indivualmesage->messagedate;?></span></p>
          <?php endforeach;?>
      		</div>
      	</div>
      <?php 
      else:
      if($key==$reporterid) $tooltipval='Reporter';
          else  $tooltipval='Offender'
        // $user1cont=0;
        ?>
      	<div class="convo user_b">
      		<span class="frm_msg"><?php echo $namearr[$key]; ?><span class="convo_tooltip"><?php echo $tooltipval;?></span></span>
      		<div class="convo_msg">
           <!-- <span>Message:</span> -->
      		 <?php foreach($val as $indivualmesage):?>
      			<p><?php echo $indivualmesage->message;?> <span class="rcv_date"><?php echo $indivualmesage->messagedate;?></span></p>
          <?php endforeach;?>
      		</div>
      	</div>
      
      <?php 
    endif;
      endforeach;
      endforeach;
      }
      ?>
      </div>
    </section>
    <div class="clearfix"></div>
  </div>
</article>
<div> </div>
<script src="<?php echo base_url(ADMIN_JS_DIR.'admin.edit.product.js'); ?>" type="text/javascript"></script>

<style>
	.smfull .box_block_convo { width:70%; display:block; color:#9a9a9a;}
	h4.convo_title { margin: 10px 0; font-size: 15px; font-weight: bold; text-decoration: underline; }
	.convo.user_a {background-color:#efefef; padding:5px;}
  .convo:nth-child(2n) { margin-left:15px;}
	.convo.user_b {background-color:#fff; padding:5px;}
	.convo span.frm_msg { display:inline-block; font-weight: bold; color:#fff; padding:1px 4px; margin-bottom:5px; position:relative; cursor:pointer;}
	.convo.user_a span.frm_msg { background-color:#9e5d3b;}
	.convo.user_b span.frm_msg { background-color:#454545;}
	.convo .convo_msg { position:relative; padding-left:60px; display:block;}

	.convo .convo_msg span{ position:absolute; color:#333; left:0;}
	.convo_msg p {margin-bottom:3px;}
	.convo_msg p span.rcv_date { position:relative; font-size:11px; color:#bbb; float:right; }
  
  .frm_msg .convo_tooltip { 
    display:none;
  position:absolute; left: 107%; 
  background-color: rgba(0, 0, 0, 0.8); 
  padding: 2px; 
  top: 1px; 
  font-size: 9px; 
  border-radius: 2px; 
  }

  .frm_msg .convo_tooltip:after {
  right: 100%;
  top: 50%;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: rgba(0,0,0, 0);
  border-right-color: #000;
  border-width: 4px;
  margin-top: -4px;
}
  .convo .frm_msg:hover .convo_tooltip { display:block; }
</style>