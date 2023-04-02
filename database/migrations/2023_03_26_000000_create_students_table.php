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
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('registrationNo')->unique(); //can be phone number or email or simple user names
            $table->string('course');
            $table->string('dateOfAdmission');
            $table->string('courseduration');
            $table->string('dob');
            $table->string('moteherName');
            $table->string('fatherName');
            $table->string('address');
            $table->string('profilePic');
            $table->string('certificatepic')->nullable();
            $table->string('coursecompleted');
            $table->string('certificateissued');
            $table->string('certificateNo')->nullable();
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
        Schema::dropIfExists('students');
    }
};
