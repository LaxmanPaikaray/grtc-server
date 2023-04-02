<?php

namespace App\Filters;

use App\Filters\APIBaseFilter;

class BlockFilter extends APIBaseFilter {
    protected $allowedParams = [
        'districtId' => ['eq'],
        'slug' => ['eq'],
        'name' => ['eq'],
    ];

    protected $columnMap = [
        'districtId' => 'district_id'
    ];
}
