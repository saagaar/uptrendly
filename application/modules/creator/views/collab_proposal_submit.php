 <input type="hidden" class="form-control" id="productids" name="productid" value="" />


                <div class="facebookmain proposalform hidden">
                
                        <div class="col-sm-12 clearfix">
                                <div class="col-sm-1 no-pad-sides marg-bottom-10">
                                    <div class="text-center">
                                      <input type="hidden" class="form-control proposalformelement facebookelement" id="facebook_mediaid " name="facebook[mediaid]" value="<?php echo FACEBOOKMEDIAID;?>" disabled="disabled" />
                                       <span id="proposalmediaicon" class="round_btn round-icon facebook" ><i class="fa fa-facebook-f"></i></span>
                                    </div>
                                </div>
                                 <div class="col-sm-4">
                                  <input type="hidden" class="form-control bid_amount facebookelement proposalformelement" id="facebook_bid_amount" placeholder="Place your fee" name="facebook[bid_amount]" disabled="disabled" value="0" />                              
                                </div>
                                <div class="col-sm-10 pad-sides-5 no-pad-left">
                                    <div class="input-group delivery_date date">
                                        <input type="text" class="form-control delivery_date facebookelement proposalformelement" id="facebook_delivery_date" readonly name="facebook[delivery_date]" disabled="disabled" placeholder="Delivery Date" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-1 no-pad-sides">
                                    <i class="fa fa-times"> </i>
                                </div>
                        </div>
                        <div class="col-sm-12 clearfix">
                            <textarea  rows="8" class="form-control bid_details facebookelement proposalformelement" disabled="disabled" id="facebook_bid_details" name="facebook[bid_details]" placeholder="Describe your offering, what kind of content you want to create and why you should be hired!"></textarea>
                            
                            <div class="clear"></div>
                        </div>
                </div>
                <div class="youtubemain proposalform hidden">
                        <div class="col-sm-12 clearfix">
                                <div class="col-sm-1 no-pad-sides marg-bottom-10">
                                    <div class="text-center">
                                      <input type="hidden" class="form-control youtubeelement proposalformelement" disabled="disabled" id="youtube_mediaid" name="youtube[mediaid]" value="<?php echo YOUTUBEMEDIAID;?>" />
                                        <span id="proposalmediaicon" class="round_btn youtube round-icon proposalmediaicon"><i class="fa fa-youtube"></i></span>
                                    </div>
                                </div>
                                  <input type="hidden" class="form-control bid_amount youtubeelement proposalformelement" disabled="disabled" id="youtube_bid_amount" placeholder="Place your fee" name="youtube[bid_amount]" value="0" />                              
                               
                                <div class="col-sm-10 pad-sides-5 no-pad-left">
                                    <div class="input-group delivery_date date">
                                        <input type="text" class="form-control delivery_date youtubeelement proposalformelement" disabled="disabled" id="youtube_delivery_date"  name="youtube[delivery_date]" placeholder="Delivery Date" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-1 no-pad-sides">
                                    <i class="fa fa-times"> </i>
                                </div>
                        </div>
                        <div class="col-sm-12 clearfix">
                            <textarea  rows="8" class="form-control bid_details youtubeelement  proposalformelement" disabled="disabled" id="youtube_bid_details" name="youtube[bid_details]" placeholder="Describe your offering, what kind of content you want to create and why you should be hired!"></textarea>
                            
                            <div class="clear"></div>
                        </div>
                </div>
              <div class="instagrammain proposalform hidden">
                        <div class="col-sm-12 clearfix">
                                <div class="col-sm-1 no-pad-sides marg-bottom-10">
                                    <div class="text-center">
                                      <input type="hidden" class="form-control proposalformelement instagramelement" disabled="disabled" id="instagram_mediaid" name="instagram[mediaid]" value="<?php echo INSTAGRAMMEDIAID;?>" />
                                        <span id="proposalmediaicon" class="round_btn round-icon instagram proposalmediaicon"><i class="fa fa-instagram"></i></span>
                                    </div>
                                </div>
                                 <div class="col-sm-4">
                                  <input type="hidden" class="form-control bid_amount  instagramelement proposalformelement" disabled="disabled" id="instagram_bid_amount" placeholder="Place your fee" name="instagram[bid_amount]" value="0" />                              
                                </div>
                                <div class="col-sm-10 pad-sides-5 no-pad-left">
                                    <div class="input-group delivery_date date">
                                        <input type="text" class="form-control delivery_date instagramelement proposalformelement" disabled="disabled" id="instagram_delivery_date"  readonly name="instagram[delivery_date]" placeholder="Delivery Date" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-1 no-pad-sides">
                                    <i class="fa fa-times"> </i>
                                </div>
                        </div>
                       <div class="col-sm-12 clearfix">
                            <textarea  rows="8" class="form-control bid_details instagramelement  proposalformelement" disabled="disabled" id="instagram_bid_details" name="instagram[bid_details]" placeholder="Describe your offering, what kind of content you want to create and why you should be hired!"></textarea>
                            
                            <div class="clear"></div>
                        </div>
                </div>
                <div class="twittermain proposalform hidden">
                        <div class="col-sm-12 clearfix">
                                <div class="col-sm-1 no-pad-sides marg-bottom-10">
                                    <div class="text-center">
                                      <input type="hidden" class="form-control twitterelement proposalformelement" disabled="disabled" id="twitter_mediaid" name="twitter[mediaid]" value="" />
                                        <span id="proposalmediaicon" class="round_btn twitter round-icon proposalmediaicon"><i class="fa fa-twitter-square"></i></span>
                                    </div>
                                </div>
                                 <div class="col-sm-4">
                                <input type="number" class="form-control bid_amount  twitterelement proposalformelement" disabled="disabled" id="twitter_bid_amount" placeholder="Place your fee" name="twitter[bid_amount]" value="0" />                              
                                                               </div>
                                <div class="col-sm-10 pad-sides-5 no-pad-left">
                                    <div class="input-group delivery_date date">
                                        <input type="text" class="form-control delivery_date twitterelement proposalformelement" disabled="disabled" id="twitter_delivery_date" readonly name="twitter[delivery_date]" placeholder="Delivery Date" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-1 no-pad-sides">
                                    <i class="fa fa-times"> </i>
                                </div>
                        </div>
                        <div class="col-sm-12 clearfix ">
                            <textarea  rows="8" class="form-control bid_details twitterelement proposalformelement" disabled="disabled" id="twitter_bid_details" name="twitter[bid_details]" placeholder="Describe your offering, what kind of content you want to create and why you should be hired!"></textarea>
                            
                            <div class="clear"></div>
                        </div>
                </div>
                <div class="youtuleemain proposalform hidden">
                        <div class="col-sm-12 clearfix">
                                <div class="col-sm-1 no-pad-sides marg-bottom-10">
                                    <div class="text-center">
                                      <input type="hidden" class="form-control youtuleeelement proposalformelement" disabled="disabled" id="youtulee_mediaid" name="youtulee[mediaid]" value="<?php echo YOUTULEEMEDIAID;?>" />
                                      
                                        <span id="proposalmediaicon" class="round_btn youtulee round-icon proposalmediaicon btn-youtulee">   <img src="<?php echo site_url('/'.USER_IMG_DIR.'push.png')?>" alt="" width="50px"> </span>
                                    </div>
                                </div>
                                 <!-- <div class="col-sm-4">
                                  <input type="number" class="form-control  bid_amount youtuleeelement proposalformelement" disabled="disabled" id="youtulee_bid_amount" placeholder="Place your fee" name="youtulee[bid_amount]" value="" />                              
                                </div> -->
                                <div class="col-sm-10 pad-sides-5 no-pad-left">
                                    <div class="input-group delivery_date date">
                                        <input type="text" class="form-control delivery_date youtuleeelement proposalformelement" disabled="disabled" id="youtulee_delivery_date" readonly name="youtulee[delivery_date]" placeholder="Delivery Date" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-1 no-pad-sides">
                                    <i class="fa fa-times"> </i>
                                </div>
                        </div>
                        <div class="col-sm-12 clearfix">
                            <textarea  rows="8" class="form-control bid_details youtuleeelement proposalformelement" disabled="disabled" id="youtulee_bid_details" name="youtulee[bid_details]" placeholder="Describe your offering, what kind of content you want to create and why you should be hired!"></textarea>
                            
                            <div class="clear"></div>
                        </div>
                </div>
                 <div class="tumblrmain proposalform hidden">
                        <div class="col-sm-12 clearfix">
                                <div class="col-sm-1 no-pad-sides marg-bottom-10">
                                    <div class="text-center">
                                      <input type="hidden" class="form-control tumblrelement proposalformelement" disabled="disabled" id="tumblr_mediaid" name="tumblr[mediaid]" value="<?php echo TUMBLRMEDIAID;?>" />
                                        <span id="proposalmediaicon" class="round_btn tumblr round-icon proposalmediaicon"><i class="fa fa-tumblr"></i></span>
                                    </div>
                                </div>
                                 <div class="col-sm-4">
                                  <input type="hidden" class="form-control bid_amount  tumblrelement proposalformelement" disabled="disabled" id="tumblr_bid_amount" placeholder="Place your fee" name="tumblr[bid_amount]" value="0" />                              
                                </div>
                                <div class="col-sm-10 pad-sides-5 no-pad-left">
                                    <div class="input-group delivery_date date">
                                        <input type="text" class="form-control delivery_date tumblrelement proposalformelement" disabled="disabled" id="tumblr_delivery_date" readonly name="tumblr[delivery_date]" placeholder="Delivery Date" /><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-sm-1 no-pad-sides">
                                    <i class="fa fa-times"> </i>
                                </div>
                        </div>
                        <div class="col-sm-12 clearfix ">
                            <textarea  rows="8" class="form-control bid_details tumblrelement proposalformelement" disabled="disabled" id="tumblr_bid_details" name="tumblr[bid_details]" placeholder="Describe your offering, what kind of content you want to create and why you should be hired!"></textarea>
                            
                            <div class="clear"></div>
                        </div>
                </div>
  

  <script>
    $('.delivery_date.date').datepicker({
    format: "yyyy/mm/dd",
    startDate:new Date(),
    todayBtn: "linked",
    autoclose: true,
    // todayHighlight: true
    });
</script>