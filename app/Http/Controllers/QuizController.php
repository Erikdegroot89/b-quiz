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

        $progress = $quiz->getProgress();
//        dd($progress);

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
            'quiz'    => $team->quiz()->get()->first(),
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
        $quiz = $team->quiz()->get()->first();

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
        $player = session('player');
        $team   = session('team');

        if (!$player || !$team) {
            return redirect(route('entry.team', $team));
        }

        $activeQuestion = $team->getActiveQuestion();
        $questions      = $quiz->questions()
                               ->where('team_id', '=', $team->id)
                               ->get();


        $progress = $quiz->getProgress();


        return view('quiz.intro')->with([
            'player'         => $player,
            'team'           => $team,
            'quiz'           => $quiz,
            'questions'      => $questions,
            'teamProgress'   => $team->getProgress(),
            'activeQuestion' => $activeQuestion ?: $questions->first(),
            'progress'       => $progress
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

        $questions = $quiz->questions()
                          ->where('team_id', '=', $team->first()->id)
                          ->get();

        return view('quiz.outro')->with([
            'player'      => $player,
            'team'        => $team,
            'quiz'        => $quiz,
            'questions'   => $questions,
            'progress'    => $quiz->getProgress()
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
        $answer      = strtolower($request->input('answer'));
        $hint        = $request->input('hint');
        $player      = session('player');
        $team        = session('team');
        $quiz        = $question->quiz()->get()->first();
        $validAnswer = $this->validateAnswerInput($question, $answer);

        if (!$player) {
            return redirect(route('entry.team', $quiz->id));
        }

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
            'progress'    => $quiz->getProgress()
        ]);
    }


    private function validateAnswerInput(Question $question, $answer)
    {
        return $question->answer == $answer;
    }
}