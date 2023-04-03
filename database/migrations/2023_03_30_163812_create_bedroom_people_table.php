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
        Schema::create('bedroom_people', function (Blueprint $table) {
            $table->unsignedBigInteger('booker_id');
            $table->unsignedBigInteger('bedroom_id');
            $table->date('start_date');
            $table->date('end_date');

            $table->index(['bedroom_id'], "fk_bedroom_people");
            $table->index(['booker_id'], "fk_people_bedroom");

            $table->foreign('booker_id')->references('id')->on('peoples');
            $table->foreign('bedroom_id')->references('id')->on('bedrooms');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('busies');
    }
};
