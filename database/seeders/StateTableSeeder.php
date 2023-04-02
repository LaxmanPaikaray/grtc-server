<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StateTableSeeder extends Seeder
{
    // Data sourced from https://en.wikipedia.org/wiki/States_and_union_territories_of_India
    private $state_names = [
        1 => [
            'name' => 'Andhra Pradesh',
            'headquarter' => 'Amaravathi'
        ],
        2 => [
            'name' => 'Arunachal Pradesh',
            'headquarter' => 'Aijol'
        ],
        3 => [
            'name' => 'Assam',
            'headquarter' => 'Dispur'
        ],
        4 => [
            'name' => 'Odisha',
            'headquarter' => 'Bhubaneswar'
        ]
    ];

    private $ut_names = [
        1 => [
            'name' => 'Andaman and Nicobar Islands',
            'headquarter' => 'Port Blair'
        ],
        2 => [
            'name' => 'Chandigarh',
            'headquarter' => 'Chandigarh'
        ],
    ];

    private function map_state_data($el) {
        return [
            'id' => Str::Uuid(),
            'name' => $el['name'],
            'headquarter' => $el['headquarter'],
            'slug' => Str::slug($el['name']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $state_data = array_map([$this, 'map_state_data'], $this->state_names);
        $ut_data = array_map([$this, 'map_state_data'], $this->ut_names);
        DB::table('states')->insert($state_data);
        DB::table('states')->insert($ut_data);
    }
}
