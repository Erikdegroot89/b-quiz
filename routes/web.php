<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('entry/quiz', 'QuizController@pickQuiz')->name('entry.quiz');
Route::get('entry/quiz/{quiz}', 'QuizController@pickTeam')->name('entry.team');
Route::get('entry/team/{team}', 'QuizController@pickPlayer')->name('entry.player');

Route::post('entry/player/create/', 'PlayerController@postPlayer')->name('player.create');
Route::get('entry/player/select/{player}', 'QuizController@ready')->name('entry.ready');

Route::get('quiz/{quiz}/start', 'QuizController@start')->name('quiz.start');
Route::get('quiz/{quiz}/end', 'QuizController@end')->name('quiz.end');
Route::get('quiz/question/{question}', 'QuizController@question')->name('quiz.question');
Route::Post('quiz/question/{question}', 'QuizController@question')->name('quiz.postAnswer');