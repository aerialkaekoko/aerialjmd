<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Invoice;
use App\MedicalInformation;
use App\InvoiceDescription;
use DB;

class SummaryExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function __construct($from_date,$to_date,$country_id,$exchange_usd,$exchange_thb,$exchange_mmk,$exchange_lak){  
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->country_id = $country_id;
        $this->user = auth()->user();
        $this->exchange_usd = $exchange_usd;
        $this->exchange_thb = $exchange_thb;
        $this->exchange_mmk = $exchange_mmk;
        $this->exchange_lak = $exchange_lak;
    }
    public function view(): View
    { 
        if($this->user->name == 'admin') {
            $country_id = $this->country_id;
            if (isset($this->from_date) && isset($this->to_date)) {
                $invoice = Invoice::whereDate('created_at','>=',$this->from_date)->whereDate('created_at','<=',$this->to_date)->get();
            }elseif(isset($this->country_id)){
                $country = $this->country_id;
                $invoice = Invoice::whereHas('medical_info',function($query) use ($country){
                    $query->whereHas('hospital',function($q) use ($country){
                    $q->where('country',$country);
                    });
                })->get();
            }else{
                $invoice = Invoice::all();
            }
        }else{
            $country_id = $this->user->country;
            $desk_id = $this->user->desk;
            if (isset($this->from_date) && isset($this->to_date)) {
                $invoice = MedicalInformation::whereDate('treatment_date','>=',$this->from_date)->whereDate('treatment_date','<=',$this->to_date)->whereHas('hospital',function($query) use ($country_id){
                    $query->where('country',$country_id);
                })->get();
            }elseif($this->country_id){
                $invoice = MedicalInformation::whereHas('hospital',function($query) use ($country_id){
                    $query->where('country',$country_id);
                })->get();
            }
            else{
                $invoice = Invoice::all();
            }
        }

       

        return view('admin.reports.summary_detail_excel', [
            'invoice' => $invoice,'country' => $this->country_id,'exchange_usd' => $this->exchange_usd,'exchange_thb' => $this->exchange_thb,'exchange_mmk' => $this->exchange_mmk,'exchange_lak' => $this->exchange_lak
        ]);
    }
}
