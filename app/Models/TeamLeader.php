<?php

namespace App\Models;

use App\Scopes\CurrentSemesterScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([CurrentSemesterScope::class])]
class TeamLeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'semester_id',
        'team_leader_id',
        'team_name',
        'team_description',
        'teamleader_image',
    ];

    /**
     * Get the user that owns the team leader profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }


    public function teamLeaderForms() {
        return $this->hasMany(\App\Models\TeamLeaderForm::class);
    }
}
