<?php

namespace App\Filters;

use App\Filters\APIBaseFilter;

class SchoolManagementBoardFilter extends APIBaseFilter {
    protected $allowedParams = [
        'short_name' => ['eq'],
        'slug' => ['eq'],
        'name' => ['eq'],
    ];

    protected $columnMap = [
        'shortName' => 'short_name'
    ];
}
