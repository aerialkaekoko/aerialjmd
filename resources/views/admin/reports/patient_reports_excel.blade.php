<table class="profit_report">
  <thead>
    <tr>
       
        @if ($country == 1 || $desk == 4)
            <td colspan="4" style="text-align:left;font-size: 12px;height: 20px;">JMDM PATIENT REPORT , {{date('M Y')}} </td>
        @elseif ($country == 3 || $desk == 3)
           <td colspan="4" style="text-align:left;font-size: 12px;height: 20px;">JMDL PATIENT REPORT , {{date('M Y')}} </td>
        @elseif ($country == 2 || $desk == 1 || $desk == 1)
           <td colspan="4" style="text-align:left;font-size: 12px;height: 20px;">JMDA PATIENT REPORT , {{date('M Y')}} </td>
        @else
            <td colspan="4" style="text-align:left;font-size: 12px;height: 20px;">JMDP PATIENT REPORT , {{date('M Y')}} </td>
        @endif
    </tr>
    
    <tr style="background-color:#00B200">
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 5px;border-top: 5px solid #000000;border: 1px solid #000000;">No.</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #0000000;">Date</th>
        @if ($country == 3 || $desk == 3 || $country == 2 || $desk == 2)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #0000000;">IPD/OPD</th>
        @endif
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #0000000;">Re-Exam</th>
         @if ($country == 3 || $desk == 3 || $country == 2 || $desk == 2)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #0000000;">IN</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #0000000;">OUT</th>
        @endif
        
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #0000000;">BA Ref No</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #0000000;">SEX</th>
        @if ($country == 1 || $desk == 4)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #0000000;">Family Name</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #0000000;">Given Name</th>
        @else
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #0000000;">First Name</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #0000000;">Last Name</th>        
        @endif
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 5px;border-top: 5px solid #000000;border:1px solid #0000000;">PAX</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #0000000;">Hospital Name</th>
        @if ($country == 3 || $desk == 3 || $desk == 2)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #0000000;">Credit Card</th>
        @endif
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #0000000;">Insurance</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #0000000;">Assistance</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #0000000;">MD Expense($)</th>
        @if ($country == 1 || $desk == 4)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #0000000;">MD Expense(KS)</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;border-top: 5px solid #000000;">KB($)</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;border-top: 5px solid #000000;border:1px solid #0000000;">KB(Ks)</th>
        @endif
        <!-- <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #0000000;">MD Expense(KS)</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;border-top: 5px solid #000000;">KB($)</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;border-top: 5px solid #000000;border:1px solid #0000000;">KB(Ks)</th> -->
        @if ($country == 3 || $desk == 3 || $country == 2 || $desk == 1 || $desk == 2)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">Patient No.</th>
        @endif
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">AGT Ref</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">Company Name</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">Sympton</th>
        @if ($country == 3 || $desk == 3)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">Rep</th>
        @endif
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">GCL/GOP</th>
        @if ($country == 1 || $desk == 4)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">Interpreter</th>
        @elseif ($country == 2 || $desk == 1)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">通訳者</th>
        @endif
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">Insentive</th>
        @if ($country == 3 || $desk == 3 || $desk == 2)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">In</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">Out</th>
        @endif
        @if ($country == 3 || $desk == 3 || $country == 1 || $desk == 4)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">Time</th>
        @endif
        @if ($country == 3 || $desk == 3 || $country == 2 || $desk == 1)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">JMD</th>
        @endif
        @if ($country == 3 || $desk == 3)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">Deliv</th>
        @endif
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">Document to BA Office</th> 
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">Memo/Remark</th>      
        <!-- <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">書類BA本社へ送付</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">時間外対応</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #0000000;">曜日</th> -->
        
    </tr>
  </thead>
  <tbody>
       @php 
            $total_profit = 0;
            $total_pax = 0;
            $total_medical_expense = 0;
            $total_ba_svf = 0;
            $total_case_fee = 0;
            $total_cash_in = 0;
            $total_medical_expense_out = 0;
            $total_other_fee = 0;
            $total_cash_out = 0;
            $total_kb = 0;
            $sum_profit = 0;
            $in = 0;
            $out = 0;

       @endphp
       @foreach ($patient as $key=>$item)
          <tr>
            @php
                $total_profit += $item->medical_amount2 + $item->ba_svf + $item->case_fee - ($item->medical_amount2 + 1) + 0;               
                $total_medical_expense += $item->medical_amount;
                $total_cash_out += $item->medical_amount2 + $item->other_fee ;
                $total_ba_svf += $item->ba_svf;
                $total_case_fee += $item->case_fee;
                $total_cash_in = $total_medical_expense + $total_ba_svf + $total_case_fee;
                $total_pax += 1;
                $total_other_fee += $item->other_fee;
                $sum_profit = $total_cash_in - $total_cash_out ;
                $service_in = strtotime($item->service_time);
                $service_out = strtotime($item->service_outtime);
                $service_differ = ($service_out - $service_in) / 60;
                $converted_time = date('H:i', mktime(0,$service_differ));
                $exchange_mmk = $exchange;
            @endphp
            <td style="text-align:center;border: 1px solid #000000;">{{$key+1}}</td>
            <td style="text-align:center;border: 1px solid #000000;">{{date('Y-m-d',strtotime($item->treatment_date))}}</td>
             @if ($country == 3 || $desk == 3 || $country == 2 || $desk == 2)
            <td style="text-align:center;border: 1px solid #000000;">{{ !empty($item->opd_ipd) ? $item->opd_ipd == 1 ? "IPD" : "OPD" : '-' ?? '' }}</td>

            @endif
            <td style="text-align:center;border: 1px solid #000000;">{{$item->re_exam == 1 ? 'o' : '-'}}</td>
            @if ($country == 3 || $desk == 3 || $country == 2 || $desk == 2 )
            <td style="text-align:center;border: 1px solid #000000;">
                {{ !empty($item->ipd_start_date) ? $item->ipd_start_date  : '-' ?? '' }}</td>
            <td style="text-align:center;border: 1px solid #000000;">{{ !empty($item->ipd_finish_date) ? $item->ipd_finish_date : '-' ?? '' }}</td>
            @endif            
            <td style="text-align:center;border: 1px solid #000000;">{{ $item->ba_ref_no }}</td>
            <td style="text-align:center;border: 1px solid #000000;">
                @if(isset($item->user->gender))
                    {{$item->user->gender == 'male' ? 'M' : 'F'}}
                    @else
                    -
                @endif
            </td>
            <td style="text-align:center;border: 1px solid #000000;">{{ $item->user->family_name ?? '' }}</td>
            <td style="text-align:center;border: 1px solid #000000;">{{ $item->user->name ?? '' }}</td>
            <td style="text-align:center;border: 1px solid #000000;">1</td>
            <td style="text-align:center;border: 1px solid #000000;">{{ !empty($item->hospital->name) ? $item->hospital->name : '-' ?? '' }}</td>
            @if ($country == 3 || $desk == 3 || $desk == 2)
            <td style="text-align:center;border: 1px solid #000000;">Card</td>
            @endif
            <td style="text-align:center;border: 1px solid #000000;">
                <!-- {{ $item->receive_type == 1 ? !empty($item->insurance->company_name) ? $item->insurance->company_name : "No Insurance" : "CASH"  ?? '' }} -->
                {{ !empty($item->insurance_id) ? $item->insurance->company_name : '-' ?? '' }}
            </td>
            <td style="text-align:center;border: 1px solid #000000;">              
                {{ !empty($item->assistance_id) ? $item->assistance->assistance_name : '-' ?? '' }}
            </td>

            @if ($country == 1 || $desk == 4 || $country == 3 || $desk == 3)
            <td style="text-align:center;border: 1px solid #000000;">$ {{ !empty($item->medical_amount2) ? $item->medical_amount2 : "0.00" ?? '' }}</td>
            @else
            <td style="text-align:center;border: 1px solid #000000;">฿ {{ !empty($item->medical_amount2) ? $item->medical_amount2 : "0.00" ?? '' }}</td>
            @endif

            @if ($country == 1 || $desk == 4)
                <td style="text-align:center;border: 1px solid #000000;">{{ $item->medical_amount2 * $exchange ?? '' }}</td>
                <td style="text-align:center;border: 1px solid #000000;">{{ $item->kb==0 ? '-' : $item->kb  ?? '' }}</td>
                <td style="text-align:center;border: 1px solid #000000;">{{$item->kb==0 ? '-' : $item->kb * $exchange ?? '' }}</td>
            @endif
            <!-- <td style="text-align:center;border: 1px solid #000000;">{{ $item->receive_type == 1 ? $item->medical_amount : "-"  ?? '' }}</td>
            @if ($country == 1 || $desk == 4)
                <td style="text-align:center;border: 1px solid #000000;">{{ $item->receive_type == 1 ? $item->medical_amount * $item->exchange_mmk : "-"  ?? '' }}</td>
            @elseif ($country == 3 || $desk == 3)
                <td style="text-align:center;border: 1px solid #000000;">{{ $item->receive_type == 1 ? $item->medical_amount * $item->exchange_lak : "-"  ?? '' }}</td>
            @else
                <td style="text-align:center;border: 1px solid #000000;">฿ {{ $item->receive_type == 1 ? $item->medical_amount : "-"  ?? '' }}</td>
            @endif    
            <td style="text-align:center;border: 1px solid #000000;">฿ {{ $item->receive_type == 1 ? 0 : $item->medical_amount ?? '' }}</td>
            @if ($country == 1 || $desk == 4)
                 <td style="text-align:center;border: 1px solid #000000;">{{ $item->receive_type == 1 ? 0 : $item->medical_amount * $item->exchange_mmk ?? '' }}</td>
            @elseif ($country == 3 || $desk == 3)
                 <td style="text-align:center;border: 1px solid #000000;">{{ $item->receive_type == 1 ? 0 : $item->medical_amount * $item->exchange_lak ?? '' }}</td>
            @else
                 <td style="text-align:center;border: 1px solid #000000;">฿ {{ $item->receive_type == 1 ? 0 : $item->medical_amount ?? '' }}</td>
            @endif -->
            @if ($country == 3 || $desk == 3 ||$country == 2 || $desk == 2)
            <td style="text-align:center;border: 1px solid #000000;">{{ !empty($item->patient_no) ? $item->patient_no : '-' ?? '' }}</td>
            @endif
            <td style="text-align:center;border: 1px solid #000000;">{{ !empty($item->gcl_case_no) ? $item->gcl_case_no : '-' ?? '' }}</td>
            <td style="text-align:center;border: 1px solid #000000;">{{ $item->user->company ?? '' }}</td>
            <td style="text-align:center;border: 1px solid #000000;">{{ $item->sympton ?? '' }}</td>
            @if ($country == 3 || $desk == 3)
            <td style="text-align:center;border: 1px solid #000000;">Feb</td>
            @endif
            <td style="text-align:center;border: 1px solid #000000;">OK</td>

            @if ($country == 1 || $desk == 4 || $country == 2 || $desk == 1)
            <td style="text-align:center;border: 1px solid #000000;">{{$item->translator_name}}</td>
            @endif
            <td style="text-align:center;border: 1px solid #000000;">{{ $item->user->insentive ?? '' }}</td>

            @if ($country == 3 || $desk == 3 || $desk == 2)
                @forelse ($item->services as $service)
                    <td style="text-align:center;border: 1px solid #000000;">{{date('h:i A',strtotime($service->intime))}}</td>
                    <td style="text-align:center;border: 1px solid #000000;">{{date('h:i A',strtotime($service->outtime))}}</td>
                   
                @empty
                    <td  style="text-align:center;border: 1px solid #000000;">No Service Time Yet !....</td>
                @endforelse
            @endif

            @if ($country == 1 || $desk == 4)
                @forelse ($item->services as $service)
                <td style="text-align:center;border: 1px solid #000000;">
                    @if($service->intime==null)
                      -
                    @else
                       {{date('h:i A',strtotime($service->intime))}} - {{date('h:i A',strtotime($service->outtime))}}
                    @endif
                    
                </td>
                @empty
                <td  style="text-align:center;border: 1px solid #000000;">No Service Time Yet !....</td>
                @endforelse
       
            @elseif ($country == 3 || $desk == 3)
               @forelse ($item->services as $service)
                    <td  style="text-align:center;border: 1px solid #000000;">
                        @if($service->intime==null)
                          -
                        @else
                           {{date('h:i A',strtotime($service->intime))}} - {{date('h:i A',strtotime($service->outtime))}}
                        @endif
                    </td>
                    @empty
                    <td  style="text-align:center;border: 1px solid #000000;">No Service Time Yet !....</td>
                    @endforelse
                @else
            @endif
            @if ($country == 3 || $desk == 3 || $country == 2 || $desk == 1)
            <td style="text-align:center;border: 1px solid #000000;">JMD</td>
            @endif
            @if ($country == 3 || $desk == 3)
            <td style="text-align:center;border: 1px solid #000000;">02/18</td>
            @endif
            <td style="text-align:center;border: 1px solid #000000;">{{$item->document_date}}</td>
            <td style="text-align:center;border: 1px solid #000000;">-</td>           
            <!-- <td style="text-align:center;border: 1px solid #000000;">{{date('d M',strtotime($item->created_at))}}</td>
            <td style="text-align:center;border: 1px solid #000000;">{{$item->side_response == 1 ? '電話対応' : '現場対応' }} </td>
            <td style="text-align:center;border: 1px solid #000000;">{{date('D',strtotime($item->created_at))}}</td> -->
          </tr>
                  
      @endforeach
  </tbody>
</table>

