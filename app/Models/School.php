<?php

namespace App\Models;

use App\Traits\UUID;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory, UUID, Sluggable;

    protected $fillable = [
        'name',
        'is_active',
        'village_id',
        'panchayat_id',
        'block_id',
        'city_subarea_id',
        'city_id',
        'district_id',
        'management_board_id',
        'board',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function managementBoard() {
        return $this->belongsTo(SchoolManagementBoard::class);
    }

    public function village() {
        return $this->belongsTo(Village::class);
    }

    public function block() {
        return $this->belongsTo(Block::class);
    }

    public function panchayat() {
        return $this->belongsTo(Panchayat::class);
    }

    public function citySubarea() {
        return $this->belongsTo(CitySubarea::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function district() {
        return $this->belongsTo(District::class);
    }
}
