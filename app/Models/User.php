<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['image_path'];

    /**
     * function to get frist_name
     *
     *
     * // must refactor attribute
     * @return string
     */
    public function getFirstName(): string
    {
        return (string) ucwords($this->first_name);
    }

    /**
     * function to get last_name
     *
     * @return string
     */
    public function getLastName(): string
    {
        return (string) ucwords($this->last_name);
    }

    /**
     * function to get fullName
     *
     * @return string
     */
    public function getFullName(): string
    {
        return (string) $this->getFirstName() . " " . $this->getLastName();
    }

    public function getImagePathAttribute()
    {
        return asset('uploads/users_image/'. $this->image);
    }
}
