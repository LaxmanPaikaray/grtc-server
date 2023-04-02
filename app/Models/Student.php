<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\UUID;
use Spatie\Permission\Traits\HasRoles;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use UUID;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'registrationNo',
        'course',
        'dateOfAdmission',
        'courseduration',
        'dob',
        'moteherName',
        'fatherName',
        'address',
        'profilePic',
        'certificatepic',
        'coursecompleted',
        'certificateissued',
        'certificateNo',
    ];


}
