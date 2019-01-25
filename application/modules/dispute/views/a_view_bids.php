<section class="title">
  <div class="wrap">
    <h2><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Post Management</h2>
  </div>
</section>

<article id="bodysec" class="sep">
	<div class="wrap">
  <pre><?php //print_r($bids_data);?></pre>
		<aside class="lftsec"><?php $this->load->view('menu'); ?></aside>
		<section class="smfull">
			<div class="box_block">
            
            
           		<table width="70%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full">
    				<tr>
                      <td width="7%"><strong>Product Id </strong></td>
                      <td width="15%"><?php echo $this->uri->segment('4');?></td>
                      <td width="7%"><strong>Product Name </strong></td>
                      <td width="15%"><?php echo $product_data->name; ?></td>
                    </tr>
                   
                   <tr>
                   		<td><strong>Product Price </strong></td>
                      	<td><?php echo DEFAULT_CURRENCY_SIGN.' '.$product_data->budget;?></td>
                       <td><strong>Total Bids Placed </strong></td>
                      <td><?php echo $total_bids;?></td> </tr>
                   
                   
                    
  				</table>
           <br /><br />
            
  				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbl_list tbl_full" >
    				<thead>
                        <tr>
                            <th width="10%">Product. Id</th>
                            <th width="10%">Bidder ID</th>
                            <th width="15%">Bidder Name</th>
                            <th width="10%">Bid Amount</th>
                            <th width="10%">Bid Fee</th>
                            <th width="15%">Bid Date</th>
                        </tr>
                    </thead>
    				<tbody>
					<?php 
                    $sn_count=0;
                    if($bids_data)
                    {
                        foreach($bids_data as $value)
                        { ?>
                          <tr>
                            <td><?php echo $value->id;?></td> 
                            <td><?php echo $value->user_id;?></td>
                            <td><?php echo $value->first_name." ".$value->last_name;?></td>
                            <td><?php echo $value->user_bid_amt;?></td>
                            <td><?php if(isset($value->user_bid_fee)){echo $value->user_bid_fee; }?></td>
                            <td><?php echo $this->general->long_date_time_format($value->bid_date);?></td>
                          </tr>
                        <?php 
                        }
                    }
                    ?>
                </tbody>
  				</table>
  			</div>
             <?php if ($links) { echo "<ul class='pagination'>".$links."</ul>"; } ?>
               <input type="hidden"  id="productid" value="<?php  echo $this->uri->segment('4');?>">
           <div id="chart_div"></div>
           
           </div>
		</section>
  		<div class="clearfix"></div>
	</div>

</article>



<div> </div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   

        <script type="text/javascript">

$(function () {      
      google.charts.load('current', {'packages':['corechart']});
      // Set a callback to run when the Google Visualization API is loaded.
       google.charts.setOnLoadCallback(drawChart);
    });

    function drawChart() {
        var product=$('#productid').val();
        var url="<?php echo site_url('/'.MY_ACCOUNT.'getbidbyproduct')?>"+'/'+product;
   
        var data = new google.visualization.DataTable();
        
    
  $.getJSON(url, function(jsonData) {
    console.log(jsonData);
        data.addColumn('string', 'Day');
        data.addColumn('number', 'Bidding Amount');
        data.addRows(jsonData);
        var options = {
          title: 'Bid amount Vs Bid Date',
          pointSize: 10,
          curveType: 'function',
           pointShape: 'square',
          hAxis: {
            gridlines: {count: 15}
          },
          vAxis: {
            gridlines: {color: 'none'},
            minValue: 0
          }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        var button = document.getElementById('change');
        // button.onclick = function () {
        //   // If the format option matches, change it to the new option,
        //   // if not, reset it to the original format.
        //   // options.hAxis.format === 'M/d/yy' ?
        //   // options.hAxis.format = 'MMM dd, yyyy' :
        //   // options.hAxis.format = 'M/d/yy';
        //   chart.draw(data, options);
        // };
    }); 
 }
      // Create our data table out of JSON data loaded from server.
     
        // </script>