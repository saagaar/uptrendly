<style>
  ul.report_pdf { list-style:none; color:#343434;}
  ul.report_pdf li { border-bottom:1px solid #bbb; padding-bottom:30px; margin-bottom:30px; }
  .report_pdf .pdf_img { width:29%; float:left; display:inline-block; }
  .report_pdf .pdf_img img {  max-width:50px; height:300px; margin:0 auto; }
  .report_pdf .pdf_content { width:65%; float:right; display:inline-block; }
  .pdf_content h3 { text-decoration: underline; }
  .pdf_content h5 { margin:0; margin-bottom:10px; }
  .pdf_content .social_url { margin-top:15px; }
  .pdf_data { width:25%;  float:left; display:inline-block;}
</style>

<ul class="report_pdf">
  <?php 

                   if(is_array($reports) && count($reports)>0){
                      foreach($reports as $productdata)
                    {                       
                      $engage=0;
                      $click=0;
                      $data=array();
                      $engagements=array();
                  
                      if((is_object($data))>0)
                      {                        
                        if(count($data->rows)<1)
                         {                         
                          $click=0;
                         }
                         else
                         {
                           $click=($data->rows['0']['0']);
                         }
                      } 
                     
                      $dimensions='ga:hits';

                      if(is_object($engagements)>0)
                      {
                        if(count($engagements->rows)>0)
                         {
                          $engage=($engagements->rows['0']['0']);
                         }
                        else
                         {
                          $engage=0;
                         }
                      }
                     if($productdata['image'])
                      {
                        $tempimage=explode(',',$productdata['image']);
                        $image=$this->general->get_product_image($tempimage[0]);
                      }
                      
                    $submission_deadline=$this->general->date_formate($productdata['submission_deadline']);
              ?>
<!--   <input type="hidden" id="<?php echo $productdata['product_id'];?>_allmedia" value="<?php echo $productdata['media'];?>" >
 -->  <input type="hidden" id="<?php echo $productdata['product_id'];?>_product_url" value="<?php echo $productdata['product_url'];?>">
  <input type="hidden"  id="<?php echo $productdata['product_id'];?>_price_range" value="<?php echo DEFAULT_CURRENCY_SIGN.$productdata['price_range'];?>">
  <input type="hidden"  id="<?php echo $productdata['product_id'];?>_submission_deadline" value="<?php echo $submission_deadline;?>">
  <input type="hidden"  id="<?php echo $productdata['product_id'];?>_description" value="<?php echo $productdata['description'];?>">
  
  <li>
    <div class="row">
      <div class="pdf_img"> 
          <img id="<?php echo $productdata['product_id'];?>_productimg" src="<?php echo  $image;?>">
      </div>
      <div class="pdf_content">
        <h3>
          <div id="<?php echo $productdata['product_id'];?>_product_name"><?php echo $productdata['name'];?></div>
          <?php 
            $socialmedia=array();                               									
             $spend=0;                                 
             $ctr=0;$cpe=0;                
              ?>
        </h3>
        
        <div class="pdf_data">
          <h5>
            <div class="">Views</div><?php  if($productdata['comments']) echo $productdata['comments'];else echo 0;?>
          </h5>
        </div>

        <div class="pdf_data">
          <h5>
            <div class="">Likes</div> <?php  if($productdata['likes']) echo $productdata['likes'];else echo 0;?>
          </h5>
        </div>
        
        <div class="pdf_data">
          <h5>
            <div class="">Comment</div><?php  if($productdata['comments']) echo $productdata['comments'];else echo 0;?>
          </h5>
        </div>

        <div class="pdf_data">
          <h5>
            <div class="">Tweet</div> <?php  if($productdata['tweet']) echo $productdata['tweet'];else echo 0;?>
          </h5>
        </div>              

        <div class="pdf_data">
          <h5>
            <div class="">Share</div><?php  if($productdata['share']) echo $productdata['share'];else echo 0;?>
          </h5>
        </div>

        <div class="pdf_data">
          <h5>
            <div class="">Subscribe</div><?php  if($productdata['subscribe']) echo $productdata['subscribe'];else echo 0;?>
          </h5>
        </div>

        <div class="pdf_data">
          <h5>
            <div class="">Followers</div><?php  if($productdata['follow']) echo $productdata['follow'];else echo 0;?>
          </h5>
        </div>


        <div class="social_url" style="width:100%;">
          <h5>
            <div class="underline">Social media Link</div>
          </h5> 
          <h5>
            <div>Facebook page: </div> <a href="http://facebook.com/<?php echo $productdata['upload_link']?>">http://facebook.com/<?php echo $productdata['upload_link']?></a>
          </h5>
          <h5>
            <div>Facebook post: </div> <a href="http://facebook.com/<?php echo $productdata['upload_link']?>">http://facebook.com/<?php echo $productdata['upload_link']?></a>
          </h5>
          <h5>
            <div>Instagram: </div> <a href="http://facebook.com/<?php echo $productdata['upload_link']?>">http://facebook.com/<?php echo $productdata['upload_link']?></a>
          </h5>
        </div>
      </div>
    </div>
  </li>
  <?php 
          }
      }
     else{
            echo '<p><h4 style="color:#337ab7"> No records Found </h4></p>';
         }
                    ?>
</ul>
<!-- Modal -->



