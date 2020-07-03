<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Gate;
use DOMPDF;
use Symfony\Component\HttpFoundation\Response;
use App\Invoice;
use App\MedicalExpense;
use App\User;
use App\Hospital;
use App\Medical;
use App\MedicalInformation;
use App\Assistance;
use App\InvoiceDescription;
use App\Exchange;
use App\Membership;
use DB;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createlist(Request $request)
    {
        $data = MedicalInformation::orderBy('id','desc')->get();
        $patients = User::whereHas('roles', function ($q) {$q->whereIn('roles.title', ['member']);})->get();
        return view('admin.invoices.createlist',compact('data','patients'));
    }
    public function createForm1(Request $request)
    {
        $medical_information_id = json_decode($request->invoices);
        $medical_information = MedicalInformation::find($medical_information_id[0]);
        $service_count = $medical_information->services->count();
        $exchange = Exchange::latest()->first();
        $to_data = Assistance::all()->pluck('to_name', 'id');
        $descriptions = InvoiceDescription::all()->pluck('description', 'id')->prepend(trans('global.pleaseSelect'), '');
        $jmd = "JMD";
        $branch = $medical_information->hospital->country_code;
        // $invCount = Invoice::count();
        $invCount = Invoice::where('branch_code',$branch)->count()+1;
        if ($invCount == 1) {
            $order_no = 1;
        }else{
            $order_no = Invoice::where('branch_code',$branch)
                      ->groupBy('invoice_code')
                      ->get()
                      ->count()+1;
        }
        
        $order_no = str_pad($order_no, 5, '0', STR_PAD_LEFT);

        // $assistance  = ($medical_information->assistance) ? $medical_information->assistance->short_code : 'NON' ;
        if ($medical_information->assistance) {
            $assistance = $medical_information->assistance->short_code;
        }elseif($medical_information->membership) {
            $assistance = $medical_information->membership->membership_short_code;
        }else{
            $assistance = "NON";
        }        
        $date = date('Y').'/';
        $invoice_code = $jmd.''.$branch.''.$assistance.''.$date.''.$order_no;
        return view('admin.invoices.create1',compact('medical_information','service_count','to_data','descriptions','invoice_code','exchange'));
    }
    public function createForm2(Request $request)
    {
      
        $medical_information_id = json_decode($request->invoices);
        $exchange = Exchange::latest()->first();
        $medical_information_item = MedicalInformation::whereIn('id', $medical_information_id )->get();
        $medical_information = MedicalInformation::find($medical_information_id[0]);
        $service_count = $medical_information->services->count();
        $to_data = Assistance::all()->pluck('to_name', 'id');
        $descriptions = InvoiceDescription::all()->pluck('description', 'id')->prepend(trans('global.pleaseSelect'), '');

        $jmd = "JMD";
        $branch = $medical_information->hospital->country_code;
        // $invCount = Invoice::count();
        $invCount = Invoice::where('branch_code',$branch)->count()+1;
        if ($invCount == 1) {
            $order_no = 1;
        }else{
            $order_no = Invoice::where('branch_code',$branch)
                      ->groupBy('invoice_code')
                      ->get()
                      ->count()+1;
        }
        
        $order_no = str_pad($order_no, 5, '0', STR_PAD_LEFT);
        // $assistance  = ($medical_information->assistance) ? $medical_information->assistance->short_code : 'N' ;
         if ($medical_information->assistance) {
            $assistance = $medical_information->assistance->short_code;
        }elseif($medical_information->membership) {
            $assistance = $medical_information->membership->membership_short_code;
        }else{
            $assistance = "NON";
        }
        $date = date('Y').'/';
        $invoice_code = $jmd.''.$branch.''.$assistance.''.$date.''.$order_no;
         return view('admin.invoices.create2',compact('medical_information','service_count','to_data','descriptions','invoice_code','medical_information_item','exchange'));
       
    }
    public function autocomplete(Request $request){
        $medical_informations = MedicalInformation::with('user')->where('ba_ref_no', 'LIKE', "%{$request->ba_ref_no}%")->get()->toArray();
        return $medical_informations;
    }
    public function deleteItem($id)
    {
        $item = Invoice::find($id);
        if (isset($item)) {
            $item->delete();
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }
   
    
    public function index(Request $request)
    {
        abort_if(Gate::denies('invoice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(auth()->user()->name == 'admin'){
            if (isset($request->start_date) && isset($request->to_date)) {
                $invoices = Invoice::whereDate('created_at','>=',$request->start_date)->whereDate('created_at','<=',$request->to_date)->get();
            }elseif(isset($request->country_id)){
                $country = $request->country_id;
                $invoices = Invoice::whereHas('medical_info',function($query) use ($country){
                    $query->whereHas('hospital',function($q) use ($country){
                        $q->where('country',$country);
                    });
                })->get();
            }else{
                $invoices = Invoice::get();
            }
        }else{
          $country_id = auth()->user()->country;
          if (isset($request->start_date) && isset($request->to_date)) {
              $invoices = Invoice::whereDate('created_at','>=',$request->start_date)
                        ->whereDate('created_at','<=',$request->to_date)
                        ->whereHas('medical_info',function($query) use ($country_id){
                            $query->whereHas('hospital',function($q) use ($country_id){
                                $q->where('country',$country_id);
                            });
                        })->get();
          }else{
              $invoices = Invoice::whereHas('medical_info',function($query) use ($country_id){
                        $query->whereHas('hospital',function($q) use ($country_id){
                            $q->where('country',$country_id)->get();
                        });
                    });
          }
        }
        
        return view('admin.invoices.index', compact('invoices'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_if(Gate::denies('invoice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::whereHas('roles' , function($q){
            $q->where('title', 'Member');
        })->select(DB::raw('CONCAT(name, " ", family_name) AS full_name'), 'id')->pluck('full_name','id')->prepend(trans('global.pleaseSelect'), '');
        $invCount = Invoice::count();
        if ($invCount == 0) {
            $refID = 1;
        }else{
            $refID = Invoice::get()->last()->id +1;
        }
        if (isset($request->create)) {
            $create = 1;
            $medical_info = MedicalInformation::find($request->medical_info_id);
            $user_id = $request->member_id;
        }else{
            $create =2;
            $medical_info = null;
            $user_id = null;
        }
        $refID = str_pad($refID, 5, '0', STR_PAD_LEFT);
        return view('admin.invoices.create',compact('users','refID','create','medical_info','user_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        $invoice = new Invoice;
        $invoice->invoice_code = $request->invoice_code;
        $invoice->reference_no = $request->reference_no;
        $invoice->user_id = $request->user_id;
        $invoice->ba_svf = $request->ba_svf;
        $invoice->case_fee = $request->case_fee;
        $invoice->medical_information_id = $request->medical_information_id;
        $invoice->due_date = $request->due_date;
        if ($invoice->save()) {
          $medical_info = MedicalInformation::find($request->medical_information_id);
          $medical_info->status = 1;
          $medical_info->save();
        }
        return response()->json(['success'=>true,'data'=>$invoice]);
    }
    public function storeForm1(Request $request)
    {
       //dd($request->all());
        $invoice = new Invoice;
        $invoice->invoice_code = $request->invoice_code;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->medical_information_id = $request->medical_information_id;
        $invoice->user_id = $request->user_id;
        $invoice->branch_code = $request->branch_code;
        $invoice->to_assistance_id = $request->to;
        $invoice->change_currency=$request->totalcurrency;
        $invoice->form_status = 1;
        $invoice->save();
        
        foreach ($request->data as $key => $value) {
            if (isset($value['description'])) {
                $description['invoice_id'] = $invoice->id;
                $description['invoice_description_id'] = $value['description'];
                $description['qty'] = $value['qty'];
                $description['unit_price'] = $value['unit_price'];
                $description['currency1'] = $value['currency1'];
                $description['amount'] = $value['amount'];
                $description['vatable_status'] = $value['vatable'] ;
                DB::table('descriptions')->insert($description);
            }
        } 
        $amount['invoice_code'] = $request->invoice_code;
        $amount['subtotal_amount'] = $request->Sub_Total_Amount;
        $amount['vatable_amount'] = $request->Vatable;
        $amount['vatable_percent'] = $request->vat_percent;
        $amount['calculate_vatable_amount'] = $request->vat_amount;
        $amount['non_vatable'] = $request->nonvatable;
        $amount['total_amount'] = $request->Grand_Total;
        DB::table('amounts')->insert($amount);
        return redirect()->route('admin.invoices.index');
    }
    public function storeForm2(Request $request)
    {
         //dd($request->all());
        foreach ($request->data as $key => $value) {
            $invoice = new Invoice;
            $invoice->invoice_code = $request->invoice_code;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->medical_information_id = $value['medical_information_id'];
            $invoice->user_id = $value['user_id'];
            $invoice->branch_code = $value['branch_code'];
            $invoice->interpreter_fee = $value['interpreter_fee'];
            $invoice->qty = $value['qty'];
            $invoice->currency_interpreter = $value['currency2'];
            $invoice->to_assistance_id = $request->to;
            $invoice->form_status = 2;
            $invoice->change_currency=$request->totalcurrency;
            $invoice->save();
        }
        $amount['invoice_code'] = $request->invoice_code;
        $amount['subtotal_amount'] = $request->Sub_Total_Amount;
        $amount['vatable_amount'] = $request->Vatable;
        $amount['vatable_percent'] = $request->vat_percent;
        $amount['calculate_vatable_amount'] = $request->vat_amount;
        $amount['non_vatable'] = $request->nonvatable;
        $amount['total_amount'] = $request->Grand_Total;
        DB::table('amounts')->insert($amount);
        return redirect()->route('admin.invoices.index');
    }


  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show1($id)
    {
        abort_if(Gate::denies('invoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $invoice = Invoice::find($id);
        $amount = $invoice->amount($invoice->invoice_code);
        return view('admin.invoices.show1',compact('invoice','amount'));
    }
    public function show2($id)
    {
        abort_if(Gate::denies('invoice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
         $invoice = Invoice::find($id);
        $invoice_code=$invoice->invoice_code;
        $invoice_date=$invoice->invoice_date;
        $changecurrency=$invoice->change_currency;
        $invoiceassistance_id=$invoice->to_assistance_id;
        $editinvoice = Invoice::where('invoice_code', $invoice_code)->get();
        $exchange = Exchange::first();
        $to_data = Assistance::all()->pluck('to_name', 'id');
        $descriptions = InvoiceDescription::all()->pluck('description', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        $item_descriptions = $invoice->description($id);
        $amount = $invoice->amount($invoice->invoice_code);
        return view('admin.invoices.show2',compact('editinvoice','invoice','to_data','invoiceassistance_id','descriptions','item_descriptions','amount','exchange','invoice_code','invoice_date','changecurrency'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function edit(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // dd($invoice);
        $users = User::whereHas('roles' , function($q){
            $q->where('title', 'Member');
        })->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $medical_expenses = $invoice->medical_expenses;
        $hospitals = Hospital::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $medicals = Medical::all()->pluck('disease_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.invoices.edit',compact('users','invoice','medical_expenses','hospitals','medicals'));
    }
    public function editForm1($id)
    { 
        
        $invoice = Invoice::find($id);
        $invoice_code=$invoice->invoice_code;
        $exchange = Exchange::latest()->first();
        $to_data = Assistance::all()->pluck('to_name', 'id');
        $medical_information = MedicalInformation::find($invoice->medical_information_id);

        
        $descriptions = InvoiceDescription::all()->pluck('description', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        $item_descriptions =  DB::table('descriptions')->where('invoice_id',$id)->get();;

       
        $amount = $invoice->amount($invoice->invoice_code);

        $trow=5;
        $itemrow=count($item_descriptions);
         
        $rqrow=$trow-$itemrow;
        //dd($itemrow);

        return view('admin.invoices.edit1',compact('invoice','to_data','descriptions','item_descriptions','amount','exchange','invoice_code','rqrow','itemrow','medical_information'));
    }
    public function editForm2($id)
    {
       
        $invoice = Invoice::find($id);
        $invoice_code=$invoice->invoice_code;
        $invoice_date=$invoice->invoice_date;
        $changecurrency=$invoice->change_currency;
        $invoiceassistance_id=$invoice->to_assistance_id;
        $editinvoice = Invoice::where('invoice_code', $invoice_code)->get();
        $exchange = Exchange::latest()->first();
        $to_data = Assistance::all()->pluck('to_name', 'id');
        $descriptions = InvoiceDescription::all()->pluck('description', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        $item_descriptions = $invoice->description($id);
        $amount = $invoice->amount($invoice->invoice_code);
        return view('admin.invoices.edit2',compact('editinvoice','invoice','to_data','invoiceassistance_id','descriptions','item_descriptions','amount','exchange','invoice_code','invoice_date','changecurrency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateForm1(Request $request,$id)
    {
         //dd($request->all());
        $invoice = Invoice::find($id);
        $invoice->to_assistance_id = $request->to;
        $invoice->send_date = $request->send_date;
        $invoice->paid_date = $request->paid_date;
        $invoice->change_currency=$request->totalcurrency;
        $invoice->form_status = 1;
        $invoice->save();

        foreach ($request->data as $key => $value) {

            if (isset($value['description'])) {
                 if(isset($value['id_description'])){
                     
                   
                $description['invoice_id'] = $invoice->id;
                $description['invoice_description_id'] = $value['description'];
                $description['qty'] = $value['qty'];
                $description['unit_price'] = $value['unit_price'];
                $description['currency1'] = $value['currency1'];
                $description['amount'] = $value['amount'];
                $description['vatable_status'] = $value['vatable'];
                DB::table('descriptions')->where('id', $value['id_description'])->update($description);
                
                 }else{

                    $description['invoice_id'] = $invoice->id;
                    $description['invoice_description_id'] = $value['description'];
                    $description['qty'] = $value['qty'];
                    $description['unit_price'] = $value['unit_price'];
                    $description['currency1'] = $value['currency1'];
                    $description['amount'] = $value['amount'];
                    $description['vatable_status'] = (isset($value['vatable'])) ? $value['vatable'] : 0 ;
                    DB::table('descriptions')->insert($description);
                 }  
            }
        } 
        $invoice_code = $request->invoice_code;

        $amount['subtotal_amount'] = $request->Sub_Total_Amount;
        $amount['vatable_amount'] = $request->Vatable;
        $amount['vatable_percent'] = $request->vat_percent;
        $amount['calculate_vatable_amount'] = $request->vat_amount;
        $amount['non_vatable'] = $request->nonvatable;
        $amount['total_amount'] = $request->Grand_Total;
        DB::table('amounts')->where('invoice_code', $invoice_code)->update($amount);

        return redirect()->route('admin.invoices.index');
    }

     public function updateForm2(Request $request,$id)
    {
       //dd($request->all());
        foreach ($request->data as $key => $value) {
       
        if($value['invoice_id'] != null){
        $invoice = Invoice::find($value['invoice_id']);
        $invoice->invoice_code = $request->invoice_code;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->send_date = $request->send_date;
        $invoice->paid_date = $request->paid_date;
        $invoice->medical_information_id = $value['medical_information_id'];
        $invoice->user_id = $value['user_id'];
        $invoice->interpreter_fee = $value['interpreter_fee'];
        $invoice->qty = $value['qty'];
        $invoice->currency_interpreter = $value['currency2'];
        $invoice->to_assistance_id = $request->to;
        $invoice->form_status = 2;
        $invoice->change_currency=$request->totalcurrency;
        $invoice->save();
        }else{
            $invoice = new Invoice;
            $invoice->invoice_code = $request->invoice_code;
            $invoice->invoice_date = $request->invoice_date;
            $invoice->send_date = $request->send_date;
            $invoice->paid_date = $request->paid_date;
            $invoice->medical_information_id = $value['medical_information_id'];
            $invoice->user_id = $value['user_id'];
            $invoice->interpreter_fee = $value['interpreter_fee'];
            $invoice->qty = $value['qty'];
            $invoice->currency_interpreter = $value['currency1'];
            $invoice->to_assistance_id = $request->to;
            $invoice->form_status = 2;
            $invoice->change_currency=$request->totalcurrency;
            $invoice->save();
        }
      

        }
        $invoice_code = $request->invoice_code;
        $amount['subtotal_amount'] = $request->Sub_Total_Amount;
        $amount['vatable_amount'] = $request->Vatable;
        $amount['vatable_percent'] = $request->vat_percent;
        $amount['calculate_vatable_amount'] = $request->vat_amount;
        $amount['non_vatable'] = $request->nonvatable;
        $amount['total_amount'] = $request->Grand_Total;
        DB::table('amounts')->where('invoice_code', $invoice_code)->update($amount);

        return redirect()->route('admin.invoices.index');
    }

     public function deleteform2(Request $request,$id){
      
         $invoice = Invoice::find($id);
         $invoice_code=$invoice->invoice_code;
         $deleteinvoice = Invoice::where('invoice_code', $invoice_code)->get();
         
          foreach($deleteinvoice as $key => $value ){
            
              $invoice = Invoice::find($value->id);
            $invoice->delete();

          }
         
        DB::table('amounts')->where('invoice_code', $invoice_code)->delete(); 
        return redirect()->route('admin.invoices.index');
     }
     public function deleteform1(Request $request,$id){
         
      
         $invoice = Invoice::find($id);
         $invoice_code=$invoice->invoice_code;

         $deletedescription =  DB::table('descriptions')->where('invoice_id', $id)->get();
         
         
          foreach($deletedescription as $key => $value ){
             DB::table('descriptions')->where('id', $value->id)->delete(); 

          }
         $invoice->delete();
        DB::table('amounts')->where('invoice_code', $invoice_code)->delete(); 
        return redirect()->route('admin.invoices.index');
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        abort_if(Gate::denies('invoice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $invoice->medical_expenses()->delete();
        $invoice->delete();
        return back();
    }
    public function get_user_insurance($user_id)
    {
        $user_insurances = User::find($user_id)->insurances()->get();
        return response()->json(['success'=>true,'data'=>$user_insurances]);
    }
    public function get_medical_info($user_id)
    {
        $medical_info = User::find($user_id)->medical_info()->with('hospital','medical','insurance')->get();

        return response()->json(['success'=>true,'data'=>$medical_info]);
    }
    public function delete_expense($id)
    {
        $medical_expense = MedicalExpense::find($id);
        if ($medical_expense->delete()) {
            return response()->json(['success'=>true]);
        }
    }
    public function downloadpdf($id)
    {
        abort_if(Gate::denies('invoice_download'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $invoice = Invoice::find($id);
        $descriptions = DB::table('descriptions')
                        ->join('invoice_descriptions', 'invoice_descriptions.id', '=', 'descriptions.invoice_description_id')
                        ->where('invoice_id',$invoice->id)->get();
        $amounts = DB::table('amounts')->where('invoice_code',$invoice->invoice_code)->first();

        $invoice_code = Invoice::where('invoice_code',$invoice->invoice_code)->get();
        // dd($amounts->subtotal_amount);
        // \Log::info($descriptions);exit();
        $exchange_mmk = Exchange::first()->exchange_mmk;
        $exchange_usd = Exchange::first()->exchange_usd;
        $exchange_thb = Exchange::first()->exchange_thb;
        $usd_thb = substr($exchange_usd * $exchange_thb,0,7);
        $mmk_thb = substr(($exchange_usd / $exchange_mmk) * $exchange_thb,0,7);
        if($invoice->form_status == 1)
        {          
          $pdf = DOMPDF::loadView('pdf.invoice', ['invoice'=>$invoice,'descriptions'=>$descriptions,'amounts'=>$amounts,'usd_thb'=>$usd_thb,'mmk_thb'=>$mmk_thb,'exchange_thb'=>$exchange_thb]);
        }else{
          $pdf = DOMPDF::loadView('pdf.invoice_form', ['invoice'=>$invoice,'invoice_code'=>$invoice_code,'amounts'=>$amounts,'usd_thb'=>$usd_thb,'mmk_thb'=>$mmk_thb,'exchange_thb'=>$exchange_thb]);
        }
        return $pdf->stream('invoice.pdf');
    }
    public function summary_preview(Request $request)
    {
        $invoice_array = explode(',',$request->h_invoice);
        $invoices = Invoice::whereIn('id',$invoice_array)->get();
        return view('admin.summary.summary',compact('invoices'));
    }
    public function summary_download(Request $request)
    {
    //    dd($request->input('action'));
        if ($request->input('action') == 'summary') {
            $invoices = Invoice::whereIn('id',$request->invoice_id)->get();
            $summary_data = [];
            $medical_amount_total = 0;
            $other_charges_total = 0;
            $vatable_amount = 0;
            foreach ($invoices as $key => $value) {
               $medical_amount_total += $value->medical_info->medical_amount;
               $other_charges_total += $value->ba_svf;
               $vatable_amount += $value->ba_svf*(5/100);
            }
            $summary_data['medical_amount_total'] = $medical_amount_total;
            $summary_data['other_charges_total'] = $other_charges_total;
            $summary_data['vatable_amount'] = $vatable_amount;
            $pdf = DOMPDF::loadView('pdf.invoice_summary', ['summary_data'=>$summary_data]);
            return $pdf->stream('invoice_summary.pdf');
        }else{
            $invoices = Invoice::whereIn('id',$request->invoice_id)->get();
            $pdf = DOMPDF::loadView('pdf.invoice_detail', ['invoices'=>$invoices]);
            return $pdf->stream('invoice_detail.pdf');
        }
    }
    //For multi rows update
    public function multi_update(Request $request){
        // \Log::info("HI");
        $invoice_array = explode(',',$request->m_invoice);
        // \Log::info($invoice_array);
        foreach ($invoice_array as $key => $value) {
            $invoice = Invoice::find($value);
            $invoice->trf_paid = $request->input('trf_paid');
            $invoice->send_date = $request->send_date;
            $invoice->save();
        }
    return redirect()->route('admin.invoices.index');
    }
}
