
<div class="mid-part">

<div class="main-ttl">
<div class="container">
  <h1>Help</h1>
</div>
<div class="clearfix"></div>
</div>

<div class=" container">
  <div class="cms_sec">
  <?php if($help_contents) { $count = 1; ?>
      <div class="panel-group" id="accordion">

        <?php foreach($help_contents as $help_content) { ?>
                    <div class="panel panel-default">
                      <div class="panel-heading">
                          <h3 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $count; ?>" class="collapsed">
                                  <?php echo $help_content->title; ?>
                              </a>
                          </h3>
                      </div>
                      <div class="panel-collapse collapse <?php if($count == 1) echo 'in'; ?>" id="collapse-<?php echo $count; $count++;?>">
                        <div class="panel-body">
                          <?php echo $help_content->description; ?>
                        </div>
                      </div>
                        </div> 
                <?php } ?>  
             </div>  
        <?php } else { ?> 
        <P>No Help content</P>
        <?php } ?>
    </div>
<div class="clearfix"></div>
</div>

<div class="clearfix"></div>
</div>