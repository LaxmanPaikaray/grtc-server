<?php

namespace Database\Seeders;

use App\Models\State;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DistrictTableSeeder extends Seeder
{
    private $odisha_districts = [
        'state_name' => 'odisha',
        'districts' => [
            'Angul',
            'Khordha',
            'Puri',
            'Cuttack',
        ]
    ];

    private $andhra_districts = [
        'state_name' => 'andhra-pradesh',
        'districts' => [
            'Srikakulam',
            'Parvathipuram Manyam',
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $to_be_processed = [
            $this->odisha_districts,
            $this->andhra_districts,
        ];
        
        foreach ($to_be_processed as $state) {
            $state_name = State::where('slug', $state['state_name'])->first();
            $data = [];
            $districts = $state['districts'];
            foreach($districts as $district) {
                array_push($data, [
                    'id' => Str::Uuid(),
                    'name' => $district,
                    'state_id' => $state_name->id,
                    'headquarter' => null,
                    'slug' => Str::slug($district),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            DB::table('districts')->insert($data);
        }
    }
}
