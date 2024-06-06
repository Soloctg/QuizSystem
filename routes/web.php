<?php

use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResultController;
use App\Livewire\Front\Leaderboard;
use App\Livewire\Questions\QuestionForm;
use App\Livewire\Questions\QuestionList;
use App\Livewire\Quiz\QuizForm;
use App\Livewire\Quiz\QuizList;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('quiz/{quiz}/{slug?}', [HomeController::class, 'show'])->name('quiz.show');
Route::get('results/{test}', [ResultController::class, 'show'])->name('results.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('results', [ResultController::class, 'index'])->name('results.index');
    Route::get('leaderboard', Leaderboard::class)->name('leaderboard');




    Route::middleware('isAdmin')->group(function () {


        Route::get('questions', QuestionList::class)->name('questions');
        Route::get('questions/create', QuestionForm::class)->name('questions.create');
        Route::get('questions/{question}', QuestionForm::class)->name('questions.edit');

        Route::get('quizzes', QuizList::class)->name('quizzes');
        Route::get('quizzes/create', QuizForm::class)->name('quiz.create');
        Route::get('quizzes/{quiz}', QuizForm::class)->name('quiz.edit');

        Route::get('tests', TestController::class)->name('tests');
    });

});



require __DIR__.'/auth.php';
