 <ul class="dash_inner">
            <?php if (is_array($live_products) || is_object($live_products)){ ?>
            <?php foreach($live_products as $product) { ?>
                <li>
                  <a href="<?php echo site_url('/'.MY_ACCOUNT. 'auction_detail/'. $product->id); ?>"><?php echo $product->name; ?></a>
                    <p><?php echo $product->description; ?></p>
                    <span>End Date: <?php echo substr($this->general->format_date_time_auction($product->auc_end_time), 0, -9); ?> </span> <span><i class="fa fa-clock-o"></i> <?php echo substr($this->general->format_date_time_auction($product->auc_end_time), -9); ?></span>
                </li>                
              <?php }
                  }  ?>
              
            </ul>
            <section> 
              <!-- pagination-Sec -->  
              <nav class="pagination_sec">
                <ul class="pagination">
                  <?php if(isset($links)) { echo $links; }; ?>
                </ul>
                <div class="clearfix"></div>
              </nav>
              <!--/.end-->
            </section>