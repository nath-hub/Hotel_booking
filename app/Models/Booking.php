<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

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
}
