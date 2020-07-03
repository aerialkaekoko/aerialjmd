<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>AIG</title>
    <link rel="stylesheet" href="style.css" media="all" />
    <style type="text/css">
      .clearfix:after {
        content: "";
        display: table;
        clear: both;
      }

      a {
        color: #5D6975;
        text-decoration: underline;
      }

      body {
        position: relative;
        /*width: 18cm; */ 
        height: 29.7cm; 
        margin: 0 auto; 
        color: #001028;
        background: #FFFFFF; 
        font-family: Arial, sans-serif; 
        font-size: 12px; 
        font-family: Arial;
      }

      header {
        padding: 10px 0;
        margin-bottom: 30px;
      }

      #logo {
        text-align: center;
        margin-bottom: 10px;
      }

      #logo img {
        width: 90px;
      }

      h1.invoice-title{
        border-top: 1px solid  #007bff;
        border-bottom: 1px solid  #007bff;
        color: #FFFFFF;
        font-size: 2.4em;
        line-height: 1.4em;
        font-weight: normal;
        text-align: center;
        margin: 0 0 20px 0;
        background: #007bff;
        /*background: url(dimension.png);*/
      }

      #project {
        float: left;
      }

      #project span {
        color: #5D6975;
        text-align: right;
        width: 52px;
        margin-right: 10px;
        display: inline-block;
        font-size: 0.8em;
      }

      #company {
        float: right;
        text-align: right;
      }

      #project div,
      #company div {
        white-space: nowrap;        
      }

      table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
      }

      table tr:nth-child(2n-1) td {
        background: #F5F5F5;
      }

      table th,
      table td {
        text-align: center;
      }

      table th {
        padding: 5px 20px;
        color: #5D6975;
        border-bottom: 1px solid #C1CED9;
        white-space: nowrap;        
        font-weight: normal;
      }

      table .service,
      table .desc {
        text-align: left;
      }

      table td {
        padding: 20px;
        text-align: right;
      }

      table td.service,
      table td.desc {
        vertical-align: top;
      }

      table td.unit,
      table td.qty,
      table td.total {
        font-size: 1.2em;
      }

      table td.grand {
        border-top: 1px solid #5D6975;;
      }

      #notices .notice {
        color: #5D6975;
        font-size: 1.2em;
      }

      footer {
        color: #5D6975;
        width: 100%;
        height: 30px;
        position: absolute;
        bottom: 0;
        border-top: 1px solid #C1CED9;
        padding: 8px 0;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <!-- <img src="logo.png"> -->
        <h1>Logo</h1>
      </div>
      <h1 class="invoice-title">AIG INVOICE</h1>
      
      <div id="project">
        <div><span>HOSPITAL</span> Royal Aisa</div>
        <div><span>CLIENT</span> John Doe</div>
        <div><span>ADDRESS</span> Hlaing , Yangon</div>
        <div><span>EMAIL</span> <a href="mailto:john@example.com">john@example.com</a></div>
        <div><span>DATE</span> November 27, 2019</div>
        <div><span>DUE DATE</span> December 27, 2019</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">SERVICE</th>
            <th class="desc">DESCRIPTION</th>
            <th>PRICE</th>
            <th>TAX</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="service">Translator</td>
            <td class="desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
            <td class="unit">$40.00</td>
            <td class="qty">0.3</td>
            <td class="total">$1,040.00</td>
          </tr>
          <tr>
            <td class="service">Medical Charges</td>
            <td class="desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
            <td class="unit">$400.00</td>
            <td class="qty">0.5</td>
            <td class="total">$3,200.00</td>
          </tr>
          <tr>
            <td class="service">Services</td>
            <td class="desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
            <td class="unit">$40.00</td>
            <td class="qty">0.2</td>
            <td class="total">$800.00</td>
          </tr>
          <tr>
            <td class="service">Car Service</td>
            <td class="desc">ILorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
            <td class="unit">$40.00</td>
            <td class="qty">0.4</td>
            <td class="total">$160.00</td>
          </tr>
          <tr>
            <td colspan="4">SUBTOTAL</td>
            <td class="total">$5,200.00</td>
          </tr>
          <tr>
            <td colspan="4">TAX 25%</td>
            <td class="total">$1,300.00</td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">GRAND TOTAL</td>
            <td class="grand total">$6,500.00</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
      <div id="company" class="clearfix">
        <div>Company Name</div>
        <div>No5. HinThaDa St,<br /> Sanchaung, Yangon</div>
        <div>(+95) 9 354 549</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>