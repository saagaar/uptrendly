 <?php if(!isset($type)) :?>
 <div class="modal fade " id="v_view_report_<?php echo $bid_id ?>" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;">
          <span aria-hidden="true" class="fa fa-times"></span>
        </button>
<?php endif;?>
        <div class="row no-marg-right">

          <div class="col-sm-12">
            <div class="right_draft_sec">
              <h3 class="modal_ttl">Report</h3>
              <div>
              <h2> <?php echo $product_name;?></h2>
                
                <fieldset>
                  <div id="popupreport<?php echo $bid_id?>" class="m_overlay">
                    <!-- <a class="cancel" href="#"></a> -->
                    <div class="popup posts">                                                                  

                      <div class="content">
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

                          <div class="row">
                            <div class="col-sm-12">
                              <li class="txtfull txtttl">
                                <label>Facebook Page</label>
                              </li>
                              <li class="col-sm-4">
                                <div>
                                  <div><label>Uploaded Link</label></div>
                                  <a target="_blank" class="word-wrap" href="<?php echo $eachcontent->link;?>"><?php echo $eachcontent->link;?></a>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Like</span></label>
                                  <input class="inputtext reportinputview" name="page_content_id" type="hidden" value="<?php echo $eachcontent->id;?>">
                                  <input disabled size="50" class="inputtext reportinputview d_input" name="page_like" type="text" value="<?php echo set_value('page_like',$pagelike)?>">
                                  <?=form_error('page_like')?>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Share</span></label>
                                  <input disabled size="50" class="inputtext reportinputview d_input" name="page_share" type="text" value="<?php echo set_value('page_share',$pageshare)?>">
                                  <?=form_error('page_share')?>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Comment</span></label>
                                  <input disabled size="50" class="inputtext reportinputview d_input" name="page_comment" type="text" value="<?php echo set_value('page_comment',$pagecomment)?>">
                                  <?=form_error('page_comment')?>
                                </div>
                              </li>
                            </div>
                          </div>
                          <?php
                          endif;
                          if($eachcontent->uploaded_media=='fb_profile'): ?>
                          <div class="row">
                            <div class="col-sm-12">
                              
                            
                              <input  disabled class="inputtext reportinputview" name="profile_content_id" type="hidden" value="<?php echo $eachcontent->id;?>">

                              <li class="txtfull txtttl">
                                <label>Facebook Profile</label>
                              </li>
                              <li class="col-sm-4">
                                <div>
                                  <div><label>Uploaded Link</label></div>
                                  <a target="_blank" class="word-wrap" href="<?php echo $eachcontent->link;?>"><?php echo $eachcontent->link;?></a>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Like</span></label>
                                  <input disabled size="20" class="inputtext reportinputview d_input" name="profile_like" type="text" value="<?php echo set_value('profile_like',$profilelike)?>">
                                  <?=form_error('profile_like')?>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Share</span></label>
                                  <input disabled size="20" class="inputtext reportinputview d_input" name="profile_share" type="text" value="<?php echo set_value('profile_share',$profileshare)?>">
                                  <?=form_error('profile_share')?>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Comment</span></label>
                                  <input size="20" disabled class="inputtext reportinputview d_input" name="profile_comment" type="text" value="<?php echo set_value('profile_comment',$profilecomment)?>">
                                  <?=form_error('profile_comment')?>
                                </div>
                              </li>
                            </div>
                          </div>
                          <?php
                          endif;
                          if($eachcontent->uploaded_media=='instagram'): ?>
                          <div class="row">
                            <div class="col-sm-12">
                              
                            
                              <input  disabled class="inputtext reportinputview" name="instagram_content_id" type="hidden" value="<?php echo $eachcontent->id;?>">

                              <li class="txtfull txtttl">
                                <label>Instagram</label>
                              </li>

                              <li class="col-sm-4">
                                <div>
                                  <div><label>Uploaded Link</label></div>
                                  <a target="_blank" class="word-wrap" href="<?php echo $eachcontent->link;?>"><?php echo $eachcontent->link;?></a>
                                </div>  
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Like</span></label>
                                  <input disabled size="50" class="inputtext reportinputview d_input" name="instagram_like" type="text" value="<?php echo set_value('instagram_like',$instalike)?>">
                                  <?=form_error('instagram_like')?>
                                </div>
                              </li>

                              <li class="col-sm-2">
                                <div>
                                  <label><span>Comment</span></label>
                                  <input disabled size="50" class="inputtext reportinputview d_input" name="instagram_comment" type="text" value="<?php echo set_value('instagram_comment',$instacomment)?>">
                                  <?=form_error('instagram_comment')?>
                                </div>
                              </li>
                            </div>
                          </div>
                          <?php
                          endif;
                          ?>
                        </ul>
                        <?php
                        endforeach;
                        ?>
                      </div>
                    </div>
                  </div>

                </fieldset>
              </div>

            </div>
          </div>
        </div>
 <?php if(!isset($type)) :?>
      </div>
    </div>
  </div>
<?php endif;?>