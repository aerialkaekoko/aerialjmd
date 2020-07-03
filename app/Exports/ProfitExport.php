<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Invoice;
use DB;

class ProfitExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($start_date, $end_date,$country_id,$desk_id,$exchange_usd,$exchange_thb,$exchange_mmk,$exchange_lak){   
        $this->from_date = $start_date;
        $this->to_date = $end_date;
        $this->country_id = $country_id;
        $this->desk_id = $desk_id;
        $this->user = auth()->user();
        $this->exchange_usd = $exchange_usd;
        $this->exchange_thb = $exchange_thb;
        $this->exchange_mmk = $exchange_mmk;
        $this->exchange_lak = $exchange_lak;
    }

    public function view(): View
    {
        if ($this->user->name == 'admin') {
            $country_id = $this->country_id;
            if (isset($this->start_date) && isset($this->to_date)) {
                $invoices = Invoice::whereDate('created_at','>=',$this->start_date)->whereDate('created_at','<=',$this->to_date)->get();
            }elseif(isset($this->country_id)){
                $country = $this->country_id;
                $invoices = Invoice::whereHas('medical_info',function($query) use ($country){
                    $query->whereHas('hospital',function($q) use ($country){
                        $q->where('country',$country);
                    });
                })->get();

            }elseif($this->desk_id){
                $desk = $this->desk_id;
                switch ($desk) {
                    case 1:
                        $code = "A";
                        break;
                    case 2:
                        $code = "P";
                        break;
                    case 3:
                        $code = "L";
                        break;
                    
                    default:
                        $code = "M";
                        break;
                }
                $invoices = Invoice::whereHas('medical_info',function($query) use ($code){
                    $query->whereHas('hospital',function($q) use ($code){
                        $q->where('country_code',$code);
                    });
                })->get();
            }else{
                $invoices = Invoice::get();
            }
        }else{
            $country_id = $this->user->country;
            if (isset($this->from_date) && isset($this->to_date)) {
                $invoices = Invoice::whereDate('created_at','>=',$this->from_date)
                                ->whereDate('created_at','<=',$this->to_date)
                                ->whereHas('medical_info',function($query) use ($country_id){
                                    $query->whereHas('hospital',function($q) use ($country_id){
                                        $q->where('country',$country_id);
                                });
                })->get();
            }else{
                $invoices = Invoice::whereHas('medical_info',function($query) use ($country_id){
                    $query->whereHas('hospital',function($q) use ($country_id){
                        $q->where('country',$country_id);
                    });
                })->get();
            }
        }
        // dd($invoices);
        return view('admin.reports.profit_reports_excel', [
            'profits' => $invoices,'country' => $country_id,'desk' => $this->desk_id,'exchange_usd' => $this->exchange_usd,'exchange_thb' => $this->exchange_thb,'exchange_mmk' => $this->exchange_mmk,'exchange_lak' => $this->exchange_lak

            // $from = $invoices->company_name;
            // dd($from);
            //  $from = date('2019-09-01');
            // $to = date('2019-09-10');
            // Reservation::whereBetween('reservation_from', [$from, $to])->get();
            // Reservation::all()->filter(function($profits) {
            //   if (Invoice::now->between($profits->from, $profits->to) {
            //     return $item;
            //   }
            // });

        ]);
    }
}
