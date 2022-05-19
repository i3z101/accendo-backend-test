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
        Schema::create('homeworks', function (Blueprint $table) {
            $table->id("homeworkId");
            $table->string("homeworkQuestion");
            $table->foreignId("courseId")->references("courseId")->on("courses");
            $table->foreignId("teacherId")->references("teacherId")->on("teachers");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("homeworks");
    }
};
