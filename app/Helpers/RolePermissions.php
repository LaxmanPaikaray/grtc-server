<?php

namespace App\Helpers;

class RolePermissions
{
    public const ROLE_SUPER_ADMIN = 'super-admin';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_BASIC = 'basic';
    public const ROLE_STUDENT = 'student';
    public const ROLE_PARENT = 'parent';
    public const ROLE_TEACHER = 'teacher';
    public const ROLE_SALES = 'sales';
    public const ROLE_SUPPORT = 'support';
    public const ROLE_PROSPECT = 'prospect';

    // location permissions are for block, state, district etc.
    public const PERM_LIST_LOCATIONS = 'list-locations';
    public const PERM_ADD_UPDATE_LOCATIONS = 'add-locations';
    public const PERM_DELETE_LOCATIONS = 'delete-locations';

    // school permissions are for school and school management
    public const PERM_LIST_SCHOOLS = 'list-schools';
    public const PERM_ADD_UPDATE_SCHOOLS = 'add-schools';
    public const PERM_DELETE_SCHOOLS = 'delete-schools';
}
