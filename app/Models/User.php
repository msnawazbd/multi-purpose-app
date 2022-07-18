<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    const ROLE_ADMIN = 'admin';
    const ROLE_CLIENT = 'client';
    const ROLE_USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'alternate_no',
        'address',
        'gender',
        'country_id',
        'state',
        'city',
        'zip_code',
        'password',
        'role',
        'avatar',
        'activation_status',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'avatar_url'
    ];

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && Storage::disk('avatars')->exists($this->avatar)) {
            return Storage::disk('avatars')->url($this->avatar);
        }

        // return asset('noimage.png');
        return 'https://ui-avatars.com/api/?name=' . $this->name;
    }

    public function isAdmin()
    {
        if ($this->role !== self::ROLE_ADMIN) {
            return false;
        }
        return true;
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function tasks()
    {
        return $this->belongsToMany(User::class, 'task_user',  'user_id', 'task_id');
    }
}
