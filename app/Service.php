<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    public $table = 'services';    

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'medical_information_id',
        'intime',
        'outtime',
        'created_at',
        'updated_at',
        'deleted_at',        
    ];
}


