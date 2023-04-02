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
        Schema::create('student_prospects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('gender', ['M', 'F', 'U'])->default('M');
            $table->string('education')->comment('current or last education');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('whatsapp_available')->default(false);
            $table->uuid('school_id')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_profession')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_profession')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_profession')->nullable();
            $table->string('guardian1_name')->nullable();
            $table->string('guardian1_profession')->nullable();
            $table->string('guardian2_name')->nullable();
            $table->string('guardian2_profession')->nullable();
            $table->timestamp('first_contact_date');
            $table->integer('convertion_chances_pct')->nullable();
            $table->uuid('sales_person');
            $table->timestamp('next_followup_date')
                  ->nullable()
                  ->comment('leave this null if no followup required');
            $table->timestamps();

            $table->foreign('school_id')
                  ->references('id')->on('schools')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_prospects');
    }
};
