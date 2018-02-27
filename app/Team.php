<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function quiz()
    {
        return $this->belongsTo('App\Quiz');
    }

    public function players()
    {
        return $this->hasMany('App\Player');
    }


    public function answers()
    {
        return $this->hasManyThrough('App\Question', 'App\TeamQuestionAnswer', 'question_id', 'team_id');
    }

    public function getActiveQuestion($quiz_id)
    {
        return $this->answers()->where('quiz_id', $quiz_id)->orderBy('sort_order', 'desc')->first();
    }
}
