<?php

namespace App\Models;

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
}
