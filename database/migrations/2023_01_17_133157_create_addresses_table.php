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
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->uuid('village_id')->nullable();
            $table->uuid('area_id')->nullable();
            $table->uuid('city_id')->nullable();
            $table->string('pincode')->nullable();
            $table->timestamps();

            $table->foreign('village_id')
                  ->references('id')->on('villages')
                  ->onDelete('cascade');

            $table->foreign('area_id')
                  ->references('id')->on('areas')
                  ->onDelete('cascade');

            $table->foreign('city_id')
                  ->references('id')->on('cities')
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
        Schema::dropIfExists('addresses');
    }
};
