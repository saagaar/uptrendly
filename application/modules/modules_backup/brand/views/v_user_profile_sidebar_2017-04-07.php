 <div class="right-pad">

                        <div class="profile_rt_br">
                            <div class="pro_pic">
                                <img src="<?php echo site_url('/'.USER_IMG_DIR.$user_info['basicinfo']['cover_image'])?>" alt="" class="pp">
                            </div>
                            <div class="pro_name">
                                <?php echo $user_info['basicinfo']['name'] ;?>
                                <span>  <?php 
                                        if(trim($user_info['basicinfo']['country'])!='')
                                            echo $user_info['basicinfo']['country'];else echo 'N/A';
                                ?></span>
                            </div>
                            
                            <div id="cnt-tab-yt" class="scio_cnt tab-content current">
                                <span class="col-sm-6 no-pad-sides vw">
                                    <span class="vw_ttl">Shares</span>
                                    <span class="vw_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-6 no-pad-sides lk">
                                    <span class="lk_ttl">Likes</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-12 no-pad-sides lk totalview">
                                    <span class="lk_ttl">Total Views</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                            <div id="cnt-tab-twt" class="scio_cnt tab-content">
                                <span class="col-sm-6 no-pad-sides vw">
                                    <span class="vw_ttl">Shares</span>
                                    <span class="vw_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-6 no-pad-sides lk">
                                    <span class="lk_ttl">Likes</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-12 no-pad-sides lk totalview">
                                    <span class="lk_ttl">Total Views</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                             <div id="cnt-tab-insta" class="scio_cnt tab-content ">
                                <span class="col-sm-6 no-pad-sides vw">
                                    <span class="vw_ttl">Shares</span>
                                    <span class="vw_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-6 no-pad-sides lk">
                                    <span class="lk_ttl">Likes</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-12 no-pad-sides lk totalview">
                                    <span class="lk_ttl">Total Views</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                             <div id="cnt-tab-fb" class="scio_cnt tab-content">
                                <span class="col-sm-6 no-pad-sides vw">
                                    <span class="vw_ttl">Shares</span>
                                    <span class="vw_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-6 no-pad-sides lk">
                                    <span class="lk_ttl">Likes</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-12 no-pad-sides lk totalview">
                                    <span class="lk_ttl">Total Views</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                             <div id="cnt-tab-ytl" class="scio_cnt tab-content ">
                                <span class="col-sm-6 no-pad-sides vw">
                                    <span class="vw_ttl">Shares</span>
                                    <span class="vw_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-6 no-pad-sides lk">
                                    <span class="lk_ttl">Likes</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-12 no-pad-sides lk totalview">
                                    <span class="lk_ttl">Total Views</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                             <div id="cnt-tab-tmb" class="scio_cnt tab-content ">
                                <span class="col-sm-6 no-pad-sides vw">
                                    <span class="vw_ttl">Shares</span>
                                    <span class="vw_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-6 no-pad-sides lk">
                                    <span class="lk_ttl">Likes</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <span class="col-sm-12 no-pad-sides lk totalview">
                                    <span class="lk_ttl">Total Views</span>
                                    <span class="lk_cnt">2.7K</span>
                                </span>
                                <div class="clearfix"></div>
                            </div>

                            <div class="btn_sec">
                                <button class="btn btn-sm btn-success"><i class="fa fa-send"></i>Send invite</button>
                                <button class="btn btn-sm btn-danger"><i class="fa fa-youtube-play"></i>Youtube</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="tbl_sec">
                <?php 
                        if(count($user_info['audience_geography'])>0) :
                        
                                ?>
                            <div class="tbl_ttl">
                                <h4>Audience Geography</h4>
                            </div>
                            <table class="table">
                                <thead>
                                  
                                    <tr>
                                        <th>Country</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($user_info['audience_geography'] as $geo): ?>
                                    <tr>
                                        <td><?php echo $geo->country_code?></td>
                                        <td><?php echo $geo->number_user?>%</td>
                                      
                                    </tr>
                               <?php endforeach;
                                    ?>                              
                                </tbody>
                            </table>

                            <?php
                            endif; 
                        if(count($user_info['audience_demography'])>0) :
                                ?>
                                
                            <div class="tbl_ttl">
                                <h4>Audience Demographic</h4>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Age Range</th>
                                        <th>Female</th>
                                        <th>Male</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                               
                                    foreach($user_info['audience_demography'] as $demo): ?>
                                    <tr>
                                        <td><?php echo $demo->age_range?></td>
                                        <td><?php echo $demo->number_male?>%</td>
                                        <td><?php echo $demo->number_female?>%</td>
                                    </tr>
                               <?php endforeach;
                               
                               
                    

                                ?>
                                   
                                                 
                                </tbody>
                            </table>    
                            <?php endif;?>                    
                        </div>
                    </div> 