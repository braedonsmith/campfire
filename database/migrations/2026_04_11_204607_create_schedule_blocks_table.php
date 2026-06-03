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
        Schema::create('schedule_block_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('category');
            $table->string('name');
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('office_symbol');
            $table->integer('parent_id')->nullable();
            $table->enum('scope', ['flight', 'squadron', 'group', 'wing']);
        });

        Schema::create('schedule_blocks', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_block_type_id');
            $table->integer('unit_id');
            $table->string('name');
            $table->integer('location_id');
            $table->integer('facilitator_capid');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->boolean('is_approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_block_types');
        Schema::dropIfExists('units');
        Schema::dropIfExists('schedule_blocks');
    }
};
