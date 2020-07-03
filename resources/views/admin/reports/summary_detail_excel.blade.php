<table class="profit_report">
  <thead>
    <tr>     
       <td colspan="4" style="text-align:left;font-size: 12px;height: 20px;">JMD Invoice Detail</td>
    </tr>
    <tr></tr>
    <tr style="background-color:#00B200">
        <th rowspan="2" style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;color: #ffffff;background-color:#70ad47;width: 5px;border-top: 5px solid #000000;border: 1px solid #000000;margin-top: auto;margin-bottom: auto;}">No.</th>
        <th rowspan="2" style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;color: #ffffff;background-color:#70ad47;width: 25px;border-top: 5px solid #000000;border:1px solid #0000000;">Insurance Company</th>
        <th rowspan="2" style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;color: #ffffff;background-color:#70ad47;width: 50px;border-top: 5px solid #000000;border:1px solid #0000000;">Invoice To</th>
        <th colspan="2" style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;color: #ffffff;background-color:#70ad47;width: 20px;border-top: 5px solid #000000;border:1px solid #0000000;">Currency</th>
        <th rowspan="2" style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;color: #ffffff;background-color:#70ad47;width: 20px;border-top: 5px solid #000000;border:1px solid #0000000;">Patient Name</th>
        <th rowspan="2" style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;color: #ffffff;background-color:#70ad47;width: 35px;border-top: 5px solid #000000;border:1px solid #0000000;">Description</th>
        <th rowspan="2" style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;color: #ffffff;background-color:#70ad47;width: 20px;border-top: 5px solid #000000;border:1px solid #0000000;">Service Fee</th>
    </tr>
    <tr>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #0000000;">UnitPrice</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #0000000;">Amount</th>
    </tr>
  </thead>
  <tbody>
       
       @foreach ($invoice as $key=>$item)
          <tr>           
            <td style="text-align:center;border: 1px solid #000000;">{{$key+1}}</td>
            <td style="text-align:center;border: 1px solid #000000;vertical-align:middle;">
                {{ $item->medical_info->insurance->company_name ?? '-' }}
            </td>
            <td style="text-align:left;border: 1px solid #000000;">
                {{ $item->medical_info->assistance->to_name ?? '-' }} <br/>
                {{ $item->medical_info->assistance->address ?? '-' }},{{ $item->medical_info->assistance->email ?? '-' }} ,
                {{ $item->medical_info->assistance->phone ?? '-' }}
            </td>
            <td style="text-align:center;border: 1px solid #000000;">
                @if($item->change_currency==1){{ "USD" }}
                @elseif($item->change_currency==2){{ "THB" }}
                @elseif($item->change_currency==3){{ "MMK" }}
                @else{{ "LAK" }}
                @endif
            </td>
            <td style="text-align:center;border: 1px solid #000000;">{{ $item->amount($item->invoice_code)->total_amount ?? ''}}</td>
            <td style="text-align:center;border: 1px solid #000000;">{{ $item->medical_info->user->family_name ?? '' }} {{ $item->medical_info->user->name ?? '' }}</td>
            <td style="text-align:left;border: 1px solid #000000;">
                @foreach($item->description($item->id) as $key =>$desc)
                  {{$key+1}} ) {{ $desc->description ?? '-'}} <br/>
                @endforeach
            </td>
            <td style="text-align:center;border: 1px solid #000000;">
                @foreach($item->description($item->id) as $key =>$desc)
                    @if($country == 3)
                      @if($desc->currency1==1)
                        $ {{ $service_fee = $desc->amount ?? '-' }} <br/>
                      @elseif($desc->currency1==2)
                        $ {{ $service_fee = substr($desc->amount / $exchange_thb,0,7) ?? '-' }} <br/>
                      @else
                        $ {{ $service_fee = substr($desc->amount / $exchange_lak,0,7) ?? '-' }} <br/>
                      @endif
                    @elseif($country == 1)
                      @if($desc->currency1==1)
                        $ {{ $service_fee = $desc->amount ?? '-' }} <br/>
                      @elseif($desc->currency1==2)
                        $ {{ $service_fee = substr($desc->amount / $exchange_thb,0,7) ?? '-' }} <br/>
                      @else
                        $ {{ $service_fee = substr($desc->amount / $exchange_mmk,0,7) ?? '-' }} <br/>
                      @endif
                    @else
                      @if($desc->currency1==1)
                        $
                      @else
                        ฿                      
                      @endif
                      {{ $service_fee = $desc->amount ?? '-' }} </br>
                    @endif
                @endforeach
            </td>
          </tr>          
      @endforeach     
  </tbody>
</table>
@php
  if($country == 2){
    $vat = 7;
  }elseif($country == 1){
    $vat = 5;
  }else{
   $vat = 7;
  }
@endphp
<div class="slogan" style="">
  <p style="color:#de2609;font-size: 21px;font-weight: bold;">*All are vatable except medical expenses = VAT {{ $vat ?? ''}} %</p>
  <p style="color:#de2609;font-size: 21px;font-weight: bold;">** Service fee multiplies the number of units</p>
<div>

 