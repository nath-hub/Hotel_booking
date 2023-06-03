<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Pivot
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bedroom_people';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'validated' => 'boolean',

    ];


    public function people()
    {
        return $this->belongsTo(People::class, 'booker_id');
    }

    public function bedroom()
    {
        return $this->belongsTo(Bedroom::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeFilter(Builder $query, array $filters)
    {

        $query->when($filters['start_date'] ?? null, function ($query, $startDate) {

            $query->where('start_date', '>=', $startDate);
        })->when($filters['end_date'] ?? null, function ($query, $endDate) {

            $query->where('end_date', '<=', $endDate);
        })->when($filters['validated'] ?? null, function ($query, $validated) {

            $query->where('validated', $validated);
        })->whereHas('people.user', function ($query) use ($filters) {

            $query->when($filters['hotel_id'] ?? null, function ($query, $hotelId) {
                $query->where('hotel_id',  $hotelId);
            })->when($filters['user_id'] ?? null, function ($query, $userId) {
                $query->where('user_id',  $userId);
            })->when($filters['username'] ?? null, function ($query, $username) {
                $query->where('username', $username);
            })->when($filters['firstname'] ?? null, function ($query, $firstname) {
                $query->where('firstname', 'like', '%' . $firstname . '%');
            })->when($filters['lastname'] ?? null, function ($query, $lastname) {
                $query->where('lastname', 'like', '%' . $lastname . '%');
            });
        })->whereHas('bedroom.showerRoom', function ($query) use ($filters) {

            $query->when($filters['bedroom_id'] ?? null, function ($query, $bedroomId) {
                $query->where('bedroom_id',  $bedroomId);
            })->when($filters['type'] ?? null, function ($query, $type) {
                $query->where('type', $type);
            });
        });
    }
}
