<h2><?php 

if($tab_active=='staff') echo 'Staff ';else echo 'Dealer ';?>Sales Report</h2>

<table class="report_sec text-center"  border="1">
      <thead>
        <tr class="th_head row m-0">
             <td>S.n</td>
             <td class="col-xs-3 fw-6"><h4>Dealer</h4></td>
             <td class="col-xs-9"><h4>Staff </h4></td>
             <td class="col-xs-3 fw-6"><h4>Outlet</h4></td>
             <td class="col-xs-9"><h4>Outlet Type</h4></td>
           
             <td class="col-xs-9"><h4>Model</h4></td>
             <td class="col-xs-3 fw-6"><h4>IMEI No</h4></td>
             <td class="col-xs-9"><h4>Color</h4></td>
             <td class="col-xs-3 fw-6"><h4>Invoice ID</h4></td>
             <td class="col-xs-3 fw-6"><h4>Invoice Date</h4></td>
             <td class="col-xs-9"><h4>Submission Date</h4></td>
             <td class="col-xs-3 fw-6"><h4>Incentive Name</h4></td>
             <td class="col-xs-3 fw-6"><h4>Incentive Program Date/Period</h4></td>
             <td class="col-xs-9"><h4><?php if($tab_active=='staff') echo 'Staff ';else echo 'Dealer ';?>Incentive </h4></td>
        </tr>
      </thead>
      <tbody>
        
     
        <?php  
        $incentivedetail=array();
        $salescount=array();
        $total_incentiveuser=0;
         $i=1;
        
     if($sales_report)
     {
        foreach($sales_report as $report)
        {       
          $incentivedetail=$this->general->get_single_row('incentive',array('id'=>$report->incentive));
                     
            if($report->incentive!='')
            {
                
                    $total_incentiveuser=0;
                    if($tab_active=='dealer')
                    {
                         if(isset($salescount[$report->incentive][$report->dealer_id]))
                           {
                                $salescount[$report->incentive][$report->dealer_id]+=1;  
                           }
                           else
                           {
                             $salescount[$report->incentive][$report->dealer_id]=1;
                           }
                         $currentsalescount=$salescount[$report->incentive][$report->dealer_id];
                         $rewardtype=$incentivedetail->dealer_reward_type;
                         $target_type='D';
                    }
                    else
                    {
                         if(isset($salescount[$report->incentive][$report->user_id]))
                           {
                                $salescount[$report->incentive][$report->user_id]+=1;  
                           }
                           else
                           {
                             $salescount[$report->incentive][$report->user_id]=1;
                           }
                             $currentsalescount=$salescount[$report->incentive][$report->user_id];
                             $rewardtype=$incentivedetail->staff_reward_type;
                              $target_type='S';
                    }
                  
                   
                  
                    $incentivetarget=$this->general->get_data('incentive_target',array('incentive_id'=>$report->incentive,'target_type'=>$target_type));
                  
                    if($rewardtype=='1')
                          {
                              foreach($incentivetarget as $incentive)
                              {   
                                  $remaining_sales=$currentsalescount-$incentive->initial_target_amount+1;
                                  if($currentsalescount > $incentive->final_target_amount)
                                  {
                                       $total_incentiveuser =($incentive->incentive)* ($incentive->final_target_amount-$incentive->initial_target_amount+1);    
                                  }
                                  else
                                  {
                                     if($currentsalescount<$incentive->initial_target_amount)
                                     {
                                          break;
                                     }
                                     else
                                     {
                                       $total_incentiveuser = (($incentive->incentive));
                                       break;
                                     }
                                      
                                  }
                                  
                              }
                          }
                          else
                          {
                            $salescountnew=array();
                             foreach($sales_report as $rereport)
                             {
                                if($rereport->incentive!='')
                                {
                                  $incentivedetailreward =$this->general->get_single_row('incentive',array('id'=>$rereport->incentive));
                               
                                if($tab_active=='dealer' && $incentivedetailreward->dealer_reward_type=='2')
                                {
                                     if($rereport->dealer_id==$report->dealer_id && $report->incentive==$rereport->incentive)
                                     {

                                         if(isset($salescountnew[$report->incentive][$report->dealer_id]))
                                           {
                                               $salescountnew[$report->incentive][$report->dealer_id]+=1;  
                                           }
                                           else
                                           {
                                              $salescountnew[$report->incentive][$report->dealer_id]=1;
                                           }
                                            $currentsalescountnew=$salescountnew[$report->incentive][$report->dealer_id];
                                     }
                                       
                                }
                                if($tab_active=='staff' && $incentivedetailreward->staff_reward_type=='2')
                                {
                                     if($rereport->user_id==$report->user_id && $report->incentive==$rereport->incentive)
                                     {

                                        if(isset($salescountnew[$report->incentive][$report->user_id]))
                                           {
                                               $salescountnew[$report->incentive][$report->user_id]+=1;  
                                           }
                                           else
                                           {
                                              $salescountnew[$report->incentive][$report->user_id]=1;
                                           }
                                            $currentsalescountnew=$salescountnew[$report->incentive][$report->user_id];
                                     }
                                       
                                }
                           
                            }
                          }
                                
                           $targetrange=$this->general->get_incentive_salescount($report->incentive,$currentsalescountnew, $target_type);

                           $total_incentiveuser =  ($targetrange->incentive);
                      }
            }
            else
            {
                $total_incentiveuser=0;
            }
            ?>

        <tr class="row m-0">
            <td><?php echo $i;?></td>
            <td class="col-xs-3"><?php echo $report->dealer; ?></td>
            <td class="col-xs-9"><?php  echo $report->staff;  ?></td>
            <td class="col-xs-3"><?php echo $report->outlet; ?></td>
            <td class="col-xs-9"><?php  echo $report->type;  ?></td>
          
            <td class="col-xs-9"><?php  echo $report->model;  ?></td>
            <td class="col-xs-3"><?php echo $report->imei; ?></td>
            <td class="col-xs-9"><?php  echo $report->color;  ?></td>
             <td class="col-xs-3"><?php echo $report->invoice_id; ?></td>
            <td class="col-xs-3"><?php echo date('Y-m-d',strtotime($report->invoice_date)); ?></td>
            <td class="col-xs-9"><?php echo date('Y-m-d',strtotime($report->submit_date)); ?></td>
            <td class="col-xs-3"><?php echo $incentivedetail->name; ?></td>
            <td class="col-xs-3"><?php
            if(is_object($incentivedetail) && count($incentivedetail)>0)
            {

             if($incentivedetail->start_date!='') echo date('F d Y', strtotime($incentivedetail->start_date)) .' to '. date('F d Y', strtotime($incentivedetail->end_date));
            } ?>
            </td>
            <td><?php echo $total_incentiveuser;?></td>
        </tr>
        <?php 
        $i++;
        }
        }
        else
        { ?>
        <tr class="text-center"><td colspan="2">No data found.</td></tr>
        <?php  
        } ?>
      </tbody>
      </table>