<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class UserAlert extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'user_alerts';

    protected $appends = [
        'file',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'alert_text',
        'created_at',
        'updated_at',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getFileAttribute()
    {
        return $this->getMedia('file');
    }
}