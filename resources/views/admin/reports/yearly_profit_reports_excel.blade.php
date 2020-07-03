<table class="profit_report">
  <thead>
    <tr>
        <td colspan="3" style="text-align:center;font-size: 14px;font-weight: bold;height: 20px;">
             @if ($desk == 4)
                JMDM( Year-{{$year}}) 
            @elseif ($desk == 3)
                JMDL( Year-{{$year}})
            @elseif ($desk == 1)
                JMDA( Year-{{$year}})
            @else
                JMDP(Year-{{$year}}) 
            @endif
            
        </td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td colspan="4" style="text-align:center;font-size: 14px;font-weight: bold;background-color:#70ad47;color:#ffffff;height: 20px;"> Cash In</td>
        <td colspan="3" style="text-align:center;background-color:#70ad47;color:#ffffff;font-size: 14px;font-weight: bold;height: 20px;"> Cash Out</td>
    </tr>
    <tr style="background-color:#00B200">
         <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;width: 5px;border-top: 2px solid #000000;">No.</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 2px solid #000000;">Month</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 2px solid #000000;">PAX</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 2px solid #000000;">MD Expense</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 2px solid #000000;">BA SVF</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;width: 9px;border-top: 2px solid #000000;">Case Fee</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;border-top: 2px solid #000000;">Total</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 2px solid #000000;">MD Expense</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;width: 12px;border-top: 2px solid #000000;">Other Fee</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;border-top: 2px solid #000000;">Total</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;border-top: 2px solid #000000;">Profit</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;border-top: 2px solid #000000;">KB</th>
        <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #ffffff;background-color:#70ad47;width: 15px;border-top: 2px solid #000000;">Total Profit</th>
    </tr>
  </thead>
  <tbody>
       @php 
            $total_profit1 = 0;
            $total_pax1 = 0;
            $total_medical_expense1 =0;
            $total_fit2 = 0;
            $total_ba_svf1= 0;
            $total_case_fee1 = 0;
            $total_other_fee1 = 0;
            $total_cash_in1 = 0;
            $total_cash_out1 = 0;
            $total_kb1 = 0;
       @endphp
       @foreach ($profits as $key=>$item)
          <tr data-entry-id="{{ $key }}">
            <td style="text-align:center;border:1px solid #000000;">{{$key}}</td>
            <td style="text-align:center;border:1px solid #000000">
                @php
                    $dateObj   = DateTime::createFromFormat('!m', $key);
                    $monthName = $dateObj->format('M');
                @endphp
                {{ $monthName }}
            </td>
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
                $insu_profit = 0;
                $cash_profit = 0;
                $exchange_rate = 0;
                $summary_profit = 0;
                $total_fit = 0;
                $total_fit1=0; 
                $first_number = 0;  
            @endphp
            @if($item->count() > 0)
                @foreach($item as $k=>$v)
                    @php

                      
                    $ba_svf = 0;
                    foreach ($v->description($v->id) as $desc) {
                        if($desc->invoice_description_id==1 || $desc->invoice_description_id==3 || $desc->invoice_description_id==4 || $desc->invoice_description_id==6 || $desc->invoice_description_id==7 || $desc->invoice_description_id==8){
                            if($desk == 3){
                                if($v->change_currency==1){
                                    $ba_svf += $desc->amount;
                                }else{
                                    $ba_svf +=  substr($desc->amount / $exchange_lak,0,7);;

                                }
                            }elseif($desk == 4){
                                if($v->change_currency==1){
                                    $ba_svf += $desc->amount;
                                }elseif($v->change_currency==2){
                                    $ba_svf +=  substr($desc->amount / $exchange_thb,0,7);
                                }else{
                                    $ba_svf +=  substr($desc->amount / $exchange_mmk,0,7);;

                                }
                            }else{
                                if($v->change_currency==1){
                                    $ba_svf += substr($desc->amount * $exchange_thb,0,7);
                                }else{
                                    $ba_svf += $desc->amount ;
                                }
                            }
                            
                        }
                    }

                    $case_fee = 0;
                    foreach ($v->description($v->id) as $desc) {
                        if($desc->invoice_description_id==5){
                            if($desk == 3){
                                if($v->change_currency==1){
                                    $case_fee += $desc->amount;
                                }else{
                                    $case_fee +=  substr($desc->amount / $exchange_lak,0,7);;

                                }
                            }elseif($desk == 4){
                                if($v->change_currency==1){
                                    $case_fee += $desc->amount;
                                }elseif($v->change_currency==2){
                                    $case_fee +=  substr($desc->amount / $exchange_thb,0,7);
                                }else{
                                    $case_fee +=  substr($desc->amount / $exchange_mmk,0,7);;

                                }
                            }else{
                                if($v->change_currency==1){
                                    $case_fee += substr($desc->amount * $exchange_thb,0,7);
                                }else{
                                    $case_fee += $desc->amount ;
                                }
                            }
                            
                        }
                    }
                    $other_fee = 0;
                    foreach ($v->description($v->id) as $desc) {
                        if($desc->invoice_description_id==1){
                            if($desk == 3){
                                if($v->change_currency==1){
                                    $other_fee += $desc->amount;
                                }else{
                                    $other_fee +=  substr($desc->amount / $exchange_lak,0,7);;

                                }
                            }elseif($desk == 4){
                                if($v->change_currency==1){
                                    $other_fee += $desc->amount;
                                }elseif($v->change_currency==2){
                                    $other_fee +=  substr($desc->amount / $exchange_thb,0,7);
                                }else{
                                    $other_fee +=  substr($desc->amount / $exchange_mmk,0,7);;

                                }
                            }else{
                                if($v->change_currency==1){
                                    $other_fee += substr($desc->amount * $exchange_thb,0,7);
                                }else{
                                    $other_fee += $desc->amount ;
                                }
                            }
                           
                        }
                    }

                    $total_other_fee += $other_fee;

                    if($desk == 3){
                        if($v->change_currency==1){
                            $first_number += $v->medical_info->medical_amount2;
                        }else{
                            $first_number += substr($v->medical_info->medical_amount2 / $exchange_lak,0,7);;
                        }                  
                        $total_medical_expense = $first_number;
                    }elseif($desk == 4){
                        if($v->change_currency==1){
                            $first_number += $v->medical_info->medical_amount2;
                        }elseif($v->change_currency==2){
                            $first_number += substr($v->medical_info->medical_amount2 / $exchange_thb,0,5);
                        }else{
                            $first_number += substr($v->medical_info->medical_amount2 / $exchange_mmk,0,5);
                        }                    
                        $total_medical_expense = $first_number;
                    }else{
                        if($v->change_currency==1){
                            $first_number += substr($v->medical_info->medical_amount2 * $exchange_thb,0,7);
                        }else{
                            $first_number +=  $v->medical_info->medical_amount2;
                        }                  
                        $total_medical_expense = $first_number;
                    }

                    if($desk == 3){
                       if($v->change_currency==1){
                            $total_cashin =  $ba_svf + $case_fee + $v->medical_info->medical_amount2;
                        }else{
                            $total_cashin =  $ba_svf + $case_fee + substr($v->medical_info->medical_amount2 / $exchange_lak,0,5);
                        }
                        $total_cash_in += $total_cashin;
                    }elseif($desk == 4){
                        if($v->change_currency==1){
                            $total_cashin =  $ba_svf + $case_fee + $v->medical_info->medical_amount2;
                        }else if($v->change_currency==2){
                            $total_cashin =  $ba_svf + $case_fee + substr($v->medical_info->medical_amount2 / $exchange_thb,0,5);
                        }else{
                            $total_cashin =  $ba_svf + $case_fee + substr($v->medical_info->medical_amount2 / $exchange_mmk,0,5);
                        }
                        $total_cash_in += $total_cashin;
                    }else{
                        if($v->change_currency==1){
                            $total_cashin =  $ba_svf + $case_fee + $first_number ;
                        }else{
                            $total_cashin =  $ba_svf + $case_fee + $v->medical_info->medical_amount2;
                        }
                        $total_cash_in += $total_cashin;
                    }


                    if($desk == 3){
                        if($v->change_currency==1){
                            $total_cashout =  $other_fee + $v->medical_info->medical_amount2;
                        }else{
                            $total_cashout =  $other_fee + substr($v->medical_info->medical_amount2 / $exchange_lak,0,5);
                        }
                        $total_cash_out += $total_cashout;
                    }elseif($desk == 4){
                        if($v->change_currency==1){
                            $total_cashout =  $other_fee + $v->medical_info->medical_amount2;
                        }elseif($v->change_currency==2){
                            $total_cashout =  $other_fee + substr($v->medical_info->medical_amount2 / $exchange_thb,0,5);
                        }else{
                            $total_cashout =  $other_fee + substr($v->medical_info->medical_amount2 / $exchange_mmk,0,5);
                        }
                        $total_cash_out += $total_cashout;
                    }else{
                        if($v->change_currency==1){
                            $total_cashout =  $other_fee+ $first_number ;
                        }else{
                            $total_cashout =  $other_fee+ $v->medical_info->medical_amount2;
                        }
                        $total_cash_out += $total_cashout;
                    }

                    $total_fit = $total_cashin - $total_cashout;
                    $total_fit1 +=$total_fit;

                    if($desk == 3){
                        if($v->change_currency==1){
                            $kb =  $v->medical_info->kb;
                        }else{
                            $kb =  substr($v->medical_info->kb / $exchange_lak,0,5) ;
                        }
                        $total_kb += $kb;
                    }elseif($desk == 4){
                        if($v->change_currency==1){
                            $kb =  $v->medical_info->kb;
                        }elseif($v->change_currency==2){
                            $kb =  substr($v->medical_info->kb / $exchange_thb,0,5) ;
                        }else{
                            $kb =  substr($v->medical_info->kb / $exchange_mmk,0,5) ;
                        }
                        $total_kb += $kb;
                    }else{
                        if($v->change_currency==1){
                            $kb =  substr($v->medical_info->kb * $exchange_thb,0,7) ;
                        }else{
                            $kb =  $v->medical_info->kb;
                        }
                        $total_kb += $kb;
                    }

                    $total_netfit = $total_fit + $kb;
                    $total_profit += $total_netfit;
                        
                        $total_pax += 1;
                        $total_ba_svf += $ba_svf;
                        $total_case_fee += $case_fee;
                        
                        
                    @endphp
                    
                @endforeach
                    @php
                        $total_pax1 += $total_pax;
                        $total_medical_expense1 += $total_medical_expense;
                        $total_fit2 += $total_fit1;
                        $total_ba_svf1 += $total_ba_svf;
                        $total_case_fee1 += $total_case_fee;
                        $total_other_fee1 += $total_other_fee;
                        $total_cash_in1 +=$total_cash_in;
                        $total_cash_out1 +=$total_cash_out;
                        $total_kb1 +=$total_kb;
                        $total_profit1 += $total_profit;
                    @endphp
                    <td style="text-align:center;height: 32px;border: 1px solid #000000;">{{$total_pax}}</td>
                    <td style="text-align:center;border: 1px solid #000000;">
                        {{$total_medical_expense}}
                        {{--
                         @if ($country == 1)
                            {{$total_medical_expense * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_medical_expense * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_medical_expense}}
                        @endif
                        --}}
                    </td>
                    <td style="text-align:center;border: 1px solid #000000;">
                        {{--
                        @if ($country == 1)
                            {{$total_ba_svf * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_ba_svf * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_ba_svf}}
                        @endif
                        --}}
                        {{$total_ba_svf}}
                    </td>
                    <td style="text-align:center;border: 1px solid #000000;">
                        {{--
                        @if ($country == 1)
                            {{$total_case_fee * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_case_fee * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_case_fee}}
                        @endif
                        --}}
                        {{$total_case_fee}}
                    </td>
                    <td style="text-align:center;border: 1px solid #000000;">
                        {{--
                        @if ($country == 1)
                            {{$total_cash_in * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_cash_in * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_cash_in}}
                        @endif
                        --}}
                        {{$total_cash_in}}
                    </td>
                    <td style="text-align:center;border: 1px solid #000000;">
                        {{--
                        @if ($country == 1)
                            {{$total_medical_expense * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_medical_expense * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_medical_expense}}
                        @endif
                        --}}
                        {{$total_medical_expense}}
                    </td>
                    <td style="text-align:center;border: 1px solid #000000;">
                        {{--
                        @if ($country == 1)
                            {{$total_other_fee * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_other_fee * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_other_fee}}
                        @endif
                        --}}
                        {{$total_other_fee}}
                    </td>
                    <td style="text-align:center;border: 1px solid #000000;">
                        {{--
                        @if ($country == 1)
                            {{$total_cash_out * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_cash_out * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_cash_out}}
                        @endif
                        --}}
                        {{$total_cash_out}}
                    </td>
                    <td style="text-align:center;border: 1px solid #000000;">
                        {{--
                        @if ($country == 1)
                            {{$sum_profit * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$sum_profit * $v->medical_info->exchange_thb}}
                        @else
                            {{$sum_profit}}
                        @endif
                        --}}
                        {{ $total_fit1 }}
                    </td>    
                    <td style="text-align:center;border: 1px solid #000000;">
                        {{--
                        @if ($country == 1)
                            {{$total_kb * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_kb * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_kb}}
                        @endif
                        --}}
                        {{$total_kb}}
                    </td>
                    <td style="text-align:center;border: 1px solid #000000;">
                        {{--
                        @if ($country == 1)
                            {{$total_profit * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_profit * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_profit}}
                        @endif
                        --}}
                        {{$total_profit}}
                    </td>
                @else
                    <td style="text-align:center;height: 32px;border: 1px solid #000000;">0</td>
                    <td style="text-align:center;border: 1px solid #000000;">0</td>
                    <td style="text-align:center;border: 1px solid #000000;">0</td>
                    <td style="text-align:center;border: 1px solid #000000;">0</td>
                    <td style="text-align:center;border: 1px solid #000000;">0</td>
                    <td style="text-align:center;border: 1px solid #000000;">0</td>
                    <td style="text-align:center;border: 1px solid #000000;">0</td>
                    <td style="text-align:center;border: 1px solid #000000;">0</td>
                    <td style="text-align:center;border: 1px solid #000000;">0</td>
                    <td style="text-align:center;border: 1px solid #000000;">0</td>
                    <td style="text-align:center;border: 1px solid #000000;">0</td>
                @endif                                                    
            </tr>
      @endforeach
        <tr style="background-color:#00B200;">
            <td></td>
            <th style="text-align:center;font-size: 12px;font-weight: bold;vertical-align: middle;height: 20px;color: #000000;border-top: 2px solid #000000;">Total</th>
            <td style="text-align:center;border: 1px solid #000000;">
                {{ $total_pax1 }}
            </td>
             <td style="text-align:center;border: 1px solid #000000;">
                {{ $total_medical_expense1 }}
            </td>
             <td style="text-align:center;border: 1px solid #000000;">
                {{ $total_ba_svf1 }}
            </td>
            <td style="text-align:center;border: 1px solid #000000;">
                {{ $total_case_fee1 }}
            </td>
             <td style="text-align:center;border: 1px solid #000000;">
                {{ $total_cash_in1 }}
            </td>
             <td style="text-align:center;border: 1px solid #000000;">
                {{ $total_medical_expense1 }}
            </td>
            <td style="text-align:center;border: 1px solid #000000;">
                {{ $total_other_fee1 }}
            </td>
             <td style="text-align:center;border: 1px solid #000000;">
                {{ $total_cash_out1 }}
            </td>
             <td style="text-align:center;border: 1px solid #000000;">
                {{ $total_fit2 }}
            </td>
            <td style="text-align:center;border: 1px solid #000000;">
                {{ $total_kb1 }}
            </td>
            <td style="text-align:center;border: 1px solid #000000;">
                {{ $total_profit1 }}
            </td>
          </tr>

          <tr style="background-color:#00B200;">        
            <td colspan="12" style="text-align:right;font-weight: bold;font-size: 14px;background-color:#70ad47;border:1px solid #000000;color: #FFFFFF;">Yearly Profit</td>
            <td style="text-align:center;border:1px solid #000000;background-color:#70ad47;font-size: 14px;font-weight:bold;color: #FFFFFF; ">
                {{--
                @if ($country == 1)
                    ฿ {{$total_profit1}}
                @elseif ($country == 3)
                    ฿ {{$total_profit1 }}
                @else
                    ฿ {{$total_profit1}}
                @endif
                --}}
                {{$total_profit1}}
            </td>
            <td style="text-align:center;text-align: right;"></td>
          </tr>                    
  </tbody>
</table>