<div class="col-md-8 col-sm-7">
    <div class="log-form">
    <?php if($proposal_bids) { ?>
    	<table class="table table-hover footable">
            <thead>
                <tr>
                    <th data-hide="phone">Auction ID</th>
                    <th data-class="expand">Auction Name</th>
                    <th data-hide="phone">Budget</th>
                    <th data-hide="phone">Date & Time</th>
                    <th data-hide="phone">View</th>
                </tr>
            </thead>
            <tbody>	
            <?php foreach($proposal_bids as $proposal_bid) { ?>
                <tr>
                    <td><?php echo $proposal_bid->product_code; ?></td>
                    <td><?php echo $proposal_bid->name; ?></td>
                    <td><?php echo $proposal_bid->user_bid_amt; ?></td>
                    <td><?php echo $this->general->date_month_year_time_format($proposal_bid->bid_date); ?></td>
                    <td><a href="<?php echo site_url('/'. MY_ACCOUNT. 'auction_detail/'. $proposal_bid->prd_id); ?>">Detail</a></td>
                </tr>                
                
            <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
            No proposal bids yet
        <?php  }?>
    </div>
</div>