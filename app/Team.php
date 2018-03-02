<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function answeredQuestions()
    {
        return $this->hasManyThrough( 'App\Question', 'App\TeamQuestionAnswer', 'team_id', 'team_id');
    }
    public function answers()
    {
        return $this->hasMany( 'App\TeamQuestionAnswer');
    }

    public function getActiveQuestion()
    {
        return $this->answeredQuestions()->where('quiz_id', $this->quiz_id)->orderBy('sort_order', 'desc')->get()->first();
    }

    /**
     * @return object
     */
    public function getProgress()
    {
        return (object)[
            'total'    => $this->questions()->count(),
            'answered' => $this->answeredQuestions()->where('valid',  1)->count(DB::raw('distinct question_id'))
        ];
    }
}
