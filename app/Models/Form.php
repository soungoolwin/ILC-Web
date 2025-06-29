<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    // Define the table associated with the Form model
    protected $table = 'forms';

    // Fields that are mass assignable
    protected $fillable = [
        'form_name',
        'form_description',
        'form_type',
        'for_role',
        'is_active',
        'is_mandatory',
    ];

    // Relationships to the role-specific forms
    public function studentForms()
    {
        return $this->hasMany(StudentForm::class);
    }

    public function mentorForms()
    {
        return $this->hasMany(MentorForm::class);
    }

    public function teamLeaderForms()
    {
        return $this->hasMany(TeamLeaderForm::class);
    }
}
