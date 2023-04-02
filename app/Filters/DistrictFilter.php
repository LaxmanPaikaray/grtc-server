<?php

namespace App\Filters;

use App\Filters\APIBaseFilter;

class DistrictFilter extends APIBaseFilter {
    protected $allowedParams = [
        'stateId' => ['eq'],
        'slug' => ['eq'],
        'name' => ['eq'],
    ];

    protected $columnMap = [
        'stateId' => 'state_id'
    ];
}
