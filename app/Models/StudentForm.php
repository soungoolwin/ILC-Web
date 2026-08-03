<?php

namespace App\Models;

use App\Scopes\CurrentSemesterScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CurrentSemesterScope::class])]
class StudentForm extends Model
{
    use HasFactory;

    // Define the table associated with the StudentForm model
    protected $table = 'student_forms';

    // Fields that are mass assignable
    protected $fillable = [
        'student_id',
        'semester_id',
        'form_id',
        'completion_status',
        'submitted_datetime',
    ];

    // Relationship to the Form model
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    // Relationship to the Student model
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}

