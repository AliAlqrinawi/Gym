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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
			$table->string('title_en');
            $table->string('description_ar');
			$table->string('description_en');
            $table->string('title_duration_ar');
			$table->string('title_duration_en');
			$table->text('options');
			$table->string('duration');
			$table->string('price');
            $table->enum('status' , ['active' , 'inactive'])->default('active');
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
        Schema::dropIfExists('packages');
    }
};
