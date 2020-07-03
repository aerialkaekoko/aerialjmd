<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assistance extends Model
{
    use SoftDeletes;

    public $table = 'assistances';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'email',
        'phone',
        'address',
        'insurance_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'assistance_name',
        'short_code',
        'to_name',
    ];
    
    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }

    public function userInsurances()
    {
        return $this->hasMany(UserInsurance::class, 'assistance_id', 'id');
    }
}