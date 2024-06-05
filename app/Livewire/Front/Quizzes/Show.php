<?php

use App\Models\Quiz;
//use Illuminate\Contracts\View\View;
//use Illuminate\Database\Eloquent\Collection;

namespace App\Livewire\Front\Quizzes;

use App\Models\Question;
use Livewire\Component;

class Show extends Component
{
    public Quiz $quiz;

    public Collection $questions;

    public Question $currentQuestion;

    public int $currentQuestionIndex = 0;

    public array $questionsAnswers = [];

    public int $startTimeSeconds = 0;

    public function render()
    {
        return view('livewire.front.quizzes.show');
    }


    public function mount(): void
    {
        $this->startTimeSeconds = now()->timestamp;

        $this->questions = Question::query()
            ->inRandomOrder()
            ->whereRelation('quizzes','id', $this->quiz->id)
            ->with('questionOptions')
            ->get();

        $this->currentQuestion = $this->questions[$this->currentQuestionIndex];

        for($i = 0; $i < $this->questionsCount; $i++) {
            $this->questionsAnswers[$i] = [];
        }
    }

    #[Computed]
    public function questionsCount(): int
    {
        return $this->questions->count();
    }

    public function changeQuestion(): void
    {
        $this->currentQuestionIndex++;

        if ($this->currentQuestionIndex >= $this->questionsCount) {
            return $this->submit();
        }

        $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
    }

    public function submit()
    {
        dd('submit');
    }

}
