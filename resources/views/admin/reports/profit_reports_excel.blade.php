<table class="profit_report">
  <thead>
    <tr>
        @if ($country == 1 || $desk == 4)
        <td colspan="3" style="text-align:center;font-size: 14px;font-weight: bold;height: 20px;">JMDM</td>
        @elseif ($country == 3 || $desk == 3)
        <td colspan="3" style="text-align:center;font-size: 14px;font-weight: bold;height: 20px;">JMDL</td>
        @elseif ($country == 2 || $desk == 2)
        <td colspan="3" style="text-align:center;font-size: 14px;font-weight: bold;height: 20px;">JMDP</td>
        @else<td colspan="3" style="text-align:center;font-size: 14px;font-weight: bold;height: 20px;">JMDA</td>
        @endif
        <td colspan="3" style="text-align:center;font-size: 14px;font-weight: bold;height: 20px;">{{date('F Y')}}</td>
        <td></td>
        <td colspan="4" style="text-align:center;font-size: 14px;font-weight: bold;background-color:#70ad47;color:#ffffff;height: 20px;"> Cash In</td>
        <td colspan="3" style="text-align:center;background-color:#70ad47;color:#ffffff;font-size: 14px;font-weight: bold;height: 20px;"> Cash Out</td>
    </tr>
    <tr style="background-color:#00B200">
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 5px;border-top: 5px solid #000000;border:1px solid #00007D;">No.</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #000000;">Date</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #000000;">Ref No</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #000000;">Hospital Name</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 5px;border-top: 5px solid #000000;border:1px solid #000000;">PAX</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #000000;">Insurance</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 14px;border-top: 5px solid #000000;border:1px solid #000000;">Assistance</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #000000;">MD Expense</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #000000;">BA SVF</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 5px solid #000000;border:1px solid #000000;">Case Fee</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;border-top: 5px solid #000000;border:1px solid #000000;">Total</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #000000;">MD Expense</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 5px solid #000000;border:1px solid #000000;">Other Fee</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;border-top: 5px solid #000000;border:1px solid #000000;">Total</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;border-top: 5px solid #000000;border:1px solid #000000;">Profit</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;border-top: 5px solid #000000;border:1px solid #000000;">KB</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #000000;">Total Profit</th>
        @if ($country == 2 || $desk == 1 || $desk == 2)
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 15px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 5px solid #000000;border:1px solid #000000;">Profit Per Pax</th>
        @endif
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
            $total_sum = 0;
            $cash_profit = 0;
            $insu_profit = 0;
            $total_profit1 = 0;
            $exchange_rate = 0;
            $ba_svf = 0;
            $first_number = 0;
            $first_basvf = 0;
            $total_cashin = 0;
            $total_cashout = 0;
            $total_fit = 0;
            $total_netfit = 0;
       @endphp
       @foreach ($profits as $key=>$item)       
                <tr>
                @php                
                    $total_profit += $item->medical_info->medical_amount + $item->ba_svf + $item->case_fee - ($item->medical_info->medical_amount + 1) + 0;         
                    $sum_profit = $total_cash_in - $total_cash_out ;
                    $total_sum += $item->medical_info->receive_type == 1 ? $item->medical_info->medical_amount + $item->medical_info->other_fee : 0;

                    $cash_profit += $item->medical_info->medical_amount + $item->ba_svf + $item->case_fee - ($item->medical_info->medical_amount + $item->medical_info->other_fee);
                    $sum_profit = $cash_profit + $insu_profit;

                    $total_pax += 1;
                    $ba_svf = 0;
                    foreach ($item->description($item->id) as $desc) {
                        if($desc->invoice_description_id==1 || $desc->invoice_description_id==3 || $desc->invoice_description_id==4 || $desc->invoice_description_id==6 || $desc->invoice_description_id==7 || $desc->invoice_description_id==8){
                            if($desk == 3){
                                if($item->change_currency==1){
                                    $ba_svf += $desc->amount;
                                }else{
                                    $ba_svf +=  substr($desc->amount / $exchange_lak,0,5);;

                                }
                            }elseif($desk == 4){
                                if($item->change_currency==1){
                                    $ba_svf += $desc->amount;
                                }elseif($item->change_currency==2){
                                    $ba_svf +=  substr($desc->amount / $exchange_thb,0,7);
                                }else{
                                    $ba_svf +=  substr($desc->amount / $exchange_mmk,0,7);;

                                }
                            }else{
                                if($item->change_currency==1){
                                    $ba_svf += substr($desc->amount * $exchange_thb,0,7);
                                }else{
                                    $ba_svf += $desc->amount ;
                                }
                            }
                            
                        }
                    }

                    $case_fee = 0;
                    foreach ($item->description($item->id) as $desc) {
                        if($desc->invoice_description_id==5){
                            if($desk == 3){
                                if($item->change_currency==1){
                                    $case_fee += $desc->amount;
                                }else{
                                    $case_fee +=  substr($desc->amount / $exchange_lak,0,7);

                                }
                            }elseif($desk == 4){
                                if($item->change_currency==1){
                                    $case_fee += $desc->amount;
                                }elseif($item->change_currency==2){
                                    $case_fee +=  substr($desc->amount / $exchange_thb,0,7);
                                }else{
                                    $case_fee +=  substr($desc->amount / $exchange_mmk,0,7);

                                }
                            }else{
                                if($item->change_currency==1){
                                    $case_fee += substr($desc->amount * $exchange_thb,0,7);
                                }else{
                                    $case_fee += $desc->amount ;
                                }
                            }
                            
                        }
                    }
                    $other_fee = 0;
                    foreach ($item->description($item->id) as $desc) {
                        if($desc->invoice_description_id==1){
                            if($desk == 3){
                                if($item->change_currency==1){
                                    $other_fee += $desc->amount;
                                }else{
                                    $other_fee +=  substr($desc->amount / $exchange_lak,0,7);
                                }
                            }elseif($desk == 4){
                                if($item->change_currency==1){
                                    $other_fee += $desc->amount;
                                }elseif($item->change_currency==2){
                                    $other_fee +=  substr($desc->amount / $exchange_thb,0,7);
                                }else{
                                    $other_fee +=  substr($desc->amount / $exchange_mmk,0,7);;

                                }
                            }else{
                                if($item->change_currency==1){
                                    $other_fee += substr($desc->amount * $exchange_thb,0,7);
                                }else{
                                    $other_fee += $desc->amount ;
                                }
                            }
                           
                        }
                    }            
                   
                    $total_case_fee += $case_fee;                    
                    $total_other_fee += $other_fee;                    
                    $exchange_usd = $exchange_usd;
                    $exchange_thb = $exchange_thb;
                    $exchange_rate = substr($exchange_usd * $exchange_thb,0,7);
                    
                    if($desk == 3){
                        if($item->change_currency==1){
                            $first_number += $item->medical_info->medical_amount2;
                        }else{
                            $first_number += substr($item->medical_info->medical_amount2 / $exchange_lak,0,7);;
                        }                  
                        $total_medical_expense = $first_number;
                    }elseif($desk == 4){
                        if($item->change_currency==1){
                            $first_number += $item->medical_info->medical_amount2;
                        }elseif($item->change_currency==2){
                            $first_number += substr($item->medical_info->medical_amount2 / $exchange_thb,0,5);
                        }else{
                            $first_number += substr($item->medical_info->medical_amount2 / $exchange_mmk,0,5);
                        }                    
                        $total_medical_expense = $first_number;
                    }else{
                        if($item->change_currency==1){
                            $first_number += substr($item->medical_info->medical_amount2 * $exchange_thb,0,7);
                        }else{
                            $first_number +=  $item->medical_info->medical_amount2;
                        }                  
                        $total_medical_expense = $first_number;
                    }
                    

                    $total_ba_svf += $ba_svf;

                    if($desk == 3){
                        if($item->change_currency==1){
                            $total_cashin =  $ba_svf + $case_fee + $item->medical_info->medical_amount2;
                        }else{
                            $total_cashin =  $ba_svf + $case_fee + substr($item->medical_info->medical_amount2 / $exchange_lak,0,5);
                        }
                        $total_cash_in += $total_cashin;
                    }elseif($desk == 4){
                        if($item->change_currency==1){
                            $total_cashin =  $ba_svf + $case_fee + $item->medical_info->medical_amount2;
                        }elseif($item->change_currency==2){
                            $total_cashin =  $ba_svf + $case_fee + substr($item->medical_info->medical_amount2 / $exchange_thb,0,5);
                        }else{
                            $total_cashin =  $ba_svf + $case_fee + substr($item->medical_info->medical_amount2 / $exchange_mmk,0,5);
                        }
                        $total_cash_in += $total_cashin;
                    }else{
                        if($item->change_currency==1){
                            $total_cashin =  $ba_svf + $case_fee + $first_number ;
                        }else{
                            $total_cashin =  $ba_svf + $case_fee + $item->medical_info->medical_amount2;
                        }
                        $total_cash_in += $total_cashin;
                    }

                    if($desk == 3){
                        if($item->change_currency==1){
                            $total_cashout =  $other_fee + $item->medical_info->medical_amount2;
                        }else{
                            $total_cashout =  $other_fee +substr($item->medical_info->medical_amount2 / $exchange_lak,0,5);
                        }
                        $total_cash_out += $total_cashout;
                    }elseif($desk == 4){
                        if($item->change_currency==1){
                            $total_cashout =  $other_fee + $item->medical_info->medical_amount2;
                        }elseif($item->change_currency==2){
                            $total_cashout =  $other_fee + substr($item->medical_info->medical_amount2 / $exchange_thb,0,5);
                        }else{
                            $total_cashout =  $other_fee + substr($item->medical_info->medical_amount2 / $exchange_mmk,0,5);
                        }
                        $total_cash_out += $total_cashout;
                    }else{
                        if($item->change_currency==1){
                            $total_cashout =  $other_fee+ $first_number ;
                        }else{
                            $total_cashout =  $other_fee+ $item->medical_info->medical_amount2;
                        }
                        $total_cash_out += $total_cashout;
                    }                    


                    $total_fit = $total_cashin - $total_cashout;
                    $insu_profit += $total_fit;

                    if($desk == 3){
                        if($item->change_currency==1){
                            $kb =  $item->medical_info->kb;
                        }else{
                            $kb =  substr($item->medical_info->kb / $exchange_lak,0,5) ;
                        }
                        $total_kb += $kb;
                    }elseif($desk == 4){
                        if($item->change_currency==1){
                            $kb =  $item->medical_info->kb;
                        }elseif($item->change_currency==2){
                            $kb =  substr($item->medical_info->kb / $exchange_thb,0,5) ;
                        }else{
                            $kb =  substr($item->medical_info->kb / $exchange_mmk,0,5) ;
                        }
                        $total_kb += $kb;
                    }else{
                        if($item->change_currency==1){
                            $kb =  substr($item->medical_info->kb * $exchange_thb,0,7) ;
                        }else{
                            $kb =  $item->medical_info->kb;
                        }
                        $total_kb += $kb;
                    }

                    $total_netfit = $total_fit + $kb;
                    $total_profit1 += $total_netfit;

                @endphp

                <td style="text-align:center;border:1px solid #000000;">{{$key+1}}</td>
                <td style="text-align:center;border:1px solid #000000;">{{date('d-m-Y',strtotime($item->invoice_date))}}</td>
                <td style="text-align:center;border:1px solid #000000;">{{ !empty($item->medical_info->ba_ref_no) ? $item->medical_info->ba_ref_no: '-' ?? '' }}</td>
                <td style="text-align:center;border:1px solid #000000;">{{ !empty($item->medical_info->hospital->name) ? $item->medical_info->hospital->name : "-" ?? '' }}</td>
                <td style="text-align:center;border:1px solid #000000;">1</td>
                <td style="text-align:center;border:1px solid #000000;"> {{ !empty($item->medical_info->insurance_id) ? $item->medical_info->insurance->company_name : '-' ?? '' }}</td>
                <td style="text-align:center;border:1px solid #000000;">
                    {{ !empty($item->medical_info->assistance_id) ? $item->medical_info->assistance->assistance_name : '-' ?? '' }}
             
                <td style="text-align:center;border:1px solid #000000;">
                    @if($country == 1 || $desk == 3)
                        $
                        @if($item->change_currency==1)
                            {{ !empty($item->medical_info->medical_amount2) ? $item->medical_info->medical_amount2 : "0.00" ?? '' }}
                        @else
                            {{ !empty($item->medical_info->medical_amount2) ?  substr($item->medical_info->medical_amount2/ $exchange_lak,0,7) : "0.00" ?? '' }}
                        @endif
                    @elseif($country == 3 || $desk == 4)
                        $
                        @if($item->change_currency==1)
                            {{ !empty($item->medical_info->medical_amount2) ? $item->medical_info->medical_amount2 : "" ?? '' }}
                        @elseif($item->change_currency==2)
                            {{ !empty($item->medical_info->medical_amount2) ?  substr($item->medical_info->medical_amount2/ $exchange_thb,0,5) : "" ?? '' }}
                        @else
                            {{ !empty($item->medical_info->medical_amount2) ?  substr($item->medical_info->medical_amount2/ $exchange_mmk,0,5) : "" ?? '' }}
                        @endif
                    @else 
                        ฿ 
                        @if($item->change_currency==1)
                         {{ !empty($item->medical_info->medical_amount2) ? substr($item->medical_info->medical_amount2 * $exchange_thb,0,7) : "0.00" ?? '' }}
                        {{--
                        @elseif($item->change_currency==3)
                            {{ !empty($item->medical_info->medical_amount2) ? substr(($item->medical_info->medical_amount2 / $exchange_usd) * $exchange_thb,0,7) : "0.00" ?? '' }}
                        --}}
                        @else
                            {{ !empty($item->medical_info->medical_amount2) ? $item->medical_info->medical_amount2 : "0.00" ?? '' }}
                        @endif
                    @endif                    
                   
                </td>     
                <td style="text-align:center;border:1px solid #000000;">
                    @if($country == 1 || $desk == 3)
                        $  
                        {{ $ba_svf ?? '0'}}
                       
                    @elseif($country == 3 || $desk == 4)
                        $
                        {{ $ba_svf ?? '0'}}
                    @else 
                        ฿   
                        {{ $ba_svf ?? '0'}}
                        
                    @endif                   
                </td>
                <td style="text-align:center;border:1px solid #000000;">
                    @if($country == 1 || $desk == 3)
                        $
                        {{ $case_fee ?? '0'}}
                    @elseif($country == 3 || $desk == 4)
                        $                        
                        {{ $case_fee ?? '0'}}                        
                    @else 
                        ฿ 
                        {{ $case_fee ?? '0'}}
                    @endif                    
                </td>
                <td style="text-align:center;border:1px solid #000000;">
                    @if($country == 1 || $desk == 3)
                        $
                        {{ $total_cashin ?? '0'}}
                    @elseif($country == 3 || $desk == 4)
                        $
                        {{ $total_cashin ?? '0'}}
                    @else 
                        ฿                         
                        {{ $total_cashin ?? '0'}}
                      
                    @endif
                </td>
                <td style="text-align:center;border:1px solid #000000;">
                    @if($country == 1 || $desk == 3)
                        $
                        @if($item->change_currency==1)
                            {{ !empty($item->medical_info->medical_amount2) ? $item->medical_info->medical_amount2 : "0.00" ?? '' }}
                        @else
                            {{ !empty($item->medical_info->medical_amount2) ?  substr($item->medical_info->medical_amount2/ $exchange_lak,0,7) : "0.00" ?? '' }}
                        @endif
                    @elseif($country == 3 || $desk == 4)
                        $
                        @if($item->change_currency==1)
                            {{ !empty($item->medical_info->medical_amount2) ? $item->medical_info->medical_amount2 : "0.00" ?? '' }}
                        @elseif($item->change_currency==2)
                            {{ !empty($item->medical_info->medical_amount2) ?  substr($item->medical_info->medical_amount2/ $exchange_thb,0,5) : "" ?? '' }}
                        @else
                            {{ !empty($item->medical_info->medical_amount2) ?  substr($item->medical_info->medical_amount2/ $exchange_mmk,0,5) : "0.00" ?? '' }}
                        @endif
                    @else 
                        ฿ 
                        @if($item->change_currency==1)
                         {{ !empty($item->medical_info->medical_amount2) ? substr($item->medical_info->medical_amount2 * $exchange_thb,0,7) : "0.00" ?? '' }}                        
                        @else
                            {{ !empty($item->medical_info->medical_amount2) ? $item->medical_info->medical_amount2 : "0.00" ?? '' }}
                        @endif
                    @endif
                </td>
                <td style="text-align:center;border:1px solid #000000;">
                    @if($country == 1 || $desk == 3)
                        $
                        {{ $other_fee ?? '0'}}
                    @elseif($country == 3 || $desk == 4)
                        $
                        {{ $other_fee ?? '0'}}                       
                    @else 
                        ฿                         
                        {{ $other_fee ?? '0'}}
                    @endif
                </td>
                <td style="text-align:center;border:1px solid #000000;">
                    @if($country == 1 || $desk == 3)
                        $
                       {{ $total_cashout ?? '0'}} 
                    @elseif($country == 3 || $desk == 4)
                        $
                        {{ $total_cashout ?? '0'}} 
                    @else 
                        ฿ 
                        {{ $total_cashout ?? '0'}}                        
                    @endif
                </td>
                <td style="text-align:center;border:1px solid #000000;">
                    @if($country == 1 || $desk == 3)
                        $
                        {{ $total_fit ?? '0'}}
                    @elseif($country == 3 || $desk == 4)
                        $
                       {{ $total_fit ?? '0'}}
                    @else 
                        ฿ 
                        {{ $total_fit ?? '0'}}
                    @endif
                </td>
                <td style="text-align:center;border:1px solid #000000;">
                    @if($country == 1 || $desk == 3)
                        $
                        {{ $kb ?? '0'}}
                    @elseif($country == 3 || $desk == 4)
                        $
                        {{ $kb ?? '0'}}
                    @else 
                        ฿                       
                        {{ $kb ?? '0'}}
                    @endif
                </td>               
                <td style="text-align:center;border:1px solid #000000;">
                    @if($country == 1 || $desk == 3)
                        $
                        {{ $total_netfit ?? ''}}
                    @elseif($country == 3 || $desk == 4)
                        $
                        {{ $total_netfit ?? ''}}
                    @else 
                        ฿ 
                        {{ $total_netfit ?? ''}}
                    @endif
                </td>
                @if ($country == 2)
                <td style="text-align:center;border:1px solid #000000;">-</td>
                @endif
                @if ($country == 2 || $desk == 1 || $desk == 2)
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;"></td>
                @endif
              </tr>
        @endforeach
          <tr></tr>
          @if ($country == 2 || $desk == 1 || $desk == 2)
            <tr style="background-color:#00B200">
                <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
                <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
                <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
                <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;"> {{$total_pax}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
                <td style="text-align:center;background-color:#a9d08e;border-top:1px solid #000000;border:1px solid #000000;"> Baht </td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">
                    ฿ {{$total_medical_expense ?? '0'}}
                </td>         
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_ba_svf}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_case_fee}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_cash_in}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_medical_expense}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_other_fee}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_cash_out}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$insu_profit}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_kb}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_profit1}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;"></td>                
            </tr>
            @else
            <tr style="background-color:#00B200">
                <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
                <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
                <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
                <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;"> {{$total_pax}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
                <td style="text-align:center;background-color:#a9d08e;border-top:1px solid #000000;border:1px solid #000000;"> Dollar </td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">$ {{$total_medical_expense}}</td>         
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">$ {{$total_ba_svf}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">$ {{$total_case_fee}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">$ {{$total_cash_in}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">$ {{$total_medical_expense}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">$ {{$total_other_fee}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">$ {{$total_cash_out}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">$ {{$insu_profit}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">$ {{$total_kb}}</td>
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">$ {{$total_profit1}}</td>
                @if ($country == 2 || $desk == 1 || $desk == 2)
                <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;"></td>
                @endif
            </tr>
        @endif
        @if ($country == 1 || $country == 3  || $desk == 3 || $desk == 4)
           <tr style="background-color:#00B200">

            <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
            <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
            <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
            <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
            <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;background-color:#000000;color:#FFFFFF;"> Thai </td>
            <td style="text-align:center;border-top:1px solid #000000;border-bottom:1px solid #000000;"></td>
            <td style="text-align:center;background-color:#a9d08e;border-top:1px solid #000000;border:1px solid #000000;"> Bahts </td>
            <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_medical_expense * $exchange_rate}}</td>         
            <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_ba_svf * $exchange_rate }}</td>
            <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_case_fee * $exchange_rate }}</td>
            <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_cash_in * $exchange_rate }}</td>
            <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_medical_expense * $exchange_rate }}</td>
            <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_other_fee * $exchange_rate }}</td>
            <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_cash_out * $exchange_rate }}</td>
            <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$insu_profit * $exchange_rate}}</td>
            <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_kb * $exchange_rate}}</td>
            <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{$total_profit1 * $exchange_rate}}</td>
            
          </tr>
        @endif

        <tr style="background-color:#00B200;">
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>         
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td>
            <td style="text-align:center;"></td> 
            <td style="text-align:center;"></td>         
            <td colspan="2" style="text-align:center;font-weight: bold;font-size: 14px;background-color:#70ad47;border:1px solid #70ad47;color: #FFFFFF;">Total Profit</td>

            @if ($country == 2 || $desk == 1 || $desk == 2)
            <td style="text-align:center;border:1px solid #000000;background-color:#70ad47;font-size: 14px;font-weight:bold;color: #FFFFFF; ">
                ฿ {{$total_profit1}}
            </td>
            @else
            <td style="text-align:center;border:1px solid #000000;background-color:#70ad47;font-size: 14px;font-weight:bold;color: #FFFFFF; ">฿ {{$total_profit1 * $exchange_rate}}</td>
            @endif
           @if ($country == 2 || $desk == 1 || $desk == 2)
            <td style="text-align:center;border-top:1px solid #000000;border:1px solid #000000;">฿ {{ round(($total_profit1) / $total_pax , 2) }}</td>
            @endif
          </tr>         
  </tbody>
</table>