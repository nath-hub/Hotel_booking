<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;



    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

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

    public function people()
    {
        return $this->belongsTo(People::class);
    }

    /**
     * Determines if the user is a director
     * 
     * @return string 
     */
    public function getIsDirectorAttribute()
    {
        return $this->people->type === 'DIRECTOR';
    }

        /**
     * Determines if the user is a receptionist
     * 
     * @return string 
     */
    public function getIsReceptionistAttribute()
    {
        return $this->people->type === 'RECEPTIONIST';
    }

        /**
     * Determines if the user is a booker
     * 
     * @return string 
     */
    public function getIsBookerAttribute()
    {
        return $this->people->type !== "CHILD" && $this->people->booker_id === null;
    }

}
