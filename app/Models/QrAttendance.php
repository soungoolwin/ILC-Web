<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrAttendance extends Model
{
    protected $fillable = ['student_id', 'day', 'time'];

    public function studentProfile()
    {
        return $this->hasOne(QrStudentAttendance::class, 'student_id', 'student_id');
    }
}
