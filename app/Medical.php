<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use App\Hospital;
use App\Doctor;
use App\User;

class Medical extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'medicals';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'disease_name',
        'created_at',
        'updated_at',
        'deleted_at',        
    ];


}
