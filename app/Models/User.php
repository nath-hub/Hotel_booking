<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;


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
        'created_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function people()
    {
        return $this->belongsTo(People::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */


    public function scopeFilter(Builder $query, array $filters)
    {

        $query->when($filters['username'] ?? null, function ($query, $username) {

            $query->where('username', 'like', '%' . $username . '%');
        })->when($filters['email'] ?? null, function ($query, $email) {

            $query->where('email', 'like', '%' . $email . '%');
        })->whereHas('people', function ($query) use ($filters) {

            $query->when($filters['hotel_id'] ?? null, function ($query, $hotelId) {
                $query->where('hotel_id',  $hotelId);
            })->when($filters['type'] ?? null, function ($query, $type) {
                $query->where('type', $type);
            })->when($filters['firstname'] ?? null, function ($query, $firstname) {
                $query->where('firstname', 'like', '%' . $firstname . '%');
            })->when($filters['lastname'] ?? null, function ($query, $lastname) {
                $query->where('lastname', 'like', '%' . $lastname . '%');
            });
        });
    }
}
