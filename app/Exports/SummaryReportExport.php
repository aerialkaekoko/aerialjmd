<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Invoice;
use App\MedicalInformation;
use App\InvoiceDescription;
use DB;

class SummaryReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($from_date, $to_date,$country_id,$invoice_array){	
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->country_id = $country_id;
        $this->invoice_array = $invoice_array;
        $this->user = auth()->user();
    }
    public function view(): View
    {
        if ($this->user->name == 'admin') {
            $country_id = $this->country_id;
            $invoice_id = $this->invoice_array;
            if (isset($this->from_date) && isset($this->to_date)) {
                $summary_report = Invoice::whereDate('created_at','>=',$this->from_date)->whereDate('created_at','<=',$this->to_date)->get();
            }elseif(isset($invoice_id)){                
                $summary_report = Invoice::whereIn('id',$invoice_id)->get();               
            }elseif(isset($this->country_id)){
                $country = $this->country_id;
                $summary_report = Invoice::whereHas('medical_info',function($query) use ($country){
                    $query->whereHas('hospital',function($q) use ($country){
                        $q->where('country',$country);
                    });
                })->get();
            }else{
                $summary_report = Invoice::get();
            }
        }else{
            $country_id = $this->user->country;
            if (isset($this->from_date) && isset($this->to_date)) {
                $summary_report = Invoice::whereDate('created_at','>=',$this->from_date)
                                    ->whereDate('created_at','<=',$this->to_date)
                                    ->whereHas('medical_info',function($query) use ($country_id){
                                    $query->whereHas('hospital',function($q) use ($country_id){
                                    $q->where('country',$country_id);
                                    });
                                    })->get();
            }else{
                $summary_report = Invoice::whereHas('medical_info',function($query) use ($country_id){
                                    $query->whereHas('hospital',function($q) use ($country_id){
                                    $q->where('country',$country_id);
                                    });
                                    })->get();
            }
        }
        return view('admin.reports.summary_report_excel', [
            'invoices' => $summary_report,'country' => $country_id
        ]);
    }
}
