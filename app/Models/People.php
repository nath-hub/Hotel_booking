<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class People extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "peoples";


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

   public function user()
   {
      return $this->hasOne(User::class);
   }

   public function bedroom()
   {
      return $this->belongsToMany(Bedroom::class)->withPivot('start_date', 'end_date')->withTimestamps();
   }


   public function companions()
   {
      return $this->hasMany(People::class, "booker_id");
   }


   public function booker()
   {
      return $this->belongsTo(People::class);
   }

}
