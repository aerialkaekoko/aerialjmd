<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style>
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px;
        }
       
        table th, table td {
        border: 1px solid black;
        padding: 3px 7px;
        }
        table.invoice-footer th,
        table.invoice-footer td{
            border: none !important;
        }
        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            font-size: 25px;
            font-weight: bold;
        }

        footer {
            position: fixed; 
            bottom: 0px; 
            left: 0px; 
            right: 0px;
        }
        .text-right{
            text-align: right;
        }
        .text-center{
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
            Blue Assistance Co.,Ltd
    </header>
    <main>
        {{-- {{dd($invoice->medical_expenses)}} --}}
       <table width="100%" style="margin-top:20px">
           <tr>
               <th width="50%">Summary Invoice</th>
               <th width="50%" class="text-right">Date : {{date('d F Y')}}</th>
     `      </tr>
       </table>
       <table width="100%" style="margin-top:20px;">
           <tr>
               <th width="100%" colspan="4" class="text-center">(Original Delivery Order/ Original Invoice)</th>
           </tr>
           <tr>
               <td width="5%">FROM</td>
               <td width="45%">ACCOUNTING DEPT.</td>
               <td width="5%">To</td>
               <td width="45%">PRESTIGE INTERNATIONAL (S) PTE LTD</td>
           </tr>
           <tr>
               <td></td>
               <td>BLUE ASSISTANCE CO.,LTD.</td>
               <td></td>
               <td> Claims Division</td>
           </tr>
           <tr>
               <td></td>
               <td>24 SUKHUMVIT SOI 21 SUKHUMVIT ROAD (ASOKE).</td>
               <td></td>
               <td>  583 Orchard Road #09-03</td>
           </tr>
           <tr>
               <td></td>
               <td>KLONGTOEY NUA WATTANA BKK 10110</td>
               <td></td>
               <td> Forum,Singapore 238884</td>
           </tr>
           <tr>
               <td></td>
               <td>BANGKOK 10110 </td>
               <td></td>
               <td>  TEL:+65-6832-07333 FAX:+65-6832-0738</td>
           </tr>
           <tr>
               <td></td>
               <td>TEL : +66 (2) 661 7687-8  FAX : +66 (2) 661 7689 </td>
               <td></td>
               <td></td>
           </tr>
           <tr>
               <td>Tax ID</td>
               <td colspan="3">0-1055-47166-10-2</td>
           </tr>
       </table>
       <table width="100%" style="margin-top:20px;">
           <tr height="60px">
               <td colspan="2" class="text-center">Description</td>
               <td class="text-center">Unit Price(MMK)</td>
               <td class="text-center">Unit Price(US$)</td>
               <td class="text-center">Amoun(US$)</td>
           </tr>
           @php
           $total = 0;
               $total += $summary_data['medical_amount_total'];
           @endphp
           <tr>
                <td colspan="2">Medical Amount Total</td>
                <td></td>
                <td class="text-right">US$ {{$summary_data['medical_amount_total']}}</td>
                <td class="text-right">US$ {{$summary_data['medical_amount_total']}}</td>
           </tr>
            <tr>
                <td colspan="2">Other Amount Total</td>
                <td></td>
                <td class="text-right">US$ {{$summary_data['other_charges_total']}}</td>
                <td class="text-right">US$ {{$summary_data['other_charges_total']}}</td>
            </tr>
            @php
                $total += $summary_data['other_charges_total'];
            @endphp
           <tr>
               <td colspan="2" rowspan="3"></td>
               <td></td>
               <td class="text-right">Sub total amount (USD)</td>
               <td class="text-right">US$ {{$total}}</td>
           </tr>
           <tr>
               <td></td>
               <td class="text-right">Vatable Total</td>
               <td class="text-right">US$ {{$summary_data['other_charges_total']}}</td>
           </tr>
           <tr>
               <td></td>
               <td class="text-right">Vat 5% Total</td>
               <td class="text-right">US$ {{$summary_data['vatable_amount']}}</td>
           </tr>
           <tr>
                <td colspan="2">#NAME?</td>
                <td></td>
                <td class="text-right">Non-Vatable</td>
                <td class="text-right">US$ {{$total - $summary_data['other_charges_total']}}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">Total Amount (USD)</td>
                <td class="text-right">US$ {{$total + $summary_data['vatable_amount']}}</td>
            </tr>
       </table>
       <table width="100%">
            <tr>
                <td>Bank Information for payment of above total amount is as follows: </td>
            </tr>
            <tr>
                <td>Bank Account Name : Blue Assistance Co., Ltd.    Bank Account No.  032-308374-5</td>
            </tr>
            <tr>
                <td>Bank Contract Detail : Siam Commercial Bank   Branch : Asoke Branch   Swift Code :SICOTHBK</td>
            </tr>
            <tr>
                <td>All Cheques should be made payable to '' Blue Assistance Co., Ltd. ''</td>
            </tr>
       </table>
    </main>
    <footer>
       <table width="100%" class="invoice-footer">
            <tr>
                <td class="text-center">RECEIVE INVOICE BY</td>
                <td class="text-center">Delivered </td>
                <td class="text-center">(Mr.Ryotaro Azuma )</td>
            </tr>
            <tr>
                <td >Date :</td>
                <td> Date :</td>
                <td class="text-center">AUTHORIZED SINGNATURE</td>
            </tr>
        </table>
    </footer>

</body>
</html>`