<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, HasLocalePreference
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'notification_options' => 'json',
    ];

    protected $appends = [
        'photo_url', // getPhotoUrlAttribute
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'user_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'user_id', 'id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id')
            ->withDefault();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function routeNotificationForMail($notification = null)
    {
        return $this->email;
    }

    public function routeNotificationForNexmo($notification = null)
    {
        return $this->mobile;
    }

    public function preferredLocale()
    {
        return $this->langauge;
    }

    //$user->photo_url
    public function getPhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }

        return 'https://ui-avatars.com/api/?name=' . $this->name;
    }

    public function hasAbility($ability)
    {
        foreach ($this->roles as $role) {
            if (in_array($ability, $role->abilities)) {
                return true;
            }
        }
        return false;
    }
}
