<?php

namespace App;
use DateTime;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalInformation extends Model implements HasMedia
{
    use SoftDeletes,HasMediaTrait;
    protected $table = 'personal_informations';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'created_at',
        'updated_at',
        'deleted_at',        
        'user_id',
        'hospital_id',
        'hospital_patient_no',
        'hospital2_id',
        'hospital2_patient_no',
        'hospital3_id',
        'hospital3_patient_no',
        'medicals',        
        'comments',
        'medical_hystory',
    ];
     protected $appends = [
        'gruntee',
        'materials',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
        // return $this->belongsTo('App\User','user_id');
    }
    public function hospital()
    {
        return $this->belongsTo('App\Hospital','hospital_id');
    }
    public function hospital2()
    {
        return $this->belongsTo('App\Hospital','hospital2_id');
    }
    public function hospital3()
    {
        return $this->belongsTo('App\Hospital','hospital3_id');
    }
    public function medical()
    {
        return $this->belongsTo('App\Medical','medical_id');
    }
    public function getMaterialsAttribute(){
        return $this->getMedia('materials');
    }
}
