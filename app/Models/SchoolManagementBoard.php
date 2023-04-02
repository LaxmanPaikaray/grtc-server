<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Cviebrock\EloquentSluggable\Sluggable;

class SchoolManagementBoard extends Model
{
    use UUID;
    use HasFactory;
    use Sluggable;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'short_name',
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

}
