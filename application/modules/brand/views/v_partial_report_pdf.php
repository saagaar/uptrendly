<style>
 .rep_prod_ttl { border-bottom:1px solid #EDEDED;padding-bottom:10px; color:#848484; }
  .report_user { padding:10px; }
  .rep_prod_block { background-color:#f7f7f7; padding:0 15px; }
  h4.rep_prod_name { padding-bottom:15px; border-bottom:1px solid #ddd; margin-bottom:10px; }
  .report_user .ru_ul { list-style:none; padding:10px; background-color:#f9f9f9; box-shadow:0px 1px 3px 2px #eee; }
  .report_grid { font-size:12px; width:100%; }
  .report_grid { border-bottom:1px solid #ddd; }
  .report_grid td { font-weight:normal; padding:10px 5px;}
  .report_grid td.url { border-bottom:1px solid #ddd; }
  
</style>
        <div class="row no-marg-right">

          <div class="col-sm-12">
            <div class="right_draft_sec .report_user">
              <h3 class="rep_prod_ttl">Report</h3>
              <div class="rep_prod_block">
              <h4 class="rep_prod_name"> <?php echo $product_name;?></h4>
                
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

                        

                        <!-- <ul class="frm"> -->

                          <?php
                          if($eachcontent->uploaded_media=='fb_page'): ?>

                          <table class="report_grid">
                            <tr>
                              <td width="15%" rowspan="2">
                                <label>Facebook Page</label>
                              </td>  
                              <td colspan="3" class="url">
                                <h5><span class="url">Uploaded Link: <?php echo $eachcontent->link;?></span></h5>
                              </td>
                            </tr>
                            <tr>                                  
                              <td>
                                <h5>
                                  <label>Likes:</label>
                                  <span>
                                    <?php echo set_value('page_like',$pagelike)?>
                                      
                                  </span>
                                </h5>
                              </td>
                              <td>
                                <h5>
                                  <label>Comments:</label> 
                                  <span>
                                    <?php echo set_value('page_comment',$pagecomment)?>
                                  </span>
                                </h5>
                              </td>
                              <td>
                                <h5>
                                  <label>Share:</label> 
                                  <span>
                                    <?php echo set_value('page_share',$pageshare)?>
                                  </span>
                                </h5>
                              </td>
                            </tr>
                          </table>

                          <!-- <div class="row">
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
                          </div> -->
                          <?php
                          endif;
                          if($eachcontent->uploaded_media=='fb_profile'): ?>

                          
                          <table class="report_grid">
                            <tr>
                              <td width="15%" rowspan="2">
                                <label>Facebook Profile</label>
                              </td>  
                              <td colspan="3" class="url">
                                <h5><span class="url">Uploaded Link: <?php echo $eachcontent->link;?></span></h5>
                              </td>
                            </tr>
                            <tr>                                  
                              <td>
                                <h5>
                                  <label>Likes:</label> 
                                  <span>
                                    <?php echo set_value('profile_like',$profilelike)?>
                                  </span>
                                </h5>
                              </td>
                              <td>
                                <h5>
                                  <label>Comments:</label> 
                                  <span>
                                    <?php echo set_value('profile_comment',$profilecomment)?>
                                  </span>
                                </h5>
                              </td>
                              <td>
                                <h5>
                                  <label>Share:</label> 
                                  <span>
                                    <?php echo set_value('profile_share',$profileshare)?>
                                  </span>
                                </h5>
                              </td>
                            </tr>
                          </table>

                          <!-- <div class="row">
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
                          </div> -->
                          <?php
                          endif;
                          if($eachcontent->uploaded_media=='instagram'): ?>

                          <table class="report_grid">
                            <tr>
                              <td width="15%" rowspan="2">
                                <label>Instagram</label>
                              </td>  
                              <td colspan="3" class="url">
                                <h5><span class="url">Uploaded Link: <?php echo $eachcontent->link;?></span></h5>
                              </td>
                            </tr>
                            <tr>                                  
                              <td>
                                <h5>
                                  <label>Likes:</label>
                                  <span>
                                    <?php echo set_value('instagram_like',$instalike)?>
                                      
                                  </span>
                                </h5>
                              </td>
                              <td>
                                <h5>
                                  <label>Comments:</label> 
                                  <span>
                                    <?php echo set_value('instagram_comment',$instacomment)?>
                                  </span>
                                </h5>
                              </td>
                              <td></td>
                            </tr>
                          </table>

                          <!-- <div class="row">
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
                          </div> -->
                          <?php
                          endif;
                          ?>
                       <!--  </ul> -->
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
