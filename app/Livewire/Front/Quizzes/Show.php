<?php

use App\Models\Quiz;
//use Illuminate\Contracts\View\View;
//use Illuminate\Database\Eloquent\Collection;

namespace App\Livewire\Front\Quizzes;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Test;
use App\Models\TestAnswer;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

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

    public function submit(): Redirector|RedirectResponse
    {
        $result = 0;

        $test = Test::create([
            'user_id'    => auth()->id(),
            'quiz_id'    => $this->quiz->id,
            'result'     => 0,
            'ip_address' => request()->ip(),
            'time_spent' => now()->timestamp - $this->startTimeSeconds
        ]);

        foreach ($this->questionsAnswers as $key => $option) {
            $status = 0;

            if (! empty($option) && QuestionOption::find($option)->correct) {
                $status = 1;
                $result++;
            }

            TestAnswer::create([
                'user_id'     => auth()->id(),
                'test_id'     => $test->id,
                'question_id' => $this->questions[$key]->id,
                'option_id'   => $option ?? null,
                'correct'     => $status,
            ]);
        }

        $test->update([
            'result' => $result,
        ]);

        //return to_route('home');
        return to_route('results.show', $test);
    }



}
