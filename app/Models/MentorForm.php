<?php

namespace App\Models;

use App\Scopes\CurrentSemesterScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CurrentSemesterScope::class])]
class MentorForm extends Model
{
    use HasFactory;

    // Define the table associated with the MentorForm model
    protected $table = 'mentor_forms';

    // Fields that are mass assignable
    protected $fillable = [
        'mentor_id',
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

    // Relationship to the Mentor model
    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
