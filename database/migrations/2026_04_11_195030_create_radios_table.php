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
        Schema::create('radio_types', function (Blueprint $table) {
            $table->id();
            $table->string('make');
            $table->string('model');
            $table->enum('form', ['fixed', 'mobile', 'portable']);
        });

        Schema::create('radios', function (Blueprint $table) {
            $table->id();
            $table->integer('radio_type_id');
            $table->string('property_tag_number')->unique();
            $table->string('home_unit');
            $table->integer('issued_to')->nullable();
            $table->boolean('in_service');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radios');
        Schema::dropIfExists('radio_types');
    }
};
