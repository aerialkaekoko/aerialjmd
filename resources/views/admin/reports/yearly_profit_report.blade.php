@extends('layouts.admin')
@section('styles')
    <style>
        .dt-buttons{
            display: none;
        }
        .button{
            display: block;
            width: 115px;
            height: 41px;
            background: #4E9CAF;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            float: left;
            margin: 0 3px;
        }
    </style>
@endsection
@section('content')
@if (session('alert'))
    <div class="alert alert-warning">
        {{ session('alert') }}
    </div>
@endif
<div class="card">
    <div class="card-header">
        <h3 style="text-align: left;float: left;">Yearly Profit/Loss Report Lists</h3>
    </div>    
    <div class="card-body">
        <div class="row my-2">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-6">
                        <h3>JMD (Year {{$year}})</h3>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('admin.yearly_profit_reports')}}?year={{$year-1}}" class="button">Previous</a>
                        @if($year < date('Y'))
                            <a href="{{route('admin.yearly_profit_reports')}}?year={{$year+1}}" class="button">Next</a> 
                        @endif                                           
                    </div>
                </div>
            </div>
            @if(auth()->user()->name == 'admin')
                {{--
                <div class="col-md-2">
                    <select class="form-control" id="country">
                        <option value="">All Country</option>
                        @foreach(trans('cruds.countries') as $key=>$value)
                            <option value="{{$key}}" {{ (Request::get('country_id') == $key) ? 'selected' : '' }}>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                --}}
                <div class="col-md-2">
                    <select class="form-control" id="desk" style="font-size: 15px;">
                        {{-- <option value="">All Desk</option> --}}
                            @foreach(trans('cruds.desk') as $key=>$value)
                            <option value="{{$key}}" {{ (Request::get('desk_id') == $key) ? 'selected' : '' }}>{{$value}}</option>
                            @endforeach
                    </select>
                </div>
            @endif
            <div class="{{auth()->user()->name == 'admin'?'col-md-3':'col-md-5'}} text-right">
                    <a href="{{route('admin.yearly_profit_reports_excel')}}?start_date={{Request::get('start_date')}}&to_date={{Request::get('to_date')}}&desk_id={{Request::get('desk_id')}}" class="btn btn-md btn-success"><span class="fa fa-download"></span>Yearly Profit Download</a>
            </div>
        </div>
        <div class="table-responsive">
<table class=" table table-bordered table-striped table-hover datatable datatable-Insurance">
  <thead>
    <tr>
        <th>No.</th>
        <th> Month  </th>
        <th> PAX </th>
        <th> Medical Exp: </th>
        <th> BA SVF </th>
        <th> Case Fee </th>
        <th> Total Cash In </th>
        <th> Medical Exp: </th>
        <th> Other Fee </th>
        <th> Total Cash Out </th>
        <th> Profit </th>
        <th> KB </th>
        <th> Total Profit </th>
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
       @foreach ($data as $key=>$item)
          <tr data-entry-id="{{ $key }}">
            <td>{{$key}}</td>
            <td>
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
                    <td>{{$total_pax}}</td>
                    <td>
                        @if($desk==3 || $desk==4)
                            $
                        @else
                            ฿
                        @endif
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
                    <td>
                        {{--
                        @if ($country == 1)
                            {{$total_ba_svf * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_ba_svf * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_ba_svf}}
                        @endif
                        --}}
                         @if($desk==3 || $desk==4)
                            $
                        @else
                            ฿
                        @endif
                        {{$total_ba_svf}}
                    </td>
                    <td>
                        {{--
                        @if ($country == 1)
                            {{$total_case_fee * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_case_fee * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_case_fee}}
                        @endif
                        --}}
                         @if($desk==3 || $desk==4)
                            $
                        @else
                            ฿
                        @endif
                        {{$total_case_fee}}
                    </td>
                    <td>
                        {{--
                        @if ($country == 1)
                            {{$total_cash_in * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_cash_in * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_cash_in}}
                        @endif
                        --}}
                         @if($desk==3 || $desk==4)
                            $
                        @else
                            ฿
                        @endif
                        {{$total_cash_in}}
                    </td>
                    <td>
                        {{--
                        @if ($country == 1)
                            {{$total_medical_expense * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_medical_expense * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_medical_expense}}
                        @endif
                        --}}
                         @if($desk==3 || $desk==4)
                            $
                        @else
                            ฿
                        @endif
                        {{$total_medical_expense}}
                    </td>
                    <td>
                        {{--
                        @if ($country == 1)
                            {{$total_other_fee * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_other_fee * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_other_fee}}
                        @endif
                        --}}
                         @if($desk==3 || $desk==4)
                            $
                        @else
                            ฿
                        @endif
                        {{$total_other_fee}}
                    </td>
                    <td>
                        {{--
                        @if ($country == 1)
                            {{$total_cash_out * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_cash_out * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_cash_out}}
                        @endif
                        --}}
                         @if($desk==3 || $desk==4)
                            $
                        @else
                            ฿
                        @endif
                        {{$total_cash_out}}
                    </td>
                    <td>
                        {{--
                        @if ($country == 1)
                            {{$sum_profit * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$sum_profit * $v->medical_info->exchange_thb}}
                        @else
                            {{$sum_profit}}
                        @endif
                        --}}
                         @if($desk==3 || $desk==4)
                            $
                        @else
                            ฿
                        @endif
                        {{ $total_fit1 }}
                    </td>    
                    <td>
                        {{--
                        @if ($country == 1)
                            {{$total_kb * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_kb * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_kb}}
                        @endif
                        --}}
                         @if($desk==3 || $desk==4)
                            $
                        @else
                            ฿
                        @endif
                        {{$total_kb}}
                    </td>
                    <td>
                        {{--
                        @if ($country == 1)
                            {{$total_profit * $v->medical_info->exchange_thb}}
                        @elseif ($country == 3)
                            {{$total_profit * $v->medical_info->exchange_thb}}
                        @else
                            {{$total_profit}}
                        @endif
                        --}}
                         @if($desk==3 || $desk==4)
                            $
                        @else
                            ฿
                        @endif
                        {{$total_profit}}
                    </td>
                @else
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                @endif                                                    
            </tr>
      @endforeach
          <tr>        
            <td colspan="12" style="text-align:right;font-weight: bold;font-size: 14px;color: #000000;">Total</td>
            <td style="text-align:center;font-size: 14px;font-weight:bold;color: #000000; ">
                {{--
                @if ($country == 1)
                    ฿ {{$total_profit1}}
                @elseif ($country == 3)
                    ฿ {{$total_profit1 }}
                @else
                    ฿ {{$total_profit1}}
                @endif
                --}}
                 @if($desk==3 || $desk==4)
                            $
                        @else
                            ฿
                        @endif
                {{$total_profit1}}
            </td>
          </tr>                    
  </tbody>
</table>
        </div>
            
    </div>
</div>
</div>
@endsection
@section('scripts')
@parent
<script>
   $(document).ready(function(){
        $('#start_date').datepicker({  dateFormat : 'yy-mm-dd'});
        $('#to_date').datepicker(  {dateFormat : 'yy-mm-dd'});

        $('#country').on('change', function() {
        var url = "{{route('admin.yearly_profit_reports')}}?year={{$year}}&country_id="+$(this).val();
            if (url) {
                window.location = url;
            }
        return false;
        });

        $('#desk').on('change', function() {
            var url = "{{route('admin.yearly_profit_reports')}}?desk_id="+$(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });
   });

   $( '#btn_export_profille' ).click(function(){

        $( '#hidden_start_date' ).val( $( '#start_date' ).val() );
        $( '#hidden_end_date' ).val( $( '#to_date' ).val() );
        $( '#frmExportProfit' ).submit();
   });

</script>
@endsection