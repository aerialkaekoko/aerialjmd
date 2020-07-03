<?php

namespace App;
use DateTime;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalInformation extends Model implements HasMedia
{
    use SoftDeletes,HasMediaTrait;
    protected $table = 'medical_informations';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const GCL_STATUS = [
        1 => 'Processing',
        2 => 'Issued',
        3 => 'Pending',
        4 => 'Refused',
    ];
    const CURRENCY = [
        1 => 'USD',
        2 => 'Baht',
        3 => 'MMK',
        4 => 'LAK',
    ];
    const CASH_CREDIT = [
        1 => 'Cashless',
        2 => 'Cash',
        3 => 'Credit Card',
    ];
    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
        'ba_ref_no',
        'appointment_date',
        'date_of_visit',
        'the_first_visit_date',
        'document_date',
        'patient_id',
        'hospital_id',
        'patient_no',     
        'disease_id',
        'department_id',
        'doctor_id',
        'payment_type',
        'cash_credit',
        'insurance_id',
        'assistance_id',
        'membership_id',
        'card_no',
        'doctor_name',
        'currency',
        'medical_amount',
        'medical_amount2',
        'kb',
        'other_fee',        
        'insentive',
        'history_code',
        'finish',
        'agt_ref_no',
        'side_response',
        'translator_name',
        'treatment_info_comments',
        're_exam',
        'symptons',
        'service_time',
        'service_outtime',
        'exchange_thb',
        'exchange_lak',
        'exchange_mmk',
        'patient_type',
        'opd_ipd',
        'ipd_start_date',
        'ipd_finish_date',
        'remark',
        'appointment_status',
        'treatment_status',
        'status_of_gcl',
        'gcl_case_no',
        'period_case',
        'gcl_info_comments',
        'weekday_end',
        'gad_use_comments',
        'branch_code',
    ];
    protected $appends = [
        'gruntee',
        'medicalinfoform',
        'medicalinvoice',
        'gcl',
    ];
    public function user()
    {
        return $this->belongsTo('App\User','patient_id');
    }
    public function insurance()
    {
        return $this->belongsTo('App\Insurance','insurance_id');
    }
    public function assistance()
    {
        return $this->belongsTo('App\Assistance','assistance_id');
    }
     public function membership()
    {
        return $this->belongsTo('App\Membership','membership_id');
    }
    public function hospital()
    {
        return $this->belongsTo('App\Hospital','hospital_id');
    }
    public function medical()
    {
        return $this->belongsTo('App\Medical','disease_id');
    }
    public function doctor()
    {
        return $this->belongsTo('App\Doctor','doctor_id');
    }
    public function department()
    {
        return $this->belongsTo('App\Department','department_id');
    }
    public function medical_group($disease_id,$patient_id)
    {
            $d1 = new DateTime();
            $d1->modify('-6 month');
            $d1 = $d1->format('Y-m-d');
            $d2 = date('Y-m-d');
        return MedicalInformation::whereDate('created_at','>=',$d1)->whereDate('created_at','<=',$d2)->where('disease_id',$disease_id)->where('patient_id',$patient_id)->get();
    }
    public function getMedicalInfoFormAttribute()
    {
        return $this->getMedia('medicalinfoform');
    }
     public function getGrunteeAttribute()
    {
        return $this->getMedia('gruntee');
    }
    public function getMedicalInvoiceAttribute()
    {
        return $this->getMedia('medicalinvoice');
    }
    public function getGclAttribute()
    {
        return $this->getMedia('gcl');
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
