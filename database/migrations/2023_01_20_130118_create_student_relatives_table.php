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
        Schema::create('student_relatives', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->comment('user_id of the relative in our system');
            $table->enum('type', ['FATHER', 'MOTHER', 'HUSBAND', 'WIFE', 'OTHER'])->default('OTHER');
            $table->uuid('student_id');
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
        Schema::dropIfExists('student_relatives');
    }
};
