<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'table_games';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'creator_id'
    ];


    // Define any relationships with other models here

    // Define any custom methods or scopes here
}