<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
