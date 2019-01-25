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
            
          <?php 
// print_r($product_data);
// echo is_array($product_data);
          if($current_menu=='view_bids_products'):
            if( is_object($product_data) && (count($product_data)>0)):
            ?>
           	<table width="70%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
    				<tr>
                      <td width="7%"><strong>Product Id </strong></td>
                      <td width="15%"><?php echo $this->uri->segment('4');?></td>
                      <td width="7%"><strong>Product Name </strong></td>
                      <td width="15%"><?php echo $product_data->product_name; ?></td>
                    </tr>
                   
                   <tr>
                   		<td><strong>Advertiser Name</strong></td>
                      	<td><?php echo $product_data->username;?></td>
                       <td><strong>No Of Influencer</strong></td>
                      <td><?php echo $total_bids;?></td> 
                    </tr>
                   
                   
                    
  				</table>
           <br /><br />
         <?php endif;
            endif;
         ?>
            
  				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full" >
    				<thead>
                        <tr>
                            <!-- <th width="10%">Product. Id</th> -->
                             <!-- <th width="10%">Product. Name</th> -->
                              
                            <th width="15%">Influencer Name</th>
                            <th width="10%">Bid Amount</th>
                            
                            <th width="15%">Bid Date</th>
                            <th width="20%">Bid Status</th>
                        </tr>
                    </thead>
    				<tbody>
					<?php 
                    $sn_count=0;
                  
                    if(($bids_data))
                    {
                        foreach($bids_data as $value)
                        {   

                          ?>
                          <tr>
                            <!-- <td><?php echo $value->id;?></td>  -->
                            <!-- <td><?php echo $value->product;?></td> -->
                            <td><?php echo $value->membername;?></td>
                            <td><?php echo $value->user_bid_amt;?></td>
                              
                            <td><?php echo $this->general->long_date_time_format($value->bid_date);?></td>
                            <td>
                            <?php 
                                if($value->status=='0') echo 'Pending'; 
                                if(($value->status=='1' || $value->status=='2') && (!isset($value->draft_accept))) echo 'In Progress';
                                if(($value->status=='1' || $value->status=='2') && isset($value->draft_accept) && $value->draft_accept=='0'): ?><a href="#popupdraft<?php echo $value->bid_id;?>" class="c_button">View Draft</a>

                                

                                <?php 
                                endif;
                                if(($value->status=='1' || $value->status=='2') && isset($value->draft_accept) && $value->draft_accept=='1' && $value->upload_status=='0'):?> Waiting For Upload <a href="#popupdraft<?php echo $value->bid_id;?>" class="c_button">View Draft</a> <?php
                                endif; 
                                 if(($value->status=='1' || $value->status=='2') && isset($value->draft_accept) && $value->draft_accept=='1' && $value->upload_status=='1'):  ?>
                                 <a href="#popupuploaded_content<?php echo $value->bid_id?>" class="c_button">View content Uploaded </a>
                                  <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/product/add_report/'.$value->bid_id)?>" class="c_button add_btn">Add Report</a>
                                 <?php 
                                 endif;
                                 if($value->status=='7' && $value->upload_status=='1'): ?>
                                   <a href="#popupreport<?php echo $value->bid_id?>" class="c_button">View Report </a>
                                <?php
                                 endif;
                                 if(($value->status=='1' || $value->status=='2') && isset($value->draft_accept) && $value->draft_accept=='2' ):  ?><a href="#popup1" class="c_button">Draft Reject</a>
                                <?php
                                endif;
                                if($value->status=='3' || $value->status=='4') echo 'Declined';
                                if($value->status=='7') echo 'Completed'?>
                                </td>
                          </tr>

                         
                        <?php 

                        if(isset($value->draft_accept) ): ?>
                            <div id="popupdraft<?php echo $value->bid_id;?>" class="modalDialog">
                                <a class="cancel" href="#"></a>
                                  <div class="popup">
                                    <h2>Draft OF Promotion</h2>
                                    <a class="close" href="#">&times;</a>
                                      <div class="content">
                                              <div class="img_sec">
                                                <figure>
                                                  <img src="<?php echo site_url(DRAFT_IMAGE_PATH.'/'.$value->image)?>" alt="">
                                                </figure>
                                              </div>
                                              <div class="desc_sec">
                                                <span class="datetime">
                                                  <label>Date :</label>
                                                  2017-05-12
                                                </span>
                                                <p><?php echo $value->description;?></p>
                                             
                                                
                                              </div>
                                        </div>
                                        <div class="url_link">
                                          <label>Url</label>
                                          <a href="<?php echo $value->link;?>" class="social_link"><?php echo $value->link;?></a>
                                        </div>
                                  </div>
                              </div>
                        <?php 
                        endif;
                        if(($value->upload_status=='1')): 
                          $content=$this->general->get_uploaded_content($value->bid_id);

                          $page=$this->general->get_single_row('member_socialmedia',array('user_id'=>$value->user_id,'media_type_id'=>FACEBOOKMEDIAID));
                          
                          ?>
                               <div id="popupuploaded_content<?php echo $value->bid_id?>" class="modalDialog">
                               <a class="cancel" href="#"></a>
                                  <div class="popup posts">
                                    <h2>Uploaded Content</h2>
                                    <a class="close" href="#">&times;</a>

                                    <div class="content">
                          

                                        <ul class="social_post">
                                        <?php foreach($content as $eachcontent):
                                        if($eachcontent->uploaded_media=='fb_page')
                                        { 

                                          if(count($page)>0  || strpos($eachcontent->link, '://'))
                                          {
                                               $options = array(
                                            
                                              'http'=>array(
                                                'method'=>"GET",
                                                'header'=>"Accept-language: en\r\n" .
                                                                            "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                                                                            "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n"
                                                                            )
                                              );

                                            $context = stream_context_create($options);
                                            if (false === strpos($eachcontent->link, 'https://'))
                                            {
                                                  $request_url = 'https://www.facebook.com/plugins/post/oembed.json/?url=http://facebook.com/'.$page->page_id.'/posts/'.$eachcontent->link.'&omitscript=false';
                                            }
                                            else
                                            {
                                              $request_url = 'https://www.facebook.com/plugins/post/oembed.json/?url='.$eachcontent->link.'&omitscript=false';
                                            }
                                          
                                            $jsonresp=file_get_contents($request_url,false, stream_context_create($options));
                                            $response = json_decode($jsonresp, true); 
                                          }
                                          else{
                                            $response= '<a target="_blank" href="http://facebook.com/'.$eachcontent->link.'" >http://facebook/com/'.$eachcontent->link.'</a>';
                                          }
                                        ?>
                                        <li>
                                        <label>Facebook Page</label>
                                          <div class="s_post"><?php print_r($response['html']);?></div>
                                        </li>
                                        <?php
                                        }
                                        elseif($eachcontent->uploaded_media=='fb_profile'){
                                        ?>
                                          <li>
                                          <label>Facebook Profile</label>
                                            <div class="s_post">
                                                <div class="fb-post" data-href="<?php echo $eachcontent->link;?>" data-width="500" data-show-text="true"><blockquote cite="<?php echo $eachcontent->link;?>" class="fb-xfbml-parse-ignore"></blockquote></div>

                                            </div>
                                          </li>
                                        
                                        <?php 
                                        }
                                        //for instagran
                                        else
                                        { ?>
                                       <li>
                                       <label>Instagram Post</label>
                                       <div class="s_post">
                                       <?php 
                                         $request_url = 'https://api.instagram.com/oembed?url=' . $eachcontent->link;
                                         $response=(file_get_contents($request_url."&omitscript=false&hidecaption=false"));
                                         $json_data = json_decode($response , true);

                                         // print_r($json_data);
                                         echo $json_data['html'];
                                        ?>
                                        </div>
                                         </li>
                                         <?php
                                        }
                                        endforeach;?>
                                          <div></div>
                                        </ul>
                                    </div>
                                  </div>
                                </div>

                        <?php 
                       endif;
 /******************************************************For report of completed campaign********************/
                       if($value->status=='7'):
                        $report=$this->general->get_report($value->bid_id)
                        ?>
                          <fieldset>
            <div class="title_h3">Report</div>
               <div id="popupreport<?php echo $value->bid_id?>" class="modalDialog">
                               <a class="cancel" href="#"></a>
                                  <div class="popup posts">
                                    <h2>Report</h2>
                                    <a class="close" href="#">&times;</a>

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
                                                        <li class="txtfull txtttl">
                                                        <label>Facebook Page</label>
                                                      </li>
                                                      <li class="c_width_4">
                                                        <div>
                                                          <label><span>Uploaded Link</span></label>
                                                          <a target="_blank" href="<?php echo $eachcontent->link;?>"><?php echo $eachcontent->link;?></a>
                                                        
                                                        </div>
                                                      </li>

                                                      <li class="c_width_2">
                                                        <div>
                                                          <label><span>Like</span></label>
                                                          <input  class="inputtext reportinputview" name="page_content_id" type="hidden" value="<?php echo $eachcontent->id;?>">
                                                          <input disabled size="50" class="inputtext reportinputview d_input" name="page_like" type="text" value="<?php echo set_value('page_like',$pagelike)?>">
                                                          <?=form_error('page_like')?>
                                                        </div>
                                                      </li>

                                                      <li class="c_width_2">
                                                        <div>
                                                          <label><span>Share</span></label>
                                                          <input disabled size="50" class="inputtext reportinputview d_input" name="page_share" type="text" value="<?php echo set_value('page_share',$pageshare)?>">
                                                          <?=form_error('page_share')?>
                                                        </div>
                                                      </li>

                                                      <li class="c_width_2">
                                                        <div>
                                                          <label><span>Comment</span></label>
                                                          <input disabled size="50" class="inputtext reportinputview d_input" name="page_comment" type="text" value="<?php echo set_value('page_comment',$pagecomment)?>">
                                                          <?=form_error('page_comment')?>
                                                        </div>
                                                      </li>
                                                    <?php
                                                    endif;
                                                    if($eachcontent->uploaded_media=='fb_profile'): ?>
                                                      <input  disabled class="inputtext reportinputview" name="profile_content_id" type="hidden" value="<?php echo $eachcontent->id;?>">
                                                        <li class="txtfull txtttl">
                                                        <label>Facebook Profile</label>
                                                      </li>
                                                      <li class="c_width_4">
                                                        <div>
                                                          <label><span>Uploaded Link</span></label>
                                                          <a target="_blank" href="<?php echo $eachcontent->link;?>"><?php echo $eachcontent->link;?></a>
                                                         
                                                        </div>
                                                      </li>

                                                      <li class="c_width_2">
                                                        <div>
                                                          <label><span>Like</span></label>
                                                          <input disabled size="20" class="inputtext reportinputview d_input" name="profile_like" type="text" value="<?php echo set_value('profile_like',$profilelike)?>">
                                                          <?=form_error('profile_like')?>
                                                        </div>
                                                      </li>

                                                      <li  class="c_width_2">
                                                        <div>
                                                          <label><span>Share</span></label>
                                                          <input disabled size="20" class="inputtext reportinputview d_input" name="profile_share" type="text" value="<?php echo set_value('profile_share',$profileshare)?>">
                                                          <?=form_error('profile_share')?>
                                                        </div>
                                                      </li>

                                                      <li  class="c_width_2">
                                                        <div>
                                                          <label><span>Comment</span></label>
                                                          <input size="20" disabled class="inputtext reportinputview d_input" name="profile_comment" type="text" value="<?php echo set_value('profile_comment',$profilecomment)?>">
                                                          <?=form_error('profile_comment')?>
                                                        </div>
                                                      </li>
                                                    <?php
                                                    endif;
                                                    if($eachcontent->uploaded_media=='instagram'): ?>
                                                      <input  disabled class="inputtext reportinputview " name="instagram_content_id" type="hidden" value="<?php echo $eachcontent->id;?>">
                                                        <li class="txtfull txtttl">
                                                        <label>Instagram</label>
                                                      </li>
                                                      <li class="c_width_4">
                                                        <div>
                                                          <label><span>Uploaded Link</span></label>
                                                          <a target="_blank" href="<?php echo $eachcontent->link;?>"><?php echo $eachcontent->link;?></a>
                                                        </div>
                                                      </li>

                                                      <li class="c_width_2">
                                                        <div>
                                                          <label><span>Like</span></label>
                                                          <input disabled size="50" class="inputtext reportinputview d_input" name="instagram_like" type="text" value="<?php echo set_value('instagram_like',$instalike)?>">
                                                          <?=form_error('instagram_like')?>
                                                        </div>
                                                      </li>

                                                     

                                                      <li class="c_width_2">
                                                        <div>
                                                          <label><span>Comment</span></label>
                                                          <input disabled size="50" class="inputtext reportinputview d_input" name="instagram_comment" type="text" value="<?php echo set_value('instagram_comment',$instacomment)?>">
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
                                    </div>
                                      </div>
                                    </div>

                       </fieldset>
          <?php 
         /******************************************************End report of completed campaign********************/
                      
                        endif;
                        }
                    }else{ ?>
                      <tr><td colspan="6">No records Found</td></tr>
                   <?php }
                    ?>
                </tbody>
  				</table>
  			</div>

             <?php if ($links) { echo "<ul class='pagination'>".$links."</ul>"; } ?>
               <input type="hidden"  id="productid" value="<?php  echo $this->uri->segment('4');?>">
           <div id="chart_div"></div>
           

           
		</section>
  		<div class="clearfix"></div>
	</div>

</article>

<div> </div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   

        <script type="text/javascript">

$(function () {      
      google.charts.load('current', {'packages':['corechart']});
      // Set a callback to run when the Google Visualization API is loaded.
       google.charts.setOnLoadCallback(drawChart);
    });

    function drawChart() {
        var product=$('#productid').val();
        var url="<?php echo site_url('/'.MY_ACCOUNT.'getbidbyproduct')?>"+'/'+product;
   
        var data = new google.visualization.DataTable();
        
    
  $.getJSON(url, function(jsonData) {
    console.log(jsonData);
        data.addColumn('string', 'Day');
        data.addColumn('number', 'Bidding Amount');
        data.addRows(jsonData);
        var options = {
          title: 'Bid amount Vs Bid Date',
          pointSize: 10,
          curveType: 'function',
           pointShape: 'square',
          hAxis: {
            gridlines: {count: 15}
          },
          vAxis: {
            gridlines: {color: 'none'},
            minValue: 0
          }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        var button = document.getElementById('change');
        // button.onclick = function () {
        //   // If the format option matches, change it to the new option,
        //   // if not, reset it to the original format.
        //   // options.hAxis.format === 'M/d/yy' ?
        //   // options.hAxis.format = 'MMM dd, yyyy' :
        //   // options.hAxis.format = 'M/d/yy';
        //   chart.draw(data, options);
        // };
    }); 
 }
      // Create our data table out of JSON data loaded from server.
     
        // </script>


         