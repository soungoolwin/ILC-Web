<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamLeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
}
