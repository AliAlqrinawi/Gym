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
            $table->string('description_ar')->nullable();
			$table->string('description_en')->nullable();
			$table->string('image')->nullable();
            $table->text('id_videos')->nullable();
            $table->enum('is_parent' , ['parent' , 'inparent' , 'muscle'])->default('active');
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
        Schema::dropIfExists('tables');
    }
};
