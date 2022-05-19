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
        Schema::create("teachers_courses", function(Blueprint $table){
            $table->id();
            $table->foreignId("teacherId")->references("teacherId")->on("teachers");
            $table->foreignId("courseId")->references("courseId")->on("courses");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("teachers_courses");
    }
};
