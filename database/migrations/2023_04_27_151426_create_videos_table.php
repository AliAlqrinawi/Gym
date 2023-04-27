<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained('exercises', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title_ar');
			$table->string('title_en');
			$table->string('duration_exercise');
			$table->string('fitness_level');
			$table->string('image');
			$table->string('video');
			$table->enum('type' , ['home' , 'gym'])->default('gym');
			$table->string('alternative_video');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
