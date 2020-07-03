<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Exchange extends Model
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'exchanges';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
        'exchange_usd',
        'exchange_thb',
        'exchange_lak',
        'exchange_mmk',
    ];
}
