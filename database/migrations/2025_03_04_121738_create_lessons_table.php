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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('course_id');
            $table->string('cluster_id');
            $table->string('name');
            $table->string('start_date');
            $table->string('end_date');
            $table->timestamp('start_time')->nullable();
            $table->string('weekday')->nullable();
            $table->float('duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
