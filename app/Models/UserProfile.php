<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class UserProfile extends Model
{
    use HasFactory;
    use UUID;

    public $incrementing = false;

    protected $table = 'user_profiles';

    protected $fillable = [
        'phone',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
