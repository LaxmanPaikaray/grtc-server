<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Cviebrock\EloquentSluggable\Sluggable;

class Course extends Model
{
    use UUID;
    use HasFactory;
    use Sluggable;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'slug',
        'duration_in_days',
        'is_active'
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
?>

