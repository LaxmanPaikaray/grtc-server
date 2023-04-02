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
            'registrationNo' => $this->registrationNo,
            'course' => $this->course,
            'dateOfAdmission' => $this->dateOfAdmission,
            'courseduration' => $this->courseduration,
            'dob' => $this->dob,
            'moteherName' => $this->moteherName,
            'fatherName' => $this->fatherName,
            'address' => $this->address,
            'profilePic' => $this->profilePic,
            'certificatepic' => $this->certificatepic,
            'coursecompleted' => $this->coursecompleted,
            'certificateissued' => $this->certificateissued,
            'certificateNo' => $this->certificateNo,
        ];
    }
}
