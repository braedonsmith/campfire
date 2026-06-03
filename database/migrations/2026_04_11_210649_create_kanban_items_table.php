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
        Schema::create('kanban_items', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('title');
            $table->string('description');
            $table->enum('priority', ['P5', 'P4', 'P3', 'P2', 'P1']);
            $table->enum('status', ['not started', 'in progress', 'complete']);
            $table->integer('assignee_capid');
            $table->integer('creator_capid');
            $table->dateTime('due_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kanban_items');
    }
};
