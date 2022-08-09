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
        Schema::create('bill_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('bill_id');
            $table->decimal('amount', 10, 2);
            $table->text('remark')->comment('备注')->nullable();
            $table->unsignedInteger('writer')->comment('记录者');
            $table->unsignedInteger('reviewer')->comment('审核人')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->string('model')->nullable();
            $table->string('model_id')->nullable();
            $table->unsignedTinyInteger('week');
            $table->unsignedTinyInteger('day');
            $table->unsignedTinyInteger('month');
            $table->unsignedTinyInteger('year');
            $table->index('bill_id');
            $table->index('category_id');
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
        Schema::dropIfExists('bill_items');
    }
};
