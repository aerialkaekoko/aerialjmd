<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Invoice;
use App\MedicalInformation;

class PatientExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
     public function __construct($from_date, $to_date,$country_id,$desk_id,$exchange,$search){	
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->country_id = $country_id;
        $this->desk_id = $desk_id;
        $this->search = $search;
        $this->user = auth()->user();
        $this->exchange = $exchange;

    }
    public function view(): View
    {
        if($this->search != null){
            $search = $this->search;
            $search_id = json_decode($search);
                $patient = MedicalInformation::whereIn('id',$search_id )->get();
        }else{
        if ($this->user->name == 'admin') {
            $country_id = $this->country_id;
            $desk_id = $this->desk_id;
            if (isset($this->from_date) && isset($this->to_date)) {
                $patient = MedicalInformation::whereDate('treatment_date','>=',$this->from_date)->whereDate('treatment_date','<=',$this->to_date)->get();
            }elseif($this->country_id){
                $country = $this->country_id;
                $patient = MedicalInformation::whereHas('hospital',function($query) use ($country){
                    $query->where('country',$country);
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
                $patient = MedicalInformation::whereHas('hospital',function($query) use ($code){
                    $query->where('country_code',$code);
                })->get();
            }else{
                $patient = MedicalInformation::all();
            }
        }else{
            $country_id = $this->user->country;
            $desk_id = $this->user->desk;
            if (isset($this->from_date) && isset($this->to_date)) {
                $patient = MedicalInformation::whereDate('treatment_date','>=',$this->from_date)->whereDate('treatment_date','<=',$this->to_date)->whereHas('hospital',function($query) use ($country_id){
                    $query->where('country',$country_id);
                })->get();
            }elseif($this->country_id){
                $patient = MedicalInformation::whereHas('hospital',function($query) use ($country_id){
                    $query->where('country',$country_id);
                })->get();
            }elseif($this->search){

                $search_id = json_decode($search);
                dd($search_id);
                $patient = MedicalInformation::whereHas('id',function($query) use ($country_id){
                    $query->where('country',$country_id);
                })->get();
            }else{
                $desk = $request->desk_id;
                $patient = MedicalInformation::whereHas('user',function($query) use ($desk){
                    $query->where('desk',$desk);
                })->get();
            }
        }
    }
        return view('admin.reports.patient_reports_excel', [
            'patient' => $patient,'country' => $this->country_id,'desk' => $this->desk_id,'exchange' => $this->exchange
        ]);
    
  }
}
