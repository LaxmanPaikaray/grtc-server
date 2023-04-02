<?php

namespace App\Filters;

use App\Filters\APIBaseFilter;

class SchoolFilter extends APIBaseFilter {
    protected $allowedParams = [
        'villageId' => ['eq'],
        'panchayatId' => ['eq'],
        'blockId' => ['eq'],
        'ciytId' => ['eq'],
        'citySubareaId' => ['eq'],
        'districtId' => ['eq'],
        'managementBoardId' => ['eq'],
        'boardId' => ['eq'],
        'slug' => ['eq'],
        'name' => ['eq'],
        'isActive' => ['eq'],
    ];

    protected $columnMap = [
        'villageId' => 'village_id',
        'panchayatId' => 'panchayat_id',
        'blockId' => 'block_id',
        'ciytId' => 'ciyt_id',
        'citySubareaId' => 'citySubarea_id',
        'districtId' => 'district_id',
        'managementBoardId' => 'managementBoard_id',
        'boardId' => 'board_id',
    ];
}
