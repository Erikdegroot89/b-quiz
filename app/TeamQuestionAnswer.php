<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Pusher;
class TeamQuestionAnswer extends Model
{
    //
    protected $fillable = ['team_id', 'question_id', 'player_id', 'answer', 'valid'];

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }



    public function push()
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher\Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        $team = $this->team()->with('quiz')->get()->first();

        $quiz_id = $team->quiz->id;
        $question = $this->question()->get()->first();
        $data['message'] = 'Team '.$team->name.' heeft vraag '. ($question->sort_order + 1). ' beantwoord!';
        $data['answer'] = $this->toArray();
        $data['team'] = $team;
        $pusher->trigger('quiz-'.$quiz_id, 'team-progress', $data);
        return $this;
    }
}
