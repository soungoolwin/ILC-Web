<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamLeaderForm extends Model
{
    use HasFactory;

    // Define the table associated with the TeamLeaderForm model
    protected $table = 'team_leader_forms';

    // Fields that are mass assignable
    protected $fillable = [
        'team_leader_id',
        'form_id',
        'completion_status',
        'submitted_datetime',
    ];

    // Relationship to the Form model
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    // Relationship to the TeamLeader model
    public function teamLeader()
    {
        return $this->belongsTo(TeamLeader::class);
    }
}

