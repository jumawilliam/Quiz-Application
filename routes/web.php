<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuizController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Inertia('Home');
});

Route::get('/questions',[QuestionController::class,'index'])->name('questions');
Route::post('/questions',[QuestionController::class,'store']);
Route::put('/questions',[QuestionController::class,'update']);
Route::delete('/questions/{question}',[QuestionController::class,'destroy']);
Route::put('/answers',[AnswerController::class,'update']);

Route::get('quiz',[QuizController::class,'index']);
Route::post('/results',[QuizController::class,'results']);

Route::fallback(function(){
    return Inertia('Home');
});
