<?php

namespace App\Filters;

use App\Filters\APIBaseFilter;

class StudentFilter extends APIBaseFilter {
    protected $allowedParams = [
        'id' => ['eq'],
        'name' => ['eq'],
        'registrationNo' => ['eq'],
        'course' => ['eq'],
        'dateOfAdmission' => ['eq'],
        'courseduration' => ['eq'],
        'dob' => ['eq'],
        'moteherName' => ['eq'],
        'fatherName' => ['eq'],
        'address' => ['eq'],
        'profilePic' => ['eq'],
        'certificatepic' => ['eq'],
        'coursecompleted' => ['eq'],
        'certificateissued' => ['eq'],
        'certificateNo' => ['eq'],
    ];

}
