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
        Schema::create('storehouse_record', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('storehouse_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('quantity');
            $table->string('status');
            $table->unsignedInteger('reviewer');
            $table->index('storehouse_id');
            $table->index('product_id');
            $table->index('reviewer');
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
        Schema::dropIfExists('storehouse_record');
    }
};
