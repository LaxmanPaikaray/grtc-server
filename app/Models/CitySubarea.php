<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Cviebrock\EloquentSluggable\Sluggable;

class CitySubarea extends Model
{
    use UUID;
    use HasFactory;
    use Sluggable;

    public $incrementing = false;
    protected $table = 'city_subareas';

    protected $fillable = [
        'name',
        'city_id',
        'slug',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function city() {
        return $this->belongsTo(City::class);
    }
}
