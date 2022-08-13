<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_to_columns', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('column_id');
            $table->unsignedInteger('category_id');
//            $table->foreign('category_id')->references('id')->on('bill_categories')->cascadeOnDelete();
//            $table->foreign('column_id')->references('id')->on('bill_columns')->cascadeOnDelete();
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
        Schema::dropIfExists('category_to_columns');
    }
};
