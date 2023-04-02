<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Cviebrock\EloquentSluggable\Sluggable;

class State extends Model
{
    use UUID;
    use HasFactory;
    use Sluggable;

    public $incrementing = false;

    protected $table = 'states';

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function districts(){
        return $this->hasMany(District::class);
    }
}