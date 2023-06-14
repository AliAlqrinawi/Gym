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
        Schema::create('app_user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users', 'id')->cascadeOnDelete()->cascadeOnUpdate();
			$table->string('main_goal');
			$table->text('training_goal');
			$table->text('motivates_muscle');
			$table->string('body_type');
			$table->string('desired_body_type');
			$table->text('target_zone');
			$table->string('last_happy_body');
			$table->string('fitness_level');
			$table->string('many_push_ups');
			$table->string('live_elementary');
			$table->string('walk_daily');
			$table->string('feel_meals');
			$table->string('get_sleep');
			$table->string('water_consumption');
			$table->string('diet');
			$table->string('tall');
			$table->string('weight');
			$table->string('goal_weight');
			$table->string('old');
			$table->string('training_location');
			$table->string('Interested_in');
			$table->string('level');
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
        Schema::dropIfExists('app_user_details');
    }
};
