<?php

namespace App\Models;

use App\Scopes\CurrentSemesterScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CurrentSemesterScope::class])]
class Mentor extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'last_checked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function mentorForms()
    {
        return $this->hasMany(\App\Models\MentorForm::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }
}
