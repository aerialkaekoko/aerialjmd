<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Expense extends Model
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'expenses';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'staff_one',
        'staff_two',
        'staff_three',
        'other_expense',
        'created_at',
        'updated_at',
        'deleted_at',
        ,
    ];
}
