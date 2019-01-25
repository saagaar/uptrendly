<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Post Management</h2>
  </div>
</section>

<article id="bodysec" class="sep">
	<div class="wrap">
  <pre><?php //print_r($bids_data);?></pre>
		<aside class="lftsec"><?php $this->load->view('menu'); ?></aside>
		<section class="smfull">
			<div class="box_block">
            
          
        
  			</div>

        <div class="box_block">
          <form name="addreport" id="addreport" method="post" action="" >
      
          <fieldset>
            <div class="title_h3">Report</div>
        <?php 
       
       $pagelike='';
       $pagecomment='';
       $pageshare='';
       $profilelike='';
       $profilecomment='';
       $profileshare='';
       $instalike='';
       $instacomment='';

        foreach($content as $eachcontent): 

          if(count($report)>0 && is_array($report))
          {
             foreach($report as $eachreport):
                if($eachcontent->uploaded_media=='fb_page' && $eachcontent->id==$eachreport->content_id)
                {
                  $pagecontentid=$eachcontent->id;
                  $pagelike=$eachreport->likes;
                  $pagecomment=$eachreport->comments;
                  $pageshare=$eachreport->share;
                }
                 if($eachcontent->uploaded_media=='fb_profile' && $eachcontent->id==$eachreport->content_id)
                {
                  $profilecontentid=$eachcontent->id;
                  $profilelike=$eachreport->likes;
                  $profilecomment=$eachreport->comments;
                  $profileshare=$eachreport->share;
                }
                 if($eachcontent->uploaded_media=='instagram' && $eachcontent->id==$eachreport->content_id)
                {
                  $instacontentid=$eachcontent->id;
                  $instalike=$eachreport->likes;
                  $instacomment=$eachreport->comments;
                 
                }
             endforeach;
          }
          
          ?>
            <ul class="frm">
           <?php
            if($eachcontent->uploaded_media=='fb_page'): ?>
                <li class="txtfull txtttl">
                <label>Facebook Page</label>
              </li>
              <li>
                <div>
                  <label><span>Uploaded Link</span></label>
                  <a target="_blank" href="<?php echo $eachcontent->link;?>"><?php echo $eachcontent->link;?></a>
                
                </div>
              </li>

              <li>
                <div>
                  <label><span>Like</span></label>
                  <input class="inputtext" name="page_content_id" type="hidden" value="<?php echo $eachcontent->id;?>">
                  <input size="50" class="inputtext" name="page_like" type="text" value="<?php echo set_value('page_like',$pagelike)?>">
                  <?=form_error('page_like')?>
                </div>
              </li>

              <li>
                <div>
                  <label><span>Share</span></label>
                  <input size="50" class="inputtext" name="page_share" type="text" value="<?php echo set_value('page_share',$pageshare)?>">
                  <?=form_error('page_share')?>
                </div>
              </li>

              <li>
                <div>
                  <label><span>Comment</span></label>
                  <input size="50" class="inputtext" name="page_comment" type="text" value="<?php echo set_value('page_comment',$pagecomment)?>">
                  <?=form_error('page_comment')?>
                </div>
              </li>
            <?php
            endif;
            if($eachcontent->uploaded_media=='fb_profile'): ?>
              <input class="inputtext" name="profile_content_id" type="hidden" value="<?php echo $eachcontent->id;?>">
                <li class="txtfull txtttl">
                <label>Facebook Profile</label>
              </li>
              <li>
                <div>
                  <label><span>Uploaded Link</span></label>
                  <a target="_blank" href="<?php echo $eachcontent->link;?>"><?php echo $eachcontent->link;?></a>
                 
                </div>
              </li>

              <li>
                <div>
                  <label><span>Like</span></label>
                  <input size="20" class="inputtext" name="profile_like" type="text" value="<?php echo set_value('profile_like',$profilelike)?>">
                  <?=form_error('profile_like')?>
                </div>
              </li>

              <li>
                <div>
                  <label><span>Share</span></label>
                  <input size="20" class="inputtext" name="profile_share" type="text" value="<?php echo set_value('profile_share',$profileshare)?>">
                  <?=form_error('profile_share')?>
                </div>
              </li>

              <li>
                <div>
                  <label><span>Comment</span></label>
                  <input size="20" class="inputtext" name="profile_comment" type="text" value="<?php echo set_value('profile_comment',$profilecomment)?>">
                  <?=form_error('profile_comment')?>
                </div>
              </li>
            <?php
            endif;
            if($eachcontent->uploaded_media=='instagram'): ?>
              <input class="inputtext" name="instagram_content_id" type="hidden" value="<?php echo $eachcontent->id;?>">
                <li class="txtfull txtttl">
                <label>Instagram</label>
              </li>
              <li class="txtquart">
                <div>
                  <label><span>Uploaded Link</span></label>
                  <a target="_blank" href="<?php echo $eachcontent->link;?>"><?php echo $eachcontent->link;?></a>
                </div>
              </li>

              <li class="txtquart">
                <div>
                  <label><span>Like</span></label>
                  <input size="50" class="inputtext" name="instagram_like" type="text" value="<?php echo set_value('instagram_like',$instalike)?>">
                  <?=form_error('instagram_like')?>
                </div>
              </li>

             

              <li class="txtquart">
                <div>
                  <label><span>Comment</span></label>
                  <input size="50" class="inputtext" name="instagram_comment" type="text" value="<?php echo set_value('instagram_comment',$instacomment)?>">
                  <?=form_error('instagram_comment')?>
                </div>
              </li>
            <?php
            endif;
            ?>
            </ul>
            <?php
                  endforeach;
            ?>
              <ul><li>  <input type="submit" value="Submit" class="butn" id="addreportbtn"></li></ul>
            
        </fieldset>
        </form>
        </div>




            <!--  <?php if ($links) { echo "<ul class='pagination'>".$links."</ul>"; } ?>
              <input type="hidden"  id="productid" value="<?php  echo $this->uri->segment('4');?>">
                       <div id="chart_div"></div> -->
           

           
		</section>
  		<div class="clearfix"></div>
	</div>

</article>


