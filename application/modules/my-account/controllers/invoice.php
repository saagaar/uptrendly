<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta name="author" content="Script Tutorials" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>:: Poplr ::</title>
    <link rel="shortcut icon" href="images/fav.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,700" rel="stylesheet">
    <style>
      ul { list-style:none; padding-left:0;}
      .container{ position:relative; margin: 30px 40px; border:1px solid; min-height:100vh; font-family:'raleway'; font-size:14px; padding:30px;}
      .trans_date { position:absolute; top:20px; right:20px; }
      ul.header { font-size:20px; font-weight:600; padding-left: 0; margin-top:50px;  }
      ul.header li { text-align:center; line-height:27px; }
      .invoice_title h1 { font-size: 35px; text-transform: uppercase; text-align: center; margin-top: 30px; }
      .invoice_pin { display:inline-block; }
      ul.tpin { display:inline-block; border:1px solid; }
      ul.tpin li { float:left; width:25px; border-left:1px solid; line-height:30px; min-height:30px;}
      ul.tpin li:first-child { border-left:none; }

      .invoice_no { float:right; line-height:50px; font-size:18px; }
      .cust_info { margin-top:30px; }
      table { width:100%; border-collapse:collapse; }
      .text-left { text-align:left; }
      .text-center { text-align:center; }
      .text-right { text-align:right; }
      .cust_info table td { padding:8px 0;  }
      .invoice_table table { border:1px solid;}
      .invoice_table thead th, .invoice_table tbody td { border-left:1px solid; padding: 5px 10px; }
      .invoice_table thead th { border-bottom:1px solid ; }
      .invoice_table thead th:first-child, .invoice_table tbody td:first-child { border-left:0; }
      
      .invoice_table tbody tr.for_blank td { padding:15px;  }

      .top_border { border-top:1px solid; }
      .pull-right { float:right; }
      
      .bottom_sec { margin-top:80px; margin-bottom:40px; }
      .note { font-size:12px; }
    </style>
  </head>
  <body>

    <div class="container">
      <div class="trans_date">
        Transaction Date:<br>
        <span>18-MAR-17 09:15:01</span>
      </div>
      <ul class="header">
        <li><?php echo WEBSITE_NAME?></li>
        <li>Example location, location</li>
        <li>Tel: 061-0124-124, 061-1239-452 Fax: +012-1498-123</li>
        <li>Email: info@poplr.com</li>
      </ul>

      <div class="invoice_title">
        <h1>Sample Invoice</h1>
      </div>
      <div class="invoice_id">
        <div class="invoice_pin">
          <b>TPIN</b> 
          <br>
            <ul class="tpin">
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
            </ul>
        </div>
        <div class="invoice_no">
          <b>Invoice No.: </b> 53141
        </div>
      </div>
      
      <div class="cust_info">
        <table>
          <tbody>
            <tr>
              <td width="15%"><b>UserName:</b></td>
              <td>sagarchapagain</td>
              <td width="17%"><b>Subscriber's Name:</b></td>
              <td>Sagar</td>
            </tr>
            <tr>
              <td><b>Address:</b></td>
              <td>unpark, chakupat</td>
              <td><b>Tel:</b></td>
              <td>0193471095709137501</td>
            </tr>
            <tr>
              <td><b>TPIN</b></td>
              <td><ul class="tpin">
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
            </ul></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="invoice_table">
        <table>
          <thead>
            <tr>
              <th width="7%">S.no.</th>
              <th width="35%" class="text-left">Particulars</th>
              <th class="text-left">Description</th>
              <th width="15%">Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center">1</td>
              <td>Email</td>
              <td>this is a sample Description for the layout.</td>
              <td class="text-right">500.00</td>
            </tr>
            <tr>
              <td class="text-center">1</td>
              <td>Email</td>
              <td>this is a sample Description for the layout.</td>
              <td class="text-right">500.00</td>
            </tr>
            <tr>
              <td class="text-center">1</td>
              <td>Email</td>
              <td>this is a sample Description for the layout.</td>
              <td class="text-right">500.00</td>
            </tr>
            <tr>
              <td class="text-center">1</td>
              <td>Email</td>
              <td>this is a sample Description for the layout.</td>
              <td class="text-right">500.00</td>
            </tr>

            <!-- for space-->
            <tr class="for_blank">
              <td class="text-center"></td>
              <td></td>
              <td></td>
              <td class="text-right"></td>
            </tr>
            <tr class="for_blank">
              <td class="text-center"></td>
              <td></td>
              <td></td>
              <td class="text-right"></td>
            </tr>
            <tr class="for_blank">
              <td class="text-center"></td>
              <td></td>
              <td></td>
              <td class="text-right"></td>
            </tr>
            <tr class="for_blank">
            <tr>
              <td class="text-center"></td>
              <td></td>
              <td></td>
              <td class="text-right"></td>
            </tr>
            <!-- for space -->
            <tr class="top_border">
              <td class="text-center" rowspan="5" colspan="2"><b>Cash</b><br>Cash/Cheque </td>
              <td class="text-right"><b>Total</b></td>
              <td class="text-right"><b>2000</b></td>
            </tr>
            <tr class="top_border">
              <td class="text-right"><b>Discount</b></td>
              <td class="text-right"><b>200</b></td>
            </tr>
            <tr class="top_border">
              <td class="text-right"><b>Taxable Amount</b></td>
              <td class="text-right"><b>100</b></td>
            </tr>
            <tr class="top_border">
              <td class="text-right"><b>Vat 13%</b></td>
              <td class="text-right"><b>180</b></td>
            </tr>
            <tr class="top_border">
              <td class="text-right"><b>Total Amount</b></td>
              <td class="text-right"><b>1520</b></td>
            </tr>
          </tbody>
        </table>

        <div class="bottom_sec">
          <b>In words:</b> One thousand five hunderd and twenty
          <span class="pull-right">
            _________________________________
            <br>
            Poplr website example name
          </span>
        </div>
      </div>

      <div class="note"><b>Note: </b> This is a computer generated invoice.</div>



    </div>

  </body>
</html>