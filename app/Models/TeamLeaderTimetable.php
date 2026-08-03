<?php

namespace App\Models;

use App\Scopes\CurrentSemesterScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CurrentSemesterScope::class])]
class TeamLeaderTimetable extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function teamLeader()
    {
        return $this->belongsTo(TeamLeader::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
