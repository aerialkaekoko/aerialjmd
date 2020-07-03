<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $fillable = ['invoice_code','branch_code'];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function medical_expenses()
    {
        return $this->hasMany('App\MedicalExpense','invoice_id');
    }
    public function medical_info()
    {
        return $this->belongsTo('App\MedicalInformation','medical_information_id');
    }
    public function hospital()
    {
        return $this->belongsTo('App\Hospital','hospital_id');
    }
    public function assistance_to()
    {
        return $this->belongsTo('App\Assistance','to_assistance_id');
    }
    public function amount($invoice_code)
    {
        $amount = DB::table('amounts')->where('invoice_code',$invoice_code)->first();
        return $amount;
    }
    public function description($invoice_id)
    {
        $description = DB::table('descriptions')
                        ->join('invoice_descriptions', 'invoice_descriptions.id', '=', 'descriptions.invoice_description_id')
                        ->where('invoice_id',$invoice_id)->get();
        return $description;
    }
}
