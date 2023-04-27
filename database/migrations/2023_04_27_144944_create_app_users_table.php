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
        Schema::create('app_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
			$table->string('mobile_number');
			$table->string('email');
			$table->string('password');
			$table->enum('status', ['active', 'pending_activation', 'inactive'])->default('pending_activation');
			$table->string('avatar')->nullable();
			$table->string('activation_code', 5)->nullable();
			$table->string('ip_address')->nullable();
			$table->integer('resend_code_count')->default('0');
			$table->string('device_token');
			$table->date('exp_date')->nullable();
			$table->integer('days')->nullable();
            $table->enum('sex', ['male', 'female']);
			$table->string('days_exercise')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('app_users');
    }
};
