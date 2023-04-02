<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\State;

class District extends Model
{
    use UUID;
    use HasFactory;
    use Sluggable;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'headquarter',
        'state_id',
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

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function cities() {
        return $this->hasMany(City::class);
    }

    public function blocks() {
        return $this->hasMany(Block::class);
    }
}
