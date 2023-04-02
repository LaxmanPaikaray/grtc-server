<?php

namespace App\Models;

use App\Traits\UUID;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use UUID;
}
