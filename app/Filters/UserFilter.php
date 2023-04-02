<?php

namespace App\Filters;

use App\Filters\APIBaseFilter;

class UserFilter extends APIBaseFilter {
    protected $allowedParams = [
        'name' => ['eq'],
        'slug'=>['eq'],
        'username' => ['eq'],
    ];

    protected $columnMap = [
        'name' => 'name',
        'email'=>'email',
        'username' => 'username',
    ];
}
?>