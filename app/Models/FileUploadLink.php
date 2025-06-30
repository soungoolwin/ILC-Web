<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileUploadLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'for_role',
    ];
}
