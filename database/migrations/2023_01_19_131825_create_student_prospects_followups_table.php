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
        Schema::create('student_prospects_followups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('student_prospect_id');
            $table->uuid('followup_done_by');
            $table->timestamp('followup_request_date')->nullable();
            $table->timestamp('actual_followup_date')->nullable();
            $table->string('comments');
            $table->timestamps();

            $table->foreign('student_prospect_id')
                  ->references('id')->on('student_prospects')
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
        Schema::dropIfExists('student_prospects_followups');
    }
};
