<?php

namespace App\Livewire\Questions;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class QuestionForm extends Component
{


        public ?Question $question = null;

        public string $question_text = '';
        public string|null $code_snippet = '';
        public string|null $answer_explanation = '';
        public string|null $more_info_link = '';

        public bool $editing = false;


    public function render(): View
    {
        return view('livewire.questions.question-form');
    }

    
    public function mount(Question $question): void
    {
        if ($question->exists) {
            $this->question = $question;
            $this->editing = true;
            $this->question_text = $question->question_text;
            $this->code_snippet = $question->code_snippet;
            $this->answer_explanation = $question->answer_explanation;
            $this->more_info_link = $question->more_info_link;
        }
    }

    public function save(): Redirector|RedirectResponse
    {
        $this->validate();

        if (empty($this->question)) {
            $this->question = Question::create($this->only(['question_text', 'code_snippet', 'answer_explanation', 'more_info_link']));
        }

        else {
            $this->question->update($this->only(['question_text', 'code_snippet', 'answer_explanation', 'more_info_link']));
        }

        return to_route('questions');
    }


    protected function rules(): array
    {
        return [
            'question_text' => [
                'string',
                'required',
            ],
            'code_snippet' => [
                'string',
                'nullable',
            ],
            'answer_explanation' => [
                'string',
                'nullable',
            ],
            'more_info_link' => [
                'url',
                'nullable',
            ],
        ];
    }
}
