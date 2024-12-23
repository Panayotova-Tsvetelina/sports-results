<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['game_id', 'team1_score', 'team2_score'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

}
