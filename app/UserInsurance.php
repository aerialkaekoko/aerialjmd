<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class UserInsurance extends Model implements HasMedia
{
    use SoftDeletes,HasMediaTrait;

    public $table = 'user_insurances';  

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    const TYPE = [
        1 => 'OTAI',
        2 => 'Member Ship',
        3 => 'Credit Card',
        4 => 'Others',
    ];
    const OTHER_TYPE = [
        1 => 'Cash',
        2 => 'Corporate',
        3 => 'Local Insurance',
        4 => 'Social Security',
        5 => 'Other',
    ];

    protected $appends = [
        'insurance',
        'template',
    ];

    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',
        'type',
        'user_id',
        'policy_number1',
        'policy_period_from1',
        'policy_period_to1',
        'policy_number2',
        'policy_period_from2',
        'policy_period_to2',
        'member_no',
        'credit_type',
        'other_type',
        'other_type_two',
        'assistance_id1',
        'insurance_id1',
        'assistance_id2',
        'insurance_id2',
        'membership_id',
        'credit_insurance_company',
        'credit_assistance_company',
        'local_insurance_id',
        'corporate_company',
        'cash_comments',
        'other_comments',
        'local_insurance_id_two',
        'corporate_company_two',
        'cash_comments_two',
        'other_comments_two',
    ];
    public function getInsuranceAttribute()
    {
        return $this->getMedia('insurance');
    }
    
    public function getTemplateAttribute()
    {
        return $this->getMedia('template');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assistance()
    {
        return $this->belongsTo(Assistance::class, 'assistance_id1');
    }

    public function insurance_item()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id1');
    }


    public function insurance1()
    {
        return $this->belongsTo('App\Insurance','insurance_id1');
    }
    public function insurance2()
    {
        return $this->belongsTo('App\Insurance','insurance_id2');
    }
    public function insurance3()
    {
        return $this->belongsTo('App\Insurance','credit_insurance_company');
    }
    public function assistance1()
    {
        return $this->belongsTo('App\Assistance','assistance_id1');
    }
    public function assistance2()
    {
        return $this->belongsTo('App\Assistance','assistance_id2');
    }
    public function assistance3()
    {
        return $this->belongsTo('App\Assistance','credit_assistance_company');
    }
    public function membership()
    {
        return $this->belongsTo('App\Membership','membership_id');
    }
    public function local_insurance()
    {
        return $this->belongsTo('App\LocalInsurance','local_insurance_id');
    }
    
}
