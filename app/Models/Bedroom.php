<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Bedroom extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];


    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function showerRoom()
    {
        return $this->hasOne(ShowerRoom::class);
    }

    public function peoples()
    {
        return $this->belongsToMany(People::class, 'bedroom_people', 'bedroom_id', 'booker_id')
            ->using(Booking::class)
            ->withPivot('id', 'start_date', 'end_date', 'validated')
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeFilter(Builder $query, array $filterCriteria)
    {
        $query->when($filterCriteria['code'] ?? null, function ($query, $code) {
            $query->where('code', 'like', '%' . $code . '%');
        })->when($filterCriteria['bed_number'] ?? null, function ($query, $bed_number) {
            $query->where('bed_number', $bed_number);
        })->when($filterCriteria['price'] ?? null, function ($query, $price) {
            $query->where('price', '<=', $price);
        })->whereHas('showerRoom', function ($query) use ($filterCriteria) {
            $query->when($filterCriteria['type'] ?? null, function ($query, $type) {
                $query->where('type', $type);
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function isAvailability(string $startDate, string $endDate, ?string $bookingId): bool
    {
        $bookingNumber = DB::table('bedroom_people')
            ->when($bookingId, function ($query, $bookingId) {
                $query->where('id', '<>', $bookingId);
            })
            ->where('bedroom_id', $this->id)
            ->where('validated', 1)
            ->where(function (Builder $query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function (Builder $query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })->count();

        return $bookingNumber > 0 ? false : true;
    }
}
