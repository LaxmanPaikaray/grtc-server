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
        Schema::create('sections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->text('description');
            $table->string('slug')->unique();
            $table->integer('duration_in_hours');
            $table->uuid('course_id');
            $table->timestamps();

            $table->foreign('course_id')
                  ->references('id')->on('courses')
                  ->onDelete('cascade');

            $table->comment('Sections can be shown as activity in some courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
};
