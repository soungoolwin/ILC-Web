<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studentForms() {
        return $this->hasMany(\App\Models\StudentForm::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
