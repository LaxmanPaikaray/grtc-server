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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('phone');
            $table->boolean('whatsapp_on_phone')->default(false);
            $table->timestamp('phone_verified_at')->nullable();
            
            $table->string('alt_phone')->nullable();
            $table->boolean('whatsapp_on_alt_phone')->default(false);
            $table->timestamp('alt_phone_verified_at')->nullable();

            $table->uuid('address_id')->nullable();
            $table->enum('gender', ['M', 'F', 'U'])->default('M');
            $table->uuid('referrer_id')->nullable();
            $table->string('profession')->nullable();
            $table->uuid('job_company_id')->nullable()->comment('student or relatives job details');
            $table->timestamp('birth_day')->nullable();
            $table->timestamp('anniversary')->nullable();
            
            $table->timestamps();

            $table->foreign('address_id')
                  ->references('id')->on('addresses')
                  ->onDelete('cascade');

            $table->foreign('referrer_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('job_company_id')
                  ->references('id')->on('companies')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('user_profiles');
    }
};
