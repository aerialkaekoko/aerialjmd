<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class InvoiceDescription extends Model
{
    use SoftDeletes;

    public $table = 'invoice_descriptions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'updated_at',
        'created_at',
        'deleted_at',
        'description',
    ];
}
