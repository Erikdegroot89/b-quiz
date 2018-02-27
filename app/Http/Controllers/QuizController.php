<?php

namespace App\Http\Controllers;

use App\Events\QuizProgress;
use App\Player;
use App\Question;
use App\Quiz;
use App\Team;
use App\TeamQuestionAnswer;
use Illuminate\Http\Request;


class QuizController extends Controller
{
    //


    /**
     * @return $this
     */
    public function pickQuiz()
    {
        $quizzes = Quiz::all();

        return view('entry.quiz')->with([
            'quizzes' => $quizzes
        ]);
    }

    /**
     * @param Quiz $quiz
     * @return $this
     */
    public function pickTeam(Quiz $quiz)
    {
        $teams = $quiz->teams()->get();
        session('quiz', $quiz);

        return view('entry.team')->with([
            'quiz'  => $quiz,
            'teams' => $teams
        ]);
    }

    /**
     * @param Team $team
     * @return $this
     */
    public function pickPlayer(Team $team)
    {
        return view('entry.player')->with([
            'quiz'    => $team->quiz()->get(),
            'team'    => $team,
            'players' => $team->players()->get()
        ]);
    }

    /**
     * @param Request $request
     * @param Player  $player
     * @return $this
     */
    public function ready(Request $request, Player $player)
    {
        $team = $player->team()->get()->first();
        $quiz = $team->quiz();

        $request->session()->put('player', $player);
        $request->session()->put('team', $team);

        return view('entry.ready')->with([
            'player' => $player,
            'team'   => $team,
            'quiz'   => $quiz
        ]);
    }

    /**
     * @param Quiz $quiz
     * @return $this
     */
    public function start(Quiz $quiz)
    {
        $player      = session('player');
        $team        = session('team');
        $competition = $this->calculateCompetition($quiz);

        $questions      = $quiz->questions()
                               ->where('team_id', '=', $team->first()->id)
                               ->get();
        $activeQuestion = $team->getActiveQuestion($quiz->id);
        return view('quiz.intro')->with([
            'player'         => $player,
            'team'           => $team,
            'quiz'           => $quiz,
            'questions'      => $questions,
            'competition'    => $competition,
            'activeQuestion' => $activeQuestion ?: $questions->first()
        ]);
    }

    /**
     * @param Quiz $quiz
     * @return $this
     */
    public function end(Quiz $quiz)
    {
        $player      = session('player');
        $team        = session('team');
        $competition = $this->calculateCompetition($quiz);

        $questions = $quiz->questions()
                          ->where('team_id', '=', $team->first()->id)
                          ->get();

        return view('quiz.outro')->with([
            'player'      => $player,
            'team'        => $team,
            'quiz'        => $quiz,
            'questions'   => $questions,
            'competition' => $competition
        ]);
    }


    /**
     * @param Request  $request
     * @param Question $question
     * @return $this
     */
    public function question(Request $request, Question $question)
    {
        $next        = null;
        $answer      = $request->input('answer');
        $hint        = $request->input('hint');
        $player      = session('player');
        $team        = session('team');
        $quiz        = $question->quiz()->get()->first();
        $validAnswer = $this->validateAnswerInput($question, $answer);

        if(!$player)
        {
           return redirect(route('entry.team', $quiz->id));
        }
        $competition = $this->calculateCompetition($quiz);
        if ($answer) {
            $next = $question->getNext();

            $submittedAnswer = TeamQuestionAnswer::create([
                'team_id'     => $team->first()->id,
                'question_id' => $question->id,
                'player_id'   => $player->first()->id,
                'answer'      => $answer,
                'valid'       => $validAnswer
            ]);

            if ($validAnswer) {
                $submittedAnswer->push(); // call pusher
            }
        }

        return view('quiz.question')->with([
            'player'      => $player,
            'team'        => $team,
            'hinted'      => $hint,
            'quiz'        => $quiz,
            'answer'      => $answer,
            'question'    => $question,
            'validAnswer' => $validAnswer,
            'next'        => $next,
            'competition' => $competition
        ]);
    }

    private function calculateCompetition(Quiz $quiz)
    {
        $total       = $quiz->questions()->count();
        $teams       = $quiz->teams()->get();

        $competition = (object)[];

        $competition->teams = $teams->map(function ($team) use ($quiz, $total) {
            $active_q = $team->getActiveQuestion($quiz->id);
            $current = ($active_q) ? $active_q->sort_order : 0;
            return (object)[
                'name'     => $team->name,
                'current'  => $current ,
                'progress' => ($current == 0) ? 0 : round($current / $total * 100)
            ];
        });
        $competition->scores = [];
        $competition->total = $total;
        return $competition;
    }

    private function validateAnswerInput(Question $question, $answer)
    {
        return $question->answer == $answer;
    }
}