<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveFile extends Model
{
    use HasFactory;

    protected $table = 'table_savefiles';
    protected $fillable = ['user_id', 'charName', 'realm', 'gameData', 'game_id'];

}
