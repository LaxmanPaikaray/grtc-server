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
        Schema::create('schools', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug');
            $table->boolean('is_active')->default(true);

            $table->uuid('village_id')->nullable();
            $table->uuid('panchayat_id')->nullable();
            $table->uuid('block_id')->nullable();

            $table->uuid('city_subarea_id')->nullable();
            $table->uuid('city_id')->nullable();

            $table->uuid('district_id')->nullable();
            $table->uuid('management_board_id')->nullable()->comment('Like DPS, DAV, etc');
            $table->enum('board', ['State', 'CBSE', 'ICSE']);
            $table->uuid('address_id')->nullable();
            $table->timestamps();

            $table->foreign('village_id')
                  ->references('id')->on('villages')
                  ->onDelete('cascade');

            $table->foreign('panchayat_id')
                  ->references('id')->on('panchayats')
                  ->onDelete('cascade');

            $table->foreign('block_id')
                  ->references('id')->on('blocks')
                  ->onDelete('cascade');

            $table->foreign('city_subarea_id')
                  ->references('id')->on('city_subareas')
                  ->onDelete('cascade');

            $table->foreign('city_id')
                  ->references('id')->on('cities')
                  ->onDelete('cascade');

            $table->foreign('address_id')
                  ->references('id')->on('addresses')
                  ->onDelete('cascade');

            $table->foreign('management_board_id')
                  ->references('id')->on('school_management_boards')
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
        Schema::dropIfExists('schools');
    }
};
