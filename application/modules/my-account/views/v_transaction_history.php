<div class="col-md-12 col-sm-12">



    <div class="log-form tran_his">


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

                            <th data-hide="phone" width="8%" class="text-center">ID</th>

                            <th data-class="expand" >Transaction Name</th>
                            <th data-class="expand" class="text-center" >Campaign Name</th>

                            <th data-class="expand" class="text-center">Transaction Type</th>

                            <th data-hide="phone" class="text-center">Debit/Credit</th>

                            <th data-hide="phone" class="text-center">Top up Price</th>

                            <th data-hide="phone" class="text-center">Date And Time</th>

                        </tr>

                    </thead>

                    <tbody>

                    

                    <?php 
                    $i=1;
                    foreach($transactions as $item) {

                        ?>

                        <tr>

                            <td class="text-center"><?php echo $i; ?></td>

                         
                            
                            <td><?php echo $item->transaction_name; ?></td>
                            <td class="text-center"><?php echo $item->name; ?></td>
                            <td class="text-center"><?php echo $item->payment_method; ?></td>

                            <td class="text-center"><?php echo ($item->credit_debit); ?></td>

                            <td class="text-right"><?php echo  DEFAULT_CURRENCY_CODE.$item->amount ?></td>

                            <td class="text-center"><?php echo $this->general->date_month_year_time_format($item->transaction_date); ?></td>

                       

                        </tr>

                    <?php
                    $i++;
                } ?>

                    </tbody>

                </table>

                 <?php if($pagination_links):?>

        <div class=""> <?php echo $pagination_links; ?> </div>


        <?php endif; ?>

                <?php  } else { echo "No Transaction History"; } ?>

         

         </div>

        

</div>

