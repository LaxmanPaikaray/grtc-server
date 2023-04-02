<?php

namespace App\Filters;

use App\Filters\APIBaseFilter;

class CitySubareaFilter extends APIBaseFilter {
    protected $allowedParams = [
        'cityId' => ['eq'],
        'slug' => ['eq'],
        'name' => ['eq'],
    ];

    protected $columnMap = [
        'cityId' => 'city_id'
    ];
}
