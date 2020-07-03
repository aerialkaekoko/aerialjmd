<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Invoice;
use App\Insurance;
use App\Assistance;

class InvoiceExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($from_date, $to_date,$country_id,$search){	
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->country_id = $country_id;
        $this->search = $search;
        $this->user = auth()->user();
    }
    public function view(): View
    {
        if ($this->user->name == 'admin') {
            $country_id = $this->country_id;
            if (isset($this->from_date) && isset($this->to_date)) {
                $invoice_reports = Invoice::whereDate('created_at','>=',$this->from_date)->whereDate('created_at','<=',$this->to_date)->get();
            }elseif(isset($this->country_id)){
                $country = $this->country_id;
                $invoice_reports = Invoice::whereHas('medical_info',function($query) use ($country){
                    $query->whereHas('hospital',function($q) use ($country){
                        $q->where('country',$country);
                    });
                })->get();


            }elseif(isset($this->search)){
                $search = $this->search;
                $search_id = json_decode($search);
                $invoice_reports = Invoice::whereIn('id',$search_id )->get();
               
            }
            else{
                $invoice_reports = Invoice::get();
            }
        }else{
            $country_id = $this->user->country;
            if (isset($this->from_date) && isset($this->to_date)) {
                $invoice_reports = Invoice::whereDate('created_at','>=',$this->from_date)
                                    ->whereDate('created_at','<=',$this->to_date)
                                    ->whereHas('medical_info',function($query) use ($country_id){
                                    $query->whereHas('hospital',function($q) use ($country_id){
                                    $q->where('country',$country_id);
                                    });
                                    })->get();
            }else{
                $invoice_reports = Invoice::whereHas('medical_info',function($query) use ($country_id){
                                    $query->whereHas('hospital',function($q) use ($country_id){
                                    $q->where('country',$country_id);
                                    });
                                    })->get();
            }
        }
        return view('admin.reports.invoice_reports_excel', [
            'invoices' => $invoice_reports,'country' => $country_id
        ]);
    }
}
