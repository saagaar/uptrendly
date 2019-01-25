

        <div class="col-md-12 col-sm-12">

        <div class="log-form">

            <div class="clearfix"></div>

            <div class="about_user">

            <div class="row">

                <div class="col-md-6">

                <?php 
                // print_r($user_info);
                if(is_array($user_info))
                {       
                if(count($user_info)>0)
                {
                   if(isset($user_info[0]->cover_image)) $image=site_url(USER_IMAGE_PATH.$user_info[0]->cover_image);
                    else $image='';
                ?>

                    <figure><img src="<?php  echo $image;?>" alt="Image" /></figure>
                    <ul class="user_info">
                        <li> <?php echo $user_info[0]->name.' '. $user_info[0]->last_name;?> </li>
                        <li>

                            <?php 

                            if(count($my_rating)>0)
                            {
                                $percentage=($my_rating->averagerating/5)*100;
                            }else
                            $percentage=0;
                            ?>

                                <div class="star-ratings-sprite">

                                   <span style="width:<?php echo $percentage;?>%" class="star-ratings-sprite-rating"></span>

                                 </div>

                     </li>

                        <li><?php echo count($productwise_rating);?> Review</li>

                    </ul>

                </div>

                <div class="col-md-6">

                <ul class="pull-right">

                    <p>Average rating</p>

                    <p><?php echo isset($my_rating->averagerating)?round($my_rating->averagerating,1):'No Rating';?></p>

                </ul>    

                </div>

            </div>

            </div>

            

         <h2>Work history and feedback</h2>

         <ul class="work_inner">

         <?php 

         if(count($productwise_rating)>0)

         {

         foreach ($productwise_rating as $key => $value) { 

        $percentageproductrate=($value->overall_rating/5)*100;

         $percentreviewuserrate=($value->rateduserrating/5)*100;





            ?>

             <li>

                <div class="row">

                   <div class="col-md-9">

                         <h4><?php echo $value->productname?></h4>

                         <p>

                         <div class="star-ratings-sprite-small">

                              <span style="width:<?php echo $percentageproductrate;?>%" class="star-ratings-sprite-rating-small"></span>

                        </div>

                         <?php

                                  

                            echo $value->comment?>   

                         </p>

                          <a href="<?php echo site_url('/'.MY_ACCOUNT.'member_profile/'.$value->from_user_id)?>"><?php echo $value->name.' '. $value->last_name;?></a> 



                            <div class="star-ratings-sprite-small">

                                  <span style="width:<?php echo $percentreviewuserrate;?>%" class="star-ratings-sprite-rating-small"></span>

                             </div>

                    </div>

                         <div class="col-md-3">

                            <time><?php 



                            echo $this->general->month_date_time_format($value->rating_date);

                             

                            ?></time>

                    </div>

                 

               </div>

           </li>

        <?php } 

     }else{

        echo 'No Records';

     }



}
}
else{

    echo "No User Found";

}

        ?>

         

          <!--  

           <li>

            <div class="row">

           <div class="col-md-9">

             <h4>Product Name</h4>

             <p>

                <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i>

                Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry 

             </p>

             <em>To asdfghjkl <a href="#">Bikash Bhandari</a> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> Lorem Ipsum is simply dummy text</em>

             </div>

             <div class="col-md-3">

                <time>July 2016</time>

             </div>

             

           </div>

           </li>

           

           <li>

            <div class="row">

           <div class="col-md-9">

             <h4>Product Name</h4>

             <p>

                <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i>

                Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry 

             </p>

             <em>To asdfghjkl <a href="#">Bikash Bhandari</a> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> Lorem Ipsum is simply dummy text</em>

             </div>

             <div class="col-md-3">

                <time>July 2016</time>

             </div>

             

           </div>

           </li>

           

           <li>

            <div class="row">

           <div class="col-md-9">

             <h4>Product Name</h4>

             <p>

                <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i>

                Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry 

             </p>

             <em>To asdfghjkl <a href="#">Bikash Bhandari</a> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> Lorem Ipsum is simply dummy text</em>

             </div>

             <div class="col-md-3">

                <time>July 2016</time>

             </div>

             

           </div>

           </li>

           

           <li>

            <div class="row">

           <div class="col-md-9">

             <h4>Product Name</h4>

             <p>

                <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i>

                Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry 

             </p>

             <em>To asdfghjkl <a href="#">Bikash Bhandari</a> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> Lorem Ipsum is simply dummy text</em>

             </div>

             <div class="col-md-3">

                <time>July 2016</time>

             </div>

             

           </div>

           </li> -->

         </ul>

            

         

         </div>

            

        </div>

 

    

    

