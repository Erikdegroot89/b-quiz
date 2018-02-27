<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //

    public function quiz()
    {
        return $this->belongsTo('App\Quiz');
    }

    /**
     * @param $quiz_id
     * @param $team_id
     * @param $index
     * @return mixed
     */
    static function getForQuizAndTeamAndIndex($quiz_id, $team_id, $index)
    {
        return Question::
            where('team_id', $team_id)
            ->where('quiz_id', $quiz_id)
            ->where('sort_order', '=', $index)
            ->get()
            ->first();
    }

    /**
     * @return mixed
     */
    public function getNext()
    {
        return Question::getForQuizAndTeamAndIndex($this->quiz_id, $this->team_id, $this->sort_order + 1);
    }
}
