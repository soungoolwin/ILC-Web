<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamLeaderTimetable extends Model
{
    use HasFactory;

    protected $fillable = ['team_leader_id', 'time_slot', 'date'];

    public function teamLeader()
    {
        return $this->belongsTo(TeamLeader::class);
    }
}
