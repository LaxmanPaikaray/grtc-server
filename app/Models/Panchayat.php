<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Cviebrock\EloquentSluggable\Sluggable;

class Panchayat extends Model
{
    use UUID;
    use HasFactory;
    use Sluggable;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'block_id',
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

    public function block() {
        return $this->belongsTo(Block::class);
    }

    public function villages() {
        return $this->hasMany(Village::class);
    }
}
