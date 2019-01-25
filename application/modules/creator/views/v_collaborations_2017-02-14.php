
<div class="mid-part margin_0">
    <div class="msz_filter_sec">
    <div class="col-xs-6 col-sm-4 col-md-3">
    <form class="form-inline search">
    <input type="text" class="form-control name" id="exampleInputName2"  placeholder="Jane Doe"><button class="btn filteroptname" type="submit"><i class="fa fa-search"></i></button></form>
    </div>
    <div class="col-xs-6 pull-right text-right">
    <ul class="list-unstyled">
                 <li>
                   <select class="mediachannel filteropt btn btn-default">
                        <option value="">Channel</option>
                      <?php
                          $socialmedia=$this->general->get_socialmedia_channel();
                          foreach($socialmedia as $channel)
                          {
                            echo '<option  value='."$channel->id".'>'. ucfirst($channel->media_type).'</option>';
                          }

                      ?>
                    </select>
                 </li>
                 
                <li>
                    <select  class="btn btn-default filteropt fancount">
                        <option value="">Filter by Likes</option>
                        <option value="1000">&lt;1K</option>
                        <option value="5000">&lt;5K</option>
                        <option value="10000">&lt;10K</option>
                        <option value="50000">&lt;50K</option>
                        <option value="100000">&lt;1M</option>
                    </select>
                </li>
            <li><a href="#" class="btn btn-default"><i class="fa fa-refresh"></i></a></li>
          </ul></div>
  <div class="clearfix"></div>
    </div>
 <div class="img-loader" style="z-index:1000;display: none">
                <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
       </div>
  <div class="grid filterview">
    <?php
        $this->load->view('creator/ajax-collab');
    ?>  
  </div>
        
<!----- send proposal modal ---->

<!-- <div id="sendprop_popup" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="sendprop_modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style=" margin:8px;"><span aria-hidden="true" class="fa fa-times"></span></button>
                <div class="sendprop_modal_container">
                    <div class="modal_title">
                        <h2>Send Collab Proposal</h2>
                        <p>Tell the fellow creator what kind of collab you want to create, topics, etc.</p>
                        <div style="clear: both;"></div>
                    </div>
                    <div class="body">
                        <div class="col-sm-12 clearfix">
                            <div class="col-sm-1 no-pad-sides marg-bottom-10">
                                <div class="text-center">
                                    <img src="imgs/128-youtube.png" class="avatar"/>
                                </div>
                            </div>
                            <div class="col-sm-10 pad-sides-5">
                                <div class="input-group date">
                                    <input type="text" class="form-control" /><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-1 no-pad-sides">
                                <i class="fa fa-times"> </i>
                            </div>
                        </div>
                        <div class="col-sm-12 clearfix">
                            <textarea  rows="8" class="form-control" placeholder="Describe your offering, what kind of content you want to create and why you should be hired!"></textarea>
                            
                            <div class="clear"></div>
                        </div>
                        <div class=" col-sm-12 bottom_content">
                            <div class="col-sm-4">
                                <button class="btn btn-success"><i class="fa fa-check"></i> Send Proposal</button>
                            </div>
                            <div class="col-sm-3">
                                <span class="text-right"> Expire Date:</span>
                            </div>
                            <div class="col-sm-5 no-pad-left">
                                <div class="input-group date">
                                    <input type="text" class="form-control"/><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                </div>                                                               
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <div style="clear: both;"></div>
                </div>
                
                
                  
            </div>
        </div>
    </div>
</div> -->


  <script type="text/javascript">
    
    var action='<?php echo site_url('/'.CREATOR.'ajax_collab')?>';

  </script>