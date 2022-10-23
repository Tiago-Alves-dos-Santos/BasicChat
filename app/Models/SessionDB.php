<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionDB extends Model
{
    use HasFactory;

    protected $table = 'sessions';
    protected $guardade = [];

    public static function sessionActive($user_id)
    {
        return SessionDB::where('user_id', $user_id)->exists();
    }
}
