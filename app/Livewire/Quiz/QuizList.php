<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class QuizList extends Component
{



    public function render(): View
    {
        //$quizzes = Quiz::latest()->paginate();
        $quizzes = Quiz::withCount('questions')->latest()->paginate();
        return view('livewire.quiz.index', compact('quizzes'));
        //return view('livewire.quiz.quiz-list');
    }

    public function delete(Quiz $quiz): void
    {
        abort_if(! auth()->user()->is_admin, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quiz->delete();
    }
}
