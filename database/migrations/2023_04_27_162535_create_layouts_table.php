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
        Schema::create('layouts', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar');
			$table->string('title_en');
            $table->string('sud_title_ar');
			$table->string('sud_title_en');
            $table->string('description_ar');
			$table->string('description_en');
            $table->string('image');
            $table->enum('layout' , ['first' , 'second' , 'third']);
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
        Schema::dropIfExists('layouts');
    }
};
