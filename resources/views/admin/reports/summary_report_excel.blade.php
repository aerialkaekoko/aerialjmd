@section('styles')
<style>
  tr.tdclass{
    background-color:#FDBCC1;
  }

  tr.tdclass td,
  tr.tdclass th{
    border-top: 3px solid #000000;
     border: 1px solid #000000;
  border-collapse: collapse;
  }

</style>
@endsection
<table>
  <thead>
    <tr>       
        <th colspan="4" style="text-align:left;font-size: 12px;font-weight: bold;height: 20px;">Summary Report , {{date('M Y')}} </th>
       
    </tr>
    <tr></tr>
    <tr>
        <th colspan="2" style="text-align: center;vertical-align: middle;"><img src="images/jmd.jpg"></th>
        <th colspan="5" style="text-align:left;font-size: 12px;font-weight: bold;vertical-align: middle;color: #0000000;margin-left: 20px;left: 20px;position: relative;">Blue Assistance Co., Ltd.<br/>No. D 9th Floor, Prime Building 24 Sukhumvit Soi 21 (Asoke)<br/>Sukhumvit Road, Klongtoey-Nua Wattana Bangkok 10110 THAILAND<br/>Tel:+66-2661-7687-88   Fax:+66-2661-7689</th>
        <th style="text-align: center;vertical-align: middle;"><img src="images/jmd1.jpg"></th>
    </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0">
  <tr class="tdclass">
    <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;width: 10px;border:1px solid #000000;border-right: 1px solid #ffffff;">To</th>
    <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;width: 10px;border:1px solid #000000;border-left: 1px solid #ffffff;"></th>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-right: 1px solid #ffffff;">Assistance Company</td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;">Name</td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;"></td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;"></td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;"></td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;"></td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;"></td>
  </tr>
  <tr>
    <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;width: 10px;border:1px solid #000000;border-right: 1px solid #ffffff;">Attn</th>
    <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;width: 10px;border:1px solid #000000;border-left: 1px solid #ffffff;"></th>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-right: 1px solid #ffffff;">Department Name</td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;"></td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;"></td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;"></td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;"></td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;"></td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;"></td>
  </tr>
  <tr>
      <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;border:1px solid #000000;border-right: 1px solid #ffffff;">Date</th>
      <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;width: 10px;border:1px solid #000000;border-left: 1px solid #ffffff;"></th>
      <td colspan="4" style="text-align: left;vertical-align: middle;">{{date('Y-m-d',strtotime("now"))}}</td>
      <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;border:1px solid #000000">Fax No.</th>
      <td style="text-align: left;vertical-align: middle;font-size: 12px;">66-2-661-7689</td>
      <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;"></td>
  </tr>
  <tr>
    <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;width: 10px;border:1px solid #000000;border-right: 1px solid #ffffff;">Re</th>
    <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;width: 10px;border:1px solid #000000;border-left: 1px solid #ffffff;"></th>
    <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;width: 10px;border:1px solid #000000;border-right: 1px solid #ffffff;">Invoice</th>
    <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;width: 10px;border:1px solid #000000;border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;"></th>
    <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;width: 10px;border:1px solid #000000;border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;"></th>
    <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;width: 10px;border:1px solid #000000;border-left: 1px solid #ffffff;"></th>
    <th style="text-align: left;vertical-align:center;font-size: 12px;font-weight: bold;border:1px solid #000000">From</th>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;border-right: 1px solid #ffffff;border: 1px solid #000000;">Ryotaro Azuma</td>
    <td style="text-align: left;vertical-align: middle;font-size: 12px;font-weight: bold;border: 1px solid #000000;border-left: 1px solid #ffffff;"></td>
  </tr>  

</table>
<p>Dear Sir/Madam,</p><br/>
<p style="left: 30px;position: relative;margin-left: 30px;"> We are pleased to send invoice of our JMD service fees and medical expenses.</p>
<p></p><p></p>
<table>
    <thead>
    <tr>
      <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 5px;border-top: 5px solid #000000;border:1px solid #000000;">
         No.
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 20px;border-top: 5px solid #000000;border:1px solid #000000;">
          Invoice No.
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 20px;border-top: 5px solid #000000;border:1px solid #000000;">
          BA Ref
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #000000;">
          AGT Ref
        </th>
         <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #000000;">
          Insurance
        </th>
       
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 20px;border-top: 5px solid #000000;border:1px solid #000000;">
          Patient Name
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 10px;border-top: 5px solid #000000;border:1px solid #000000;">
          Currency
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;border-top: 5px solid #000000;border:1px solid #000000;width: 10px;">
          Amount
        </th>        
         <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #000000;">
         Date
        </th>
      </tr>
  </thead>
  <tbody>
    @php  
        $total_amount = 0;
        $exchange_rate = 0;
    @endphp
    
    @foreach ($invoices as $key=>$item)
        
          <tr>
              <td style="text-align:center;border: 1px solid #000000;">{{$key+1}}</td>
              <td style="text-align:center;border: 1px solid #000000;">
                  {{ !empty($item->invoice_code) ? $item->invoice_code: '-' ?? '' }}
                </td>
                <td style="text-align:center;border: 1px solid #000000;">
                  {{ !empty($item->medical_info->ba_ref_no) ? $item->medical_info->ba_ref_no: '-' ?? '' }}
                </td>
                <td style="text-align:center;border: 1px solid #000000;">
                  {{ !empty($item->medical_info->gcl_case_no) ? $item->medical_info->gcl_case_no: '-' ?? '' }}
                </td>
                <td style="text-align:center;border: 1px solid #000000;">
                  {{ !empty($item->medical_info->insurance_id) ? $item->medical_info->insurance->company_name : '-' ?? '' }}
                </td>
                <td style="text-align:center;border: 1px solid #000000;">
                  {{ $item->user->family_name ?? '' }} {{ $item->user->name ?? '' }}
                </td>
                <td style="text-align:center;border: 1px solid #000000;">
                  {{trans('cruds.currency')[$item->change_currency]}}
                </td>
                <td style="text-align:right;border: 1px solid #000000;">
                 {{ $item->amount($item->invoice_code)->total_amount ?? ''}}
                </td>                
                <td style="text-align:center;border: 1px solid #000000;">
                  {{date('Y-m-d',strtotime($item->invoice_date))}}
                </td>
                @php
                    $total_amount += $item->amount($item->invoice_code)->total_amount;
                    $change_currency = $item->change_currency;
                @endphp
          </tr>
      @endforeach
       <tr style="background-color:#00B200;">
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>      
            <td style="text-align:center;font-weight: bold;font-size: 14px;background-color:#70ad47;border:1px solid #70ad47;color: #FFFFFF;">TotalAmount</td>
             <td></td>
            <td style="text-align:center;">
              {{trans('cruds.currency')[$change_currency]}}
            </td>
            <td style="text-align:right;">{{$total_amount}}</td>    
        </tr>
  </tbody>
</table>
<p>Please transfer the fees to the following bank account.</p>
<p></p>
<table>
    <tr>
        <td></td>
        <td></td>
        <th style="font-size: 12px;text-align: left;vertical-align: middle;">Bank Name</th>
        <td style="font-size: 12px;text-align: left;vertical-align: middle;">: SIAM COMMERCIAL BANK PCL.</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <th style="font-size: 12px;text-align: left;vertical-align: middle;">Branch</th>
        <td style="font-size: 12px;text-align: left;vertical-align: middle;">: Asoke Branch</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <th style="font-size: 12px;text-align: left;vertical-align: middle;">Account Name</th>
        <td style="font-size: 12px;text-align: left;vertical-align: middle;">: Blue Assistance Co., Ltd.</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <th style="font-size: 12px;text-align: left;vertical-align: middle;">Account No.</th>
        <td style="font-size: 12px;text-align: left;vertical-align: middle;">: 0323083745</td>
    </tr>
</table>
<p>Best Regards,</p>
<p></p><p></p><p></p>
<div class="">
    <p>Ms. Panida   Chernnok</p>
    <p>Blue Assistance Co., Ltd.</p>
</div>
