<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    //

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function teams()
    {
        return $this->hasMany('App\Team');
    }

    public function getProgress()
    {
        $teams = $this->teams();

        $progress = $teams->get()->map(function ($team) {
            return (object)[
                'team'     => $team,
                'progress' => $team->getProgress()
            ];
        });

        return $progress;
    }

}
