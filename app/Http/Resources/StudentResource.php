<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'registrationNo' => $this->registration_no,
            'course' => $this->course,
            'dateOfAdmission' => $this->date_of_admission,
            'courseduration' => $this->courseduration,
            'dob' => $this->dob,
            'moteherName' => $this->moteher_name,
            'fatherName' => $this->father_name,
            'address' => $this->address,
            'profilePic' => $this->profile_pic,
            'certificatepic' => $this->certificatepic,
            'coursecompleted' => $this->coursecompleted,
            'certificateissued' => $this->certificateissued,
            'certificateNo' => $this->certificate_no,
        ];
    }
}
