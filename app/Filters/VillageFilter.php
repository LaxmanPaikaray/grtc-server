<?php

namespace App\Filters;

use App\Filters\APIBaseFilter;

class VillageFilter extends APIBaseFilter {
    protected $allowedParams = [
        'blockId' => ['eq'],
        'slug' => ['eq'],
        'name' => ['eq'],
    ];

    protected $columnMap = [
        'blockId' => 'block_id'
    ];
}
