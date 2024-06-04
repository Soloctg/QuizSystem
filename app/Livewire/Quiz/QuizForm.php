<?php

namespace App\Livewire\Quiz;

//use App\Models\Question;
use Illuminate\Support\Str;

use Illuminate\Contracts\View\View;
//use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

use App\Models\Quiz;
use Livewire\Component;

class QuizForm extends Component
{
    public ?Quiz $quiz = null;

    public string $title = '';
    public string $slug = '';
    public string|null $description = '';
    public bool $published = false;
    public bool $public = false;

    public bool $editing = false;

    public array $questions = [];

    public array $listsForFields = [];

    public function render(): View
    {
        return view('livewire.quiz.quiz-form');
    }

    public function mount(Quiz $quiz): void
    {
        if ($quiz->exists) {
            $this->quiz = $quiz;
            $this->editing = true;
            $this->title = $quiz->title;
            $this->slug = $quiz->slug;
            $this->description = $quiz->description;
            $this->published = $quiz->published;
            $this->public = $quiz->public;
        } else {
            $this->published = false;
            $this->public = false;
        }
    }

    public function updatedTitle(): void
    {
        $this->slug = Str::slug($this->title);
    }

    public function save(): Redirector|RedirectResponse
        {
            $this->validate();

            if (empty($this->quiz)) {
                $this->quiz = Quiz::create($this->only(['title', 'slug', 'description', 'published', 'public']));
            } else {
                $this->quiz->update($this->only(['title', 'slug', 'description', 'published', 'public']));
            }

            return to_route('quizzes');
        }

        protected function rules(): array
        {
            return [
                'title'       => [
                    'string',
                    'required',
                ],
                'slug'        => [
                    'string',
                    'nullable',
                ],
                'description' => [
                    'string',
                    'nullable',
                ],
                'published'   => [
                    'boolean',
                ],
                'public'      => [
                    'boolean',
                ],
                'questions' => [
                    'array'
                ],
            ];
        }

}
