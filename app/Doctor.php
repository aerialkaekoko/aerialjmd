<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Doctor extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'doctors';

    protected $appends = [
        'doctors_images',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'hospital_id',
        'specialist',
        'qualification',
        'schedule',
        'country',
        'address',
        'contact',
        'created_at',
        'updated_at',
        'deleted_at',        
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function getDoctorsImagesAttribute()
    {
        $files = $this->getMedia('doctors_images');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
        });

        return $files;
    }

    public function hospitals()
    {
        return $this->belongsToMany(Hospital::class);
    }

    public function medicals()
    {
        return $this->hasMany('App\Medical');
    }
    
}
