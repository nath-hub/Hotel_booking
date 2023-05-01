<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->belongsToMany(People::class)->withPivot('start_date', 'end_date')->withTimestamps();
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
        })->whereHas('showerRoom', function ($query) use ($filterCriteria){
            $query->when($filterCriteria['type'] ?? null, function($query, $type){
                $query->where('type', $type);
            });
        });
    }
}
