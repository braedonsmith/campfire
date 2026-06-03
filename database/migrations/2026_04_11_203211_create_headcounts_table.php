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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address_1');
            $table->string('address_2');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
        });

        Schema::create('headcounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('location_id');
            $table->timestamps();
        });

        Schema::create('headcount_entries', function (Blueprint $table) {
            $table->id();
            $table->integer('headcount_id');
            $table->integer('capid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('headcount_entries');
        Schema::dropIfExists('headcounts');
        Schema::dropIfExists('locations');
    }
};
