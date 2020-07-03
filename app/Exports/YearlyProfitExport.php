<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Invoice;
use DB;

class YearlyProfitExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($year,$desk_id,$exchange_usd,$exchange_thb,$exchange_mmk,$exchange_lak){    
        $this->year = $year;
        $this->desk_id = $desk_id;
        $this->user = auth()->user();
        $this->exchange_usd = $exchange_usd;
        $this->exchange_thb = $exchange_thb;
        $this->exchange_mmk = $exchange_mmk;
        $this->exchange_lak = $exchange_lak;
    }

    public function view(): View
    {       
        $yearly_profit_reports = Invoice::get();
        $data = [];        
        for ($start_month=1; $start_month <= 12 ; $start_month++) {
          if ($this->user->name == 'admin') {
            if($this->desk_id){
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
                $data[$start_month] = Invoice::whereHas('medical_info',function($query) use ($code){
                    $query->whereHas('hospital',function($q) use ($code){
                        $q->where('country_code',$code);
                    });
                })->whereYear('created_at', '=', $this->year)
                      ->whereMonth('created_at', '=', $start_month)
                      ->get();
            }else{
              dd("DD");
                 $data[$start_month] = Invoice::with('medical_info')->whereYear('created_at', '=', $this->year)
                      ->whereMonth('created_at', '=', $start_month)
                      ->get();
             }
          }else{
             $country_id = $this->user->country;
                $data[$start_month] = Invoice::whereHas('medical_info',function($query) use ($country_id){
                      $query->whereHas('hospital',function($q) use ($country_id){
                          $q->where('country',$country_id);
                      });
                   })
                  ->whereYear('created_at', '=', $this->year)
                        ->whereMonth('created_at', '=', $start_month)
                        ->get();
                  $country = $country_id;
          }
        }        
        // dd($invoices);
        return view('admin.reports.yearly_profit_reports_excel', [
            'profits' => $data,'year'=>$this->year,'desk' => $this->desk_id,'exchange_usd' => $this->exchange_usd,'exchange_thb' => $this->exchange_thb,'exchange_mmk' => $this->exchange_mmk,'exchange_lak' => $this->exchange_lak
        ]);
    }
}
