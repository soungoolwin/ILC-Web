<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrStudentAttendance extends Model
{
    protected $fillable = ['student_id', 'name', 'section', 'ajarn_name'];

    public function attendances()
    {
        return $this->hasMany(QrAttendance::class, 'student_id', 'student_id');
    }
}
