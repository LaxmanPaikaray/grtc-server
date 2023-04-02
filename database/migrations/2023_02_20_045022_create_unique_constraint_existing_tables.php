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
        Schema::table('states', function (Blueprint $table) {
            $table->unique('name');
        });
        Schema::table('districts', function (Blueprint $table) {
            $table->unique(['name', 'state_id']);
        });
        Schema::table('blocks', function (Blueprint $table) {
            $table->unique(['name', 'district_id']);
        });
        Schema::table('panchayats', function (Blueprint $table) {
            $table->unique(['name', 'block_id']);
        });
        Schema::table('villages', function (Blueprint $table) {
            $table->unique(['name', 'panchayat_id']);
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->unique(['name', 'district_id']);
        });
        Schema::table('school_management_boards', function (Blueprint $table) {
            $table->unique('name');
        });
        Schema::table('schools', function (Blueprint $table) {
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('states', function(Blueprint $table) {
            $table->dropUnique('states_name_unique');
        });
        Schema::table('districts', function(Blueprint $table) {
            $table->dropUnique('districts_name_state_id_unique');
        });
        Schema::table('blocks', function(Blueprint $table) {
            $table->dropUnique('blocks_name_district_id_unique');
        });
        Schema::table('panchayats', function(Blueprint $table) {
            $table->dropUnique('panchayats_name_block_id_unique');
        });
        Schema::table('villages', function(Blueprint $table) {
            $table->dropUnique('villages_name_panchayat_id_unique');
        });
        Schema::table('cities', function(Blueprint $table) {
            $table->dropUnique('cities_name_district_id_unique');
        });
        Schema::table('school_management_boards', function(Blueprint $table) {
            $table->dropUnique('school_management_boards_name_unique');
        });
        Schema::table('schools', function(Blueprint $table) {
            $table->dropUnique('schools_name_unique');
        });
    }
};
