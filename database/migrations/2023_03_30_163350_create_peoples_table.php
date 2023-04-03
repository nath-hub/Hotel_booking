<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peoples', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booker_id');
            $table->unsignedBigInteger('hotel_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->enum('type', ['DIRECTOR', 'EMPLOYEE', 'CHILD', 'ADULT']);

            $table->index(["booker_id"], "fk_booker_people");
            $table->index(["hotel_id"], "fk_people_hotel");

            $table->foreign('booker_id')->references('id')->on('peoples');
            $table->foreign('hotel_id')->references('id')->on('hotels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peoples');
    }
};
