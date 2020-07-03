<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Insurance extends Model implements HasMedia
{
    use SoftDeletes,HasMediaTrait;

    public $table = 'insurances';

     protected $appends = [
        'template_pdf',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'phone',
        'address',
        'created_at',
        'updated_at',
        'deleted_at',
        'company_name',
        'template',
    ];
    public function assistances()
    {
        return $this->hasMany(Assistance::class, 'insurance_id', 'id');
    }
    
    public function userInsurances()
    {
        return $this->hasMany(UserInsurance::class, 'insurance_id', 'id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class,'user_insurances');
    }
    
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function claimstemplateClaims()
    {
        return $this->hasMany(Claim::class, 'claimstemplate_id', 'id');
    }

    public function getTemplatePdfAttribute()
    {
        return $this->getMedia('template_pdf')->last();
    }
}