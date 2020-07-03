<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Hospital extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'hospitals';

    protected $appends = [
        'hospitals_images',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'country',
        'country_code',
        'address',
        'description',
        'contact',
        'created_at',
        'updated_at',
        'deleted_at',        
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function getHospitalsImagesAttribute()
    {
        $files = $this->getMedia('hospitals_images');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
        });

        return $files;
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }

    public function medicals()
    {
        return $this->hasMany('App\Medical');
    }
}
