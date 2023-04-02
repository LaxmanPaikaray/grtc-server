<?php

namespace App\Filters;

use App\Filters\APIBaseFilter;

class CourseFilter extends APIBaseFilter {
    protected $allowedParams = [
        'short_name' => ['eq'],
        'slug' => ['eq'],
        'duration_in_days' => ['eq'],
        'is_active'=>['eq']
    ];

    protected $columnMap = [
        'durationInDays' => 'duration_in_days',
        'isActive'=>'is_active'
    ];
}
?>