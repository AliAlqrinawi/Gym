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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('tables', 'id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title_ar');
			$table->string('title_en');
            $table->string('description_ar');
			$table->string('description_en');
			$table->string('image');
            $table->text('id_videos');
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
        Schema::dropIfExists('tables');
    }
};
