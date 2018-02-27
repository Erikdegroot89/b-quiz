<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $fillable = ['name', 'team_id'];
    public function users()
    {
        return $this->belongsTo('App\Team');
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function getQuiz()
    {
        return $this->team()->quiz()->get();
    }
}
