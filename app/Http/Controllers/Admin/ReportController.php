<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\InvoiceExport;
use App\Exports\ProfitExport;
use App\Exports\PatientExport;
use App\Exports\YearlyProfitExport;
use App\Exports\SummaryExport;
use App\Exports\SummaryReportExport;
use App\Imports\MedicalInformationImport;
use App\Invoice;
use App\MedicalInformation;
use App\User;
use App\Exchange;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Excel;
use App\InvoiceDescription;
use DB;

class ReportController extends Controller
{
    protected $user;
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user= auth()->user();

            return $next($request);
        });
    }
    public function invoice_reports(Request $request)
    {
        abort_if(Gate::denies('report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($this->user->name == 'admin') {
            if (isset($request->start_date) && isset($request->to_date)) {
                $invoice_reports = Invoice::whereDate('created_at','>=',$request->start_date)->whereDate('created_at','<=',$request->to_date)->get();
            }elseif(isset($request->country_id)){
                $country = $request->country_id;
                $invoice_reports = Invoice::whereHas('medical_info',function($query) use ($country){
                    $query->whereHas('hospital',function($q) use ($country){
                        $q->where('country',$country);
                    });
                })->get();
            }else{
                $invoice_reports = Invoice::get();
            }
        } else {
            $country_id = $this->user->country;
            if (isset($request->start_date) && isset($request->to_date)) {
                $invoice_reports = Invoice::whereDate('created_at','>=',$request->start_date)
                                    ->whereDate('created_at','<=',$request->to_date)
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
        return view('admin.reports.invoice_report', compact('invoice_reports'));
    }
    public function invoice_reports_excel(Request $request)
    {
        //dd($request->search);

        return Excel::download(new InvoiceExport($request->start_date,$request->to_date,$request->country_id,$request->search), 'invoices.xlsx');
    }
    public function patient_reports(Request $request)
    {
        abort_if(Gate::denies('report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($this->user->name == 'admin') {
            if (isset($request->country_id)) {
                $country = $request->country_id;
                $patient_reports = MedicalInformation::whereHas('hospital',function($query) use ($country){
                    $query->where('country',$country);
                })->get();
            }else if(isset($request->desk_id)){
                $desk = $request->desk_id;
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
                $patient_reports = MedicalInformation::whereHas('hospital',function($query) use ($code){
                    $query->where('country_code',$code);
                })->get();
            }elseif (isset($request->start_date) && isset($request->to_date)) {
                $patient_reports = MedicalInformation::whereDate('date_of_visit','>=',$request->start_date)->whereDate('date_of_visit','<=',$request->to_date)->get();
            }else {
                $patient_reports = MedicalInformation::get();
            }
        } else {
            $country_id = $this->user->country;
            if (isset($request->start_date) && isset($request->to_date)) {
                $patient_reports = MedicalInformation::whereDate('date_of_visit','>=',$request->start_date)->whereDate('date_of_visit','<=',$request->to_date)->whereHas('hospital',function($query) use ($country_id){
                    $query->where('country',$country_id);
                })->get();
            }else {
                $patient_reports = MedicalInformation::whereHas('hospital',function($query) use ($country_id){
                    $query->where('country',$country_id);
                })->get();
            }
        }
        $users = User::whereHas('roles' , function($q){
            $q->where('title', 'Member');
        })->pluck('name', 'id')->prepend(trans('All'), '');
        
        $exchange = Exchange::latest()->first()->exchange_mmk;
        
        // $article = News::where('slug', $slug)->firstOrFail();
        // return view('article', compact('article'));
   
        // $user= User::where('active', 1)->get();

        return view('admin.reports.patient_report',compact('patient_reports','users','exchange'));
    }
    public function patient_reports_excel(Request $request)
    {
        // dd($request->search);
        $exchange = Exchange::latest()->first()->exchange_mmk;
        if($request->country_id==0 && $request->desk_id==0 && $request->search==null)
       {
         return redirect()->back()->with('alert', 'Please Choose "Country" or "Desk" !');
       }else{
        return Excel::download(new PatientExport($request->start_date,$request->to_date,$request->country_id,$request->desk_id,$exchange,$request->search), 'patients.xlsx');
        }
    }
    public function change_kb(Request $request,$id)
    {
        // dd($request->all());
        $medical_info = MedicalInformation::find($id);
        $medical_info->kb = $request->kb;
        if ($medical_info->save()) {
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }

    }

    public function profit_reports(Request $request){
        
        abort_if(Gate::denies('report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($this->user->name == 'admin') {
            if (isset($request->start_date) && isset($request->to_date)) {
                $profit_reports = Invoice::whereDate('created_at','>=',$request->start_date)->whereDate('created_at','<=',$request->to_date)->get();
            }elseif(isset($request->country_id)){
                $country = $request->country_id;
                $profit_reports = Invoice::whereHas('medical_info',function($query) use ($country){
                    $query->whereHas('hospital',function($q) use ($country){
                        $q->where('country',$country);
                    });
                })->get();
            }elseif(isset($request->desk_id)){
                $desk = $request->desk_id;
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

                $profit_reports = Invoice::whereHas('medical_info',function($query) use ($code){
                    $query->whereHas('hospital',function($q) use ($code){
                        $q->where('country_code',$code);
                    });
                })->get();
               
            }else{
                $profit_reports = Invoice::get();
            }
        } else {
            $country_id = $this->user->country;
            if (isset($request->start_date) && isset($request->to_date)) {
                $profit_reports = Invoice::whereDate('created_at','>=',$request->start_date)
                                ->whereDate('created_at','<=',$request->to_date)
                                ->whereHas('medical_info',function($query) use ($country_id){
                                    $query->whereHas('hospital',function($q) use ($country_id){
                                        $q->where('country',$country_id);
                                });
                })->get();
            }elseif(isset($request->desk_id)){
                $desk = $request->desk_id;
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

                $profit_reports = Invoice::whereHas('medical_info',function($query) use ($code){
                    $query->whereHas('hospital',function($q) use ($code){
                        $q->where('country_code',$code);
                    });
                })->get();
               
            }else{
                $profit_reports = Invoice::whereHas('medical_info',function($query) use ($country_id){
                    $query->whereHas('hospital',function($q) use ($country_id){
                        $q->where('country',$country_id);
                    });
                })->get();
            }
        }
        // dd($profit_reports);

        return view('admin.reports.profit_report', compact('profit_reports'));
    }

    public function profit_reports_excel(Request $request){
      $exchange_usd = Exchange::latest()->first()->exchange_usd;
      $exchange_thb = Exchange::latest()->first()->exchange_thb;
      $exchange_mmk = Exchange::latest()->first()->exchange_mmk;
      $exchange_lak = Exchange::latest()->first()->exchange_lak;
      if($request->desk_id==0 ){
         return redirect()->back()->with('alert', 'Please Choose "Desk" !');
       }else{
        return Excel::download(new ProfitExport($request->start_date,$request->end_date,$request->country_id,$request->desk_id,$exchange_usd,$exchange_thb,$exchange_mmk,$exchange_lak), 'profits.xlsx');
        }
        
    }

    public function yearly_profit_reports(Request $request){
        abort_if(Gate::denies('report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = [];

        if (isset($request->year)) {
            $year = $request->year;
        }
        else{
            $year = date('Y');
        }
        for ($start_month=1; $start_month <= 12 ; $start_month++) {
            if ($this->user->name == 'admin') {
                if (isset($request->country_id)) {
                    $country = $request->country_id;
                     $data[$start_month] = Invoice::whereHas('medical_info',function($query) use ($country){
                        $query->whereHas('hospital',function($q) use ($country){
                            $q->where('country',$country);
                        });
                     })->whereYear('created_at', '=', $year)
                          ->whereMonth('created_at', '=', $start_month)
                          ->get();
                 }elseif(isset($request->desk_id)){
                        $desk = $request->desk_id;
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
                             })->whereYear('created_at', '=', $year)
                                  ->whereMonth('created_at', '=', $start_month)
                                  ->get();

                 }else{
                    $data[$start_month] = Invoice::with('medical_info')->whereYear('created_at', '=', $year)
                          ->whereMonth('created_at', '=', $start_month)
                          ->get();
                    $desk = null;
                }
            }else{
                $country_id = $this->user->country;
                $data[$start_month] = Invoice::whereHas('medical_info',function($query) use ($country_id){
                        $query->whereHas('hospital',function($q) use ($country_id){
                            $q->where('country',$country_id);
                        });
                     })
                    ->whereYear('created_at', '=', $year)
                          ->whereMonth('created_at', '=', $start_month)
                          ->get();
                    $country = $country_id;
            }
        }

        $exchange_usd = Exchange::latest()->first()->exchange_usd;
        $exchange_thb = Exchange::latest()->first()->exchange_thb;
        $exchange_mmk = Exchange::latest()->first()->exchange_mmk;
        $exchange_lak = Exchange::latest()->first()->exchange_lak;

        return view('admin.reports.yearly_profit_report', compact('data','year','desk','exchange_usd','exchange_thb','exchange_mmk','exchange_lak'));
    }

    public function yearly_profit_reports_excel(Request $request){

        $exchange_usd = Exchange::latest()->first()->exchange_usd;
        $exchange_thb = Exchange::latest()->first()->exchange_thb;
        $exchange_mmk = Exchange::latest()->first()->exchange_mmk;
        $exchange_lak = Exchange::latest()->first()->exchange_lak;

        if (isset($request->year)) {
            $year = $request->year;
        }
        else{
            $year = date('Y');
        }
        if($request->desk_id==0 ){
            return redirect()->back()->with('alert', 'Please Choose "Desk" !');
        }else{
            return Excel::download(new YearlyProfitExport($year,$request->desk_id,$exchange_usd,$exchange_thb,$exchange_mmk,$exchange_lak), 'yearly_profits.xlsx');
        }
        
    }

    public function import(Request $request)
    {
        Excel::import(new MedicalInformationImport,request()->file('file'));
           
        return back();
    }
    public function summary_detail_excel(Request $request){
        $exchange_usd = Exchange::latest()->first()->exchange_usd;
        $exchange_thb = Exchange::latest()->first()->exchange_thb;
        $exchange_mmk = Exchange::latest()->first()->exchange_mmk;
        $exchange_lak = Exchange::latest()->first()->exchange_lak;

       if($request->country_id==0)
       {
         return redirect()->back()->with('alert', 'Please Choose Country !');
       }
       else{     
        return Excel::download(new SummaryExport($request->start_date,$request->to_date,$request->country_id,$exchange_usd,$exchange_thb,$exchange_mmk,$exchange_lak), 'summary_detail.xlsx');
        }
    }
    public function summary_reports_excel(Request $request)
    {
        $invoice_array = explode(',',$request->h_invoice);
        $invoices = Invoice::whereIn('id',$invoice_array)->get();
        return Excel::download(new SummaryReportExport($request->start_date,$request->to_date,$request->country_id,$invoice_array), 'summary.xlsx');        
    }

    public function reportupdate(Request $request, $id)
    {
        $test = Test::find($id);
        $column_name = Input::get('name');
        $column_value = Input::get('value');
        
        if( Input::has('name') && Input::has('value')) {
            $test = Test::select()
                ->where('id', '=', $id)
                ->update([$column_name => $column_value]);
            return response()->json([ 'code'=>200], 200);
        }
        
        return response()->json([ 'error'=> 400, 'message'=> 'Not enought params' ], 400);
    }
}
