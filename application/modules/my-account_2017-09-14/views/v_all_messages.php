<link rel="stylesheet" href="http://202.166.198.151:8888/uptrendly/themes/user/css/selectize.default.css">
<script src="http://202.166.198.151:8888/uptrendly/themes/user/js/selectize.js"></script>


    <div class="msz_filter_sec">
    <div class="col-xs-6 col-sm-4 col-md-3">
    <form class="form-inline search" action='#'>
    <input type="text" class="form-control" id="filtersearchname" placeholder="Jane Doe"><button class="btn namefilterclick" type="submit"><i class="fa fa-search"></i></button></form>
    </div>

    <div class="col-xs-6 pull-right text-right">
  <!--   <ul class="list-unstyled">
                 <li>
                 <select class="btn btn-default"><option selected>All</option><option>Read</option><option>Unread</option></select></li>
                <li><a href="#" class="btn btn-default"><i class="fa fa-refresh"></i></a></li>
          </ul> --></div>
    <div class="clearfix"></div>
    </div> 
          
<div role="tabpanel" class="col-xs-12">
          <div class="row">
            <div class="col-sm-3"> <!-- required for floating --> 
              <!-- Nav tabs -->
              <ul class="list-unstyled msz_menu messagemenu">
                <li class="active">
                  <a href="#inbox_msz" data-type="inbox" class="messagetype" data-toggle="tab">
                    <span>Inbox</span>
                  </a>
                </li>
                <li>
                  <a href="#sent_msz" class="messagetype" data-type="sent" data-toggle="tab">
                    <span>Sent</span>
                  </a>
                </li>
               <!--  <li>
                  <a href="#draft_msz" class="messagetype" data-type="draft" data-toggle="tab">
                    <span>Draft</span>
                  </a>
                </li> -->
                <!-- <li>
                  <h4>CONTENT STATUS</h4>
                </li>
                <li>
                  <a href="#all_msz" class="messagetype" data-type="all" data-toggle="tab">
                    <span>ALL</span>
                  </a>
                </li>
                <li>
                  <a href="#production_msz" class="messagetype" data-type="production" data-toggle="tab">
                    <span>In Production</span>
                  </a>
                </li>
                <li>
                  <a href="#review_msz" class="messagetype" data-type="review" data-toggle="tab">
                    <span>In Review</span>
                  </a>
                </li>
                <li>
                  <a href="#action_required_msz" class="messagetype" data-type="action_required" data-toggle="tab">
                    <span>Changes Required</span>
                  </a>
                </li>
                <li>
                  <a href="#completed_msz" class="messagetype" data-type="completed" data-toggle="tab">
                    <span>Completed</span>
                  </a>
                </li> -->
                <li><a href="#create_msz"  class="messagetype" data-toggle="tab">Create Message</a></li> 
              </ul>
            </div>
              <!-- <div class="btn-img" style="float:left">
                  <div class="img-loader hidden" style="z-index:1000;">
                          <img src="<?php echo site_url('/'.USER_IMG_DIR.'ajax_loader.gif');?>">
                  </div>
              </div> -->
            <div class="col-sm-9 msz_sec message_list">
              <!-- <div class="text-right">
                <ul class="list-inline all-link">
                  <li><a href="#" class="btn btn-info"><i class="fa fa-check-square-o"></i> Select All</a></li>
                  <li><a href="#" class="btn btn-info"><i class="fa fa-reply"></i> Reply</a> </li>
                  <li><a href="#" class="btn btn-info"><i class="fa fa-mail-forward"></i> Forward</a> </li>
                  <li><a href="#" class="btn btn-info"><i class="fa fa-close"></i> Delete</a></li>
                </ul>
              </div> -->
              <!-- Tab panes -->
              <div class="tab-content messages">
                <div class="tab-pane fade in" id="create_msz" data-type="inbox">


                  <form name="send_message" id="send_message" method="post">
                  <div>
                  <div class="form-group row">  
                  <div class="col-xs-6">

                    <div class="demo">
                     
                       <div class="clearfix"></div>
                      <div class="control-group">
                        <input type="text" id="input-tags6" name="to" class="demo-default"  value="Admin">
                      </div>
                      <script>
                      $('#input-tags6').selectize({
                       
                        persist: false,
                        create: false
                      });
                      </script>
                    </div>
                        
                  </div>
                   <div class="control-group">
                      <select name="productid" id="productid" class="form-control">
                       <option value="0">General</option>
                       <?php foreach($active_products as $eachproduct):?>
                          <option value="<?php echo $eachproduct->product_id?>"><?php echo $eachproduct->name?></option>
                       <?php endforeach;?>
                      </select>

                      </div>
                  <!-- <div class="col-xs-6"><input type="text" name="" placeholder="CC" class="form-control"></div> -->
                  </div>
                  <div class="form-group"><input type="text" name="subject" id="subject" placeholder="Subject" class="form-control"></div>                    
                    <div class="form-group">
                      <textarea name="message" id="message" class="form-control messagecontent"  placeholder="Type message here.." rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-success btn btn-large messagesend" style="margin-top:20px;">Send</button>
                   </div>
                   </div>
                  </form>
                  <div class="clearfix"></div>
                </div>
                <div class="tab-pane fade in <?php if($view=='inbox') echo 'active';?>" id="inbox_msz">
                  <table class="footable">
                    <tbody >
                    <?php
                   
                    if($view=='inbox'){

                     $this->load->view('ajax_messages');
                    }
                    ?>
                      
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade in <?php if($view=='sent') echo 'active';?>" id="sent_msz">
                  <table class="footable">
                    <tbody >
                      <?php
                      
                    if($view=='sent'){

                     $this->load->view('ajax_messages');
                    }
                    ?>
                      
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade in <?php if($view=='all') echo 'active';?>" id="all_msz">
                  <table class="footable" >
                    <tbody >
                        <?php
                    if($view=='all'){

                     $this->load->view('ajax_messages');
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade in <?php if($view=='production') echo 'active';?>" id="production_msz">
                  <table class="footable">
                    <tbody>
                        <?php
                    if($view=='production'){

                     $this->load->view('ajax_messages');
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
                 <div class="tab-pane fade in <?php if($view=='review') echo 'active';?>" id="review_msz">
                  <table class="footable">
                    <tbody>
                          <?php
                    if($view=='review'){

                     $this->load->view('ajax_messages');
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
                 <div class="tab-pane fade in <?php if($view=='action_required') echo 'active';?>" id="action_required_msz">
                  <table class="footable">
                    <tbody>
                          <?php
                    if($view=='action_required'){

                     $this->load->view('ajax_messages');
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
                 <div class="tab-pane fade in <?php if($view=='completed') echo 'active';?>" id="completed_msz">
                  <table class="footable">
                    <tbody>
                          <?php
                    if($view=='completed'){

                     $this->load->view('ajax_messages');
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
                 
               <!--  <div class="tab-pane fade in <?php if($view=='review') echo 'active';?>" id="review_msz">
                  <table class="footable">
                    <tbody>
                          <?php
                    if($view=='review'){

                     $this->load->view('ajax_messages');
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade in <?php if($view=='changes_required') echo 'active';?>" id="changes_required_msz">
                  <table class="footable ">
                    <tbody>
                        <?php
                    if($view=='changes_required'){

                     $this->load->view('ajax_messages');
                    }
                    ?>
                    </tbody>
                  </table>
                </div> -->
                <div class="tab-pane fade in <?php if($view=='msgdetail') echo 'active';?>"" id="open_msz">
                        <?php
                    if($view=='msgdetail'){

                     $this->load->view('message_detail');
                    }
                    ?>
                </div>
              </div>
            </div>
          </div>
          
    </div>
<div class="clearfix"></div>

    <script type="text/javascript">
      var msglist='<?php echo site_url('/'.MY_ACCOUNT.'messages');?>';
      var msgdetail='<?php echo site_url('/'.MY_ACCOUNT.'Detailmessages');?>';
      var viewmessage='<?php echo site_url('/'.MY_ACCOUNT.'ajax_messages');?>';
      var messagedetail='<?php echo site_url('/'.MY_ACCOUNT.'getdetailmessage');?>';
      var sendmessage='<?php echo site_url('/'.MY_ACCOUNT.'send_message');?>';
 
    </script>
