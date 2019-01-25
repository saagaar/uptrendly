<div class="col-md-8 col-sm-7">



    <div class="log-form">


        <h4>Completed Transactions</h4>

            <?php 

            if($this->session->flashdata('error_message')) { ?>

                <p class="text-danger"><?php echo $this->session->flashdata('error_message'); ?></p>

              <?php } elseif($this->session->flashdata('success_message')) {?>

                <p class="text-success"><?php echo $this->session->flashdata('success_message'); ?></p>

            <?php } ?>

         <?php   
         if($transactions) { 
             ?>

        <table class="table table-hover footable">

                    <thead>

                        <tr>

                            <th data-hide="phone" width="10%">ID</th>

                            <th data-class="expand"  width="35%">Package Name</th>

                            <th data-hide="phone" width="20%">Package Type</th>

                            <th data-hide="phone" width="20%">Package Price</th>

                            <th data-hide="phone" width="10%">Date And Time</th>

                        </tr>

                    </thead>

                    <tbody>

                    

                    <?php 
                    $i=1;
                    foreach($transactions as $item) {

                        ?>

                        <tr>

                            <td><?php echo $i; ?></td>

                            <td><?php echo $item->transaction_name; ?></td>

                            <td><?php echo ($item->package_type); ?></td>

                            <td><?php echo  DEFAULT_CURRENCY_CODE.$item->amount ?></td>

                            <td><?php echo $this->general->date_month_year_time_format($item->transaction_date); ?></td>

                       

                        </tr>

                    <?php
                    $i++;
                } ?>

                    </tbody>

                </table>

                 <?php if($pagination_links):?>

        <div class="pagination"> <?php echo $pagination_links; ?> </div>


        <?php endif; ?>

                <?php  } else { echo "No Transaction History"; } ?>

         

         </div>

        

</div>

