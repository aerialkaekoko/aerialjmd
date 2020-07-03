<table>
  <thead>
    <tr>       
        @if ($country == 1)
            <td colspan="4" style="text-align:left;font-size: 12px;height: 20px;">JMDM INVOICE REPORT , {{date('M Y')}} </td>
        @elseif ($country == 3)
           <td colspan="4" style="text-align:left;font-size: 12px;height: 20px;">JMDL INVOICE REPORT , {{date('M Y')}} </td>
        @elseif($country == 2)
            <td colspan="4" style="text-align:left;font-size: 12px;height: 20px;">JMDA INVOICE REPORT , {{date('M Y')}} </td>
        @else
            <td colspan="4" style="text-align:left;font-size: 12px;height: 20px;">JMD INVOICE REPORT , {{date('M Y')}} </td>
        @endif
    </tr>
    <tr></tr>
    <tr>
      <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 5px;border-top: 5px solid #000000;border:1px solid #00007D;">
         No.
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 20px;border-top: 5px solid #000000;border:1px solid #00007D;">
          Invoice No.
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 20px;border-top: 5px solid #000000;border:1px solid #00007D;">
          Ba Ref No
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #00007D;">
          Insurance
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 20px;border-top: 5px solid #000000;border:1px solid #00007D;">
          Assistance Company
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #00007D;">
          AGT Ref No.
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #00007D;">
          Patient Name
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #00007D;">
          Currency
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #00007D;">
          Amount
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #00007D;">
          Invoice Date
        </th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #00007D;">
          Sent Date
        </th>
        
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #00007D;">
          Paid/Unpaid
        </th>        
      </tr>
  </thead>
  <tbody>
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
                  {{ !empty($item->medical_info->insurance_id) ? $item->medical_info->insurance->company_name : '-' ?? '' }}
                </td>
                <td style="text-align:center;border: 1px solid #000000;">
                  {{ !empty($item->medical_info->assistance_id) ? $item->medical_info->assistance->assistance_name : '-' ?? '' }}
                </td>
                <td style="text-align:center;border: 1px solid #000000;">
                  {{ !empty($item->medical_info->gcl_case_no) ? $item->medical_info->gcl_case_no: '-' ?? '' }}
                </td>
                <td style="text-align:center;border: 1px solid #000000;">
                   {{ !empty($item->medical_info->patient_id) ? $item->user->family_name : '-' ?? '' }} {{ !empty($item->medical_info->patient_id) ? $item->user->name : '-' ?? '' }}
                </td>
                 @if($item->change_currency==1)
                    <td style="text-align:center;border: 1px solid #000000;">{{ "USD" }} </td>
                  @elseif($item->change_currency==2)
                    <td style="text-align:center;border: 1px solid #000000;">{{ "Baht" }}</td>
                  @elseif($item->change_currency==3)
                    <td style="text-align:center;border: 1px solid #000000;">{{ "MMK" }}</td>
                  @else
                    <td style="text-align:center;border: 1px solid #000000;">{{ "LAK" }}</td>
                  @endif
                <td style="text-align:center;border: 1px solid #000000;">
                    {{ $item->amount($item->invoice_code)->total_amount ?? '' }}
                </td>
                <td style="text-align:center;border: 1px solid #000000;">
                    {{ !empty($item->invoice_date) ? date('d-m-Y',strtotime($item->invoice_date)) : '-' ?? '' }}
                </td>
                <td style="text-align:center;border: 1px solid #000000;">
                    {{ !empty($item->send_date) ? date('d-m-Y',strtotime($item->send_date)) : '-' ?? '' }}
                </td>
                <td style="text-align:center;border: 1px solid #000000;">
                    {{ !empty($item->trf_paid==0) ? "Unpaid" : 'Paid' ?? '' }}
                </td>

          </tr>
      @endforeach
  </tbody>
</table>