<?php

namespace App;

use App\Notifications\VerifyUserNotification;
use Carbon\Carbon;
use Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use SoftDeletes, Notifiable, HasApiTokens, HasMediaTrait;

    public $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const GENDER_SELECT = [
        'male' => 'male',
        'female' => 'female',
        'custom' => 'custom',
    ];

    protected $appends = [
        'insurance',
        'passport_info',
        'gruntee',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'verified_at',
        'email_verified_at',
    ];

    protected $fillable = [
        'desk',
        'name',
        'email',
        'family_name',
        'gender',
        'passport',
        'address',
        'address_current',
        'disease',
        'surgery',
        'medicine',
        'avatar',
        'country',
        'phone',
        'jpn_phone',
        'dob',
        'age',
        'company',
        'emp_phone_no',
        'emp_address',
        'ref_no',
        'member_no',
        'approved',
        'verified',
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
        'verified_at',
        'remember_token',
        'email_verified_at',
        'verification_token',
    ];

     public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            if (auth()->check()) {
                $user->verified = 1;
                $user->verified_at = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
                $user->save();
            } elseif (!$user->verification_token) {
                $token = Str::random(64);
                $usedToken = User::where('verification_token', $token)->first();

                while ($usedToken) {
                    $token = Str::random(64);
                    $usedToken = User::where('verification_token', $token)->first();
                }

                $user->verification_token = $token;
                $user->save();

                $registrationRole = config('panel.registration_default_role');

                if (!$user->roles()->get()->contains($registrationRole)) {
                    $user->roles()->attach($registrationRole);
                }

                $user->notify(new VerifyUserNotification($user));
            }
        });
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setVerifiedAtAttribute($value)
    {
        $this->attributes['verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function getNewsImagesAttribute()
    {
        $files = $this->getMedia('passport_info');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
        });

        return $files;
    }

    public function getPassportInfoAttribute()
    {
        return $this->getMedia('passport_info');
    }

    public function getInsuranceAttribute()
    {
        return $this->getMedia('insurance');
    }
     public function getGrunteeAttribute()
    {
        return $this->getMedia('gruntee');
    }

    public function userAlerts()
    {
        return $this->belongsToMany(UserAlert::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function insurances()
    {
        return $this->belongsToMany(Insurance::class,'user_insurances','user_id','insurance_id')->whereNull('user_insurances.deleted_at');
    }
    public function userInsurance()
    {
        return $this->hasOne('App\UserInsurance');
    }

    public function personalInformation()
    {
        return $this->hasOne('App\PersonalInformation');
    }

     public function medicals()
    {
        return $this->belongsToMany(medical::class, 'medicals');
    }
    public function medical_info()
    {
        return $this->hasMany(MedicalInformation::class,'patient_id');
    }    

    public function personal_info(){
        return $this->hasMany(PersonalInformation::class);
    }    
    public function user_insurances(){
        return $this->hasMany(UserInsurance::class);
    }
    // public function user_insurances(){
    //     return $this->belongsTo(UserInsurance::class);
    // }
}
