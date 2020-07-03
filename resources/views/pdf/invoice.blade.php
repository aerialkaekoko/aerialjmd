<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="charset=utf-8"/>
    <title>Invoice</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style>
        /** Define the margins of your page **/
        body{
            font-family: ipag;
        }
        @page {
            margin: 100px 25px;
        }
       
        table th, table td {
        border: 1px solid black;
        padding: 3px 7px;
        }
        table.invoice-footer{
          margin-top: -32px !important;
        }
        table.invoice-footer th,
        table.invoice-footer td{
            /*border: none !important;*/
            font-size: 14px;
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
        th.from,
        td.from{
          border-right: 1px solid #fff;
        }
        .table2 td,
        .table2 th{
          font-size: 12px;
        }
        .table3 th{
          font-size: 14px;
        }
        tr.accounting th{
          font-size: 14px;
        }
        .table-head tr.th-head th{
          font-size: 12px;
          border:none !important;
        }
    </style>
</head>
<body>
    <div class="original-invoice">
      <header>
        <table width="100%" class="table-head">            
            <tr class="th-head">
              <th width="50%" class="text-right">Date : {{date('d M Y')}}</th>
            </tr>
            <tr class="th-head">
              <th width="50%" class="text-right">INV. NO. :  {{ $invoice->invoice_code ?? ''}}</th>
            </tr>
            <tr>
              <th class="text-center">ORIGINAL INVOICE</th>
            </tr>
            
           </table>
      </header>
      <main>
          {{-- {{dd($invoice->medical_expenses)}} --}}
         <table width="100%" style="margin-top:28px">
            
             <tr>
                 <th width="50%" class="text-align: left;" style="border-right: 1px solid #FFF;">BA Ref. No. : {{ $invoice->medical_info->ba_ref_no ?? '' }}</th>
                 <th width="50%" class="text-right">Patient Name : {{ $invoice->medical_info->user->family_name ?? '' }}{{ $invoice->medical_info->user->name ?? '' }}</th>
             </tr>
             <tr>
                 <th width="50%" class="text-align: left;" style="border-right: 1px solid #FFF;">Case No : {{ $invoice->medical_info->gcl_case_no ?? '' }}</th>
                 <th width="50%" class="text-right">Treatemnt Date : {{date('d M Y')}} to {{date('d M Y')}}</th>
             </tr>
         </table>
         <table width="100%" class="table2">
             <!-- <tr>
                 <th width="100%" colspan="4" class="text-center">(Original Delivery Order/ Original Invoice)</th>
             </tr> -->
            
             <tr class="accounting">
                 <th width="10%" class="from">FROM :</th>
                 <th width="40%">Accounting Dept.</th>
                 <th width="10%" class="from">Bill To :</th>
                 <th width="40%">{{ $invoice->assistance_to->to_name ?? ''}}</th>
             </tr>
             <tr>
                 <td class="from"></td>
                 <th>BLUE ASSISTANCE CO.,LTD.</th>
                 <th class="from">Address : </th>
                 <th>{{ $invoice->assistance_to->address ?? ''}}</th>
             </tr>
             <tr>
                 <td class="from"></td>
                 <th>24 SUKHUMVIT SOI 21 SUKHUMVIT ROAD (ASOKE)</th>
                 <th class="from">Email : </th>
                 <th>{{ $invoice->assistance_to->email ?? ''}}</th>
              </tr>
             <tr>
                 <td class="from"></td>
                 <th>KLONGTOEY NUA WATTANA BANGKOK 10110</th>
                 <th class="from">PhNo. : </th>
                 <th>{{ $invoice->assistance_to->phone ?? ''}}</th>
             </tr>
             <tr>
                 <td class="from"></td>
                 <th>TEL: +66 (2) 661-7687-8</th>
                 <td class="from"></td>
                 <td></td>
             </tr>
             <tr>
                 <td  class="from"></td>
                 <th>FAX: +66 (2) 661-7689</th>
                 <td  class="from"></td>
                 <td></td>
             </tr>
             <tr>
                 <td  class="from"></td>
                 <th>TAX ID: 0-1055-47166-10-2 (HEAD OFFICE)</th>
                 <td  class="from"></td>
                 <td></td>
             </tr>  
         </table>
         <table width="100%" style="">
             <tr height="60px" class="table3">
                 <th width="50%" class="text-center">Description</th>
                 <th width="15%" class="text-center">Qty</th>
                 <th width="15%" class="text-center">Unit Price</th>
                 <th width="20%" class="text-center" colspan="2">Amount</th>
             </tr>
             @foreach($descriptions as $key =>$desc)
              <tr>
                 <td>{{$key+1}} ) <br/> {{ $desc->description ?? '' }}<br/> </td>
                 <td style="text-align: center;">{{ $desc->qty ?? '' }}</td>
                 <td style="text-align: center;">
                  {{ $desc->unit_price ?? '' }}
                  @if($desc->currency1==1){{ "USD" }}
                  @elseif($desc->currency1==2){{ "Baht" }}
                  @elseif($desc->currency1==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
                 </td>
                 <td colspan="2" style="text-align: center;">
                  {{ $desc->amount ?? '' }}
                  @if($desc->currency1==1){{ "USD" }}
                  @elseif($desc->currency1==2){{ "Baht" }}
                  @elseif($desc->currency1==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
                 </td>
             </tr>
             @endforeach            
           </table>         
           <table width="100%" style="">
             <tr class="table3">
                 <th width="65%" class="text-center" rowspan="5">Exchange Rate: <br/> USD/THB = {{$usd_thb ?? ''}} - MMK/THB = {{ $mmk_thb ?? ''}} <br/> 
                  <?php 
                    $amt_words=$amounts->total_amount ;
                    $get_amount= AmountInWords($amt_words);
                    echo $get_amount;
                  ?>
                  @if($invoice->change_currency==1){{ "USD" }}
                  @elseif($invoice->change_currency==2){{ "Baht" }}
                  @elseif($invoice->change_currency==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
                 </th>
                 <th width="15%" class="text-center">Subtotal</th>

                 <th width="20%" class="text-center" colspan="3">
                  {{ $amounts->subtotal_amount ?? ''}}
                  @if($invoice->change_currency==1){{ "USD" }}
                  @elseif($invoice->change_currency==2){{ "Baht" }}
                  @elseif($invoice->change_currency==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
                </th>
             </tr>
             <tr>
              <th width="15%" class="text-center">Vatable</th>
              <th width="20%" class="text-center" colspan="3">
                {{ $amounts->vatable_amount ?? ''}}
                @if($invoice->change_currency==1){{ "USD" }}
                @elseif($invoice->change_currency==2){{ "Baht" }}
                @elseif($invoice->change_currency==3){{ "MMK" }}
                @else{{ "LAK" }}
                @endif
              </th>
             </tr>
             <tr>
              <th width="15%" class="text-center">Vat {{ !empty($amounts->vatable_percent) ? $amounts->vatable_percent: '0' ?? '' }}%</th>
              <th width="20%" class="text-center" colspan="3">
                {{ $amounts->calculate_vatable_amount ?? ''}}
                @if($invoice->change_currency==1){{ "USD" }}
                  @elseif($invoice->change_currency==2){{ "Baht" }}
                  @elseif($invoice->change_currency==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
              </th>
             </tr> 
             <tr>
              <th width="15%" class="text-center">Non-Vatable</th>
              <th width="20%" class="text-center" colspan="3">
                {{ $amounts->non_vatable ?? ''}}
                @if($invoice->change_currency==1){{ "USD" }}
                  @elseif($invoice->change_currency==2){{ "Baht" }}
                  @elseif($invoice->change_currency==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
              </th>
             </tr> 
             <tr>
              <th width="15%" class="text-center">Total Amount</th>
              <th width="20%" class="text-center" colspan="3">
                {{ $amounts->total_amount ?? ''}}
                @if($invoice->change_currency==1){{ "USD" }}
                  @elseif($invoice->change_currency==2){{ "Baht" }}
                  @elseif($invoice->change_currency==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
              </th>
             </tr>         
           </table>
           <table width="100%" style="">
             <tr class="table3">
                <th class="text-align:left" style="border-bottom: 1px solid #fff">Payment:</th>
              </tr>
              <tr>
                 <td style="border-bottom: 1px solid #fff">Please make cheques payable to "Blue Assistance Co., Ltd." or transfer the full amount to the following bank account.
                  </td>
              </tr>
              <tr>
                  <th style="border-bottom: 1px solid #fff">Account Name : Blue Assistance Co., Ltd.</th>
              </tr> 
              <tr>
                  <th style="border-bottom: 1px solid #fff">Bank Name : Siam Commercial Bank</th>
              </tr>
              <tr>
                  <th style="border-bottom: 1px solid #fff">Branch : Asoke</th>
              </tr>
              <tr>
                  <th style="border-bottom: 1px solid #fff">Account Number : 032-308374-5</th>
              </tr>
              <tr>
                  <th>Swift Code : SICOTHBK </th>
              </tr>    
           </table>
           
      </main>
      <footer>
         <table width="100%" class="invoice-footer">
              <tr>
                  <td class="text-center" style="border-bottom: 1px solid #fff">RECEIVE INVOICE BY</td>
                  <td class="text-center" style="border-bottom: 1px solid #fff">DELIVERED BY  </td>
                  <td class="text-center" style="border-bottom: 1px solid #fff">AUTHORIZED SINGNATURE</td>
              </tr>
              <tr>
                  <td style="height: 30px;"> </td>
                  <td> </td>
                  <td class="text-center"></td>
              </tr>
              <tr>
                  <td >Date :</td>
                  <td> Date :</td>
                  <td class="text-center">(MS. PANIDA CHERNNOK)</td>
              </tr>
          </table>
      </footer>
    </div>
  </body>

  <body>
    <div class="original-invoice">
      <header>
        <table width="100%" class="table-head">            
            <tr class="th-head">
              <th width="50%" class="text-right">Date : {{date('d M Y')}}</th>
            </tr>
            <tr class="th-head">
              <th width="50%" class="text-right">INV. NO. :  {{ $invoice->invoice_code ?? ''}}</th>
            </tr>
            <tr>
              <th class="text-center">COPY INVOICE</th>
            </tr>
            
           </table>
      </header>
      <main>
          {{-- {{dd($invoice->medical_expenses)}} --}}
         <table width="100%" style="margin-top:28px">
            
             <tr>
                 <th width="50%" class="text-align: left;" style="border-right: 1px solid #FFF;">BA Ref. No. : {{ $invoice->medical_info->ba_ref_no ?? '' }}</th>
                 <th width="50%" class="text-right">Patient Name : {{ $invoice->medical_info->user->family_name ?? '' }}{{ $invoice->medical_info->user->name ?? '' }}</th>
             </tr>
             <tr>
                 <th width="50%" class="text-align: left;" style="border-right: 1px solid #FFF;">Case No : {{ $invoice->medical_info->gcl_case_no ?? '' }}</th>
                 <th width="50%" class="text-right">Treatemnt Date : {{date('d M Y')}} to {{date('d M Y')}}</th>
             </tr>
         </table>
         <table width="100%" class="table2">
             <!-- <tr>
                 <th width="100%" colspan="4" class="text-center">(Original Delivery Order/ Original Invoice)</th>
             </tr> -->
            
             <tr class="accounting">
                 <th width="10%" class="from">FROM :</th>
                 <th width="40%">Accounting Dept.</th>
                 <th width="10%" class="from">Bill To :</th>
                 <th width="40%">{{$invoice->medical_info->assistance->to_name ?? ''}}</th>
             </tr>
             <tr>
                 <td class="from"></td>
                 <th>BLUE ASSISTANCE CO.,LTD.</th>
                 <th class="from">Address : </th>
                 <th>{{ $invoice->medical_info->assistance->address ?? ''}}</th>
             </tr>
             <tr>
                 <td class="from"></td>
                 <th>24 SUKHUMVIT SOI 21 SUKHUMVIT ROAD (ASOKE)</th>
                 <th class="from">Email : </th>
                 <th>{{ $invoice->medical_info->assistance->email ?? ''}}</th>
             </tr>
             <tr>
                 <td class="from"></td>
                 <th>KLONGTOEY NUA WATTANA BANGKOK 10110</th>
                 <th class="from">PhNo. : </th>
                 <th>{{ $invoice->medical_info->assistance->phone ?? ''}}</th>
             </tr>
             <tr>
                 <td class="from"></td>
                 <th>TEL: +66 (2) 661-7687-8</th>
                 <td class="from"></td>
                 <td></td>
             </tr>
             <tr>
                 <td  class="from"></td>
                 <th>FAX: +66 (2) 661-7689</th>
                 <td  class="from"></td>
                 <td></td>
             </tr>
             <tr>
                 <td  class="from"></td>
                 <th>TAX ID: 0-1055-47166-10-2 (HEAD OFFICE)</th>
                 <td  class="from"></td>
                 <td></td>
             </tr>  
         </table>
         <table width="100%" style="">
             <tr height="60px" class="table3">
                 <th width="50%" class="text-center">Description</th>
                 <th width="15%" class="text-center">Qty</th>
                 <th width="15%" class="text-center">Unit Price</th>
                 <th width="20%" class="text-center" colspan="2">Amount</th>
             </tr>
             @foreach($descriptions as $key =>$desc)
              <tr>
                 <td>{{$key+1}} ) <br/> {{ $desc->description ?? '' }}<br/> </td>
                 <td style="text-align: center;">{{ $desc->qty ?? '' }}</td>
                 <td style="text-align: center;">
                  {{ $desc->unit_price ?? '' }}
                  @if($desc->currency1==1){{ "USD" }}
                  @elseif($desc->currency1==2){{ "Baht" }}
                  @elseif($desc->currency1==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
                 </td>
                 <td colspan="2" style="text-align: center;">
                  {{ $desc->amount ?? '' }}
                  @if($desc->currency1==1){{ "USD" }}
                  @elseif($desc->currency1==2){{ "Baht" }}
                  @elseif($desc->currency1==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
                </td>
             </tr>
             @endforeach            
           </table>         
           <table width="100%" style="">
             <tr class="table3">
                 <th width="65%" class="text-center" rowspan="5">Exchange Rate: <br/> USD/THB = {{$usd_thb ?? ''}} - MMK/THB = {{ $mmk_thb ?? ''}} <br/> 
                  <?php 
                    $amt_words=$amounts->total_amount ;
                    $get_amount= AmountInWords($amt_words);
                    echo $get_amount;
                  ?>
                  @if($invoice->change_currency==1){{ "USD" }}
                  @elseif($invoice->change_currency==2){{ "Baht" }}
                  @elseif($invoice->change_currency==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
                 </th>
                 <th width="15%" class="text-center">Subtotal</th>

                 <th width="20%" class="text-center" colspan="3">
                  {{ $amounts->subtotal_amount ?? ''}}
                  @if($invoice->change_currency==1){{ "USD" }}
                  @elseif($invoice->change_currency==2){{ "Baht" }}
                  @elseif($invoice->change_currency==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
                </th>
             </tr>
             <tr>
              <th width="15%" class="text-center">Vatable</th>
              <th width="20%" class="text-center" colspan="3">
                {{ $amounts->vatable_amount ?? ''}}
                @if($invoice->change_currency==1){{ "USD" }}
                  @elseif($invoice->change_currency==2){{ "Baht" }}
                  @elseif($invoice->change_currency==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
              </th>
             </tr>
             <tr>
              <th width="15%" class="text-center">Vat {{ !empty($amounts->vatable_percent) ? $amounts->vatable_percent: '0' ?? '' }}%</th>
              <th width="20%" class="text-center" colspan="3">
                {{ $amounts->calculate_vatable_amount ?? ''}}
                @if($invoice->change_currency==1){{ "USD" }}
                  @elseif($invoice->change_currency==2){{ "Baht" }}
                  @elseif($invoice->change_currency==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
              </th>
             </tr> 
             <tr>
              <th width="15%" class="text-center">Non-Vatable</th>
              <th width="20%" class="text-center" colspan="3">
                {{ $amounts->non_vatable ?? ''}}
                @if($invoice->change_currency==1){{ "USD" }}
                  @elseif($invoice->change_currency==2){{ "Baht" }}
                  @elseif($invoice->change_currency==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
              </th>
             </tr> 
             <tr>
              <th width="15%" class="text-center">Total Amount</th>
              <th width="20%" class="text-center" colspan="3">
                {{ $amounts->total_amount ?? ''}}
                @if($invoice->change_currency==1){{ "USD" }}
                  @elseif($invoice->change_currency==2){{ "Baht" }}
                  @elseif($invoice->change_currency==3){{ "MMK" }}
                  @else{{ "LAK" }}
                  @endif
              </th>
             </tr>         
           </table>
           <table width="100%" style="">
             <tr class="table3">
                <th class="text-align:left" style="border-bottom: 1px solid #fff">Payment:</th>
              </tr>
              <tr>
                 <td style="border-bottom: 1px solid #fff">Please make cheques payable to "Blue Assistance Co., Ltd." or transfer the full amount to the following bank account.
                  </td>
              </tr>
              <tr>
                  <th style="border-bottom: 1px solid #fff">Account Name : Blue Assistance Co., Ltd.</th>
              </tr> 
              <tr>
                  <th style="border-bottom: 1px solid #fff">Bank Name : Siam Commercial Bank</th>
              </tr>
              <tr>
                  <th style="border-bottom: 1px solid #fff">Branch : Asoke</th>
              </tr>
              <tr>
                  <th style="border-bottom: 1px solid #fff">Account Number : 032-308374-5</th>
              </tr>
              <tr>
                  <th>Swift Code : SICOTHBK </th>
              </tr>    
           </table>
           
      </main>
      <footer>
         <table width="100%" class="invoice-footer">
              <tr>
                  <td class="text-center" style="border-bottom: 1px solid #fff">RECEIVE INVOICE BY</td>
                  <td class="text-center" style="border-bottom: 1px solid #fff">DELIVERED BY  </td>
                  <td class="text-center" style="border-bottom: 1px solid #fff">AUTHORIZED SINGNATURE</td>
              </tr>
              <tr>
                  <td style="height: 30px;"> </td>
                  <td> </td>
                  <td class="text-center"></td>
              </tr>
              <tr>
                  <td >Date :</td>
                  <td> Date :</td>
                  <td class="text-center">(MS. PANIDA CHERNNOK)</td>
              </tr>
          </table>
      </footer>
    </div>
  </body>
    
</html>

<?php
// Create a function for converting the amount in words
function AmountInWords(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? '' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) : '';
   return ($implode_to_Rupees ? $implode_to_Rupees : '') . $get_paise;
}
?>