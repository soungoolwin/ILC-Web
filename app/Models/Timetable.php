<?php

namespace App\Models;

use App\Scopes\CurrentSemesterScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CurrentSemesterScope::class])]
class Timetable extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
