<?php

namespace App\Models;

use App\Traits\UUID;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use UUID;
}
