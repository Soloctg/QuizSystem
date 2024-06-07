<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (! $quiz->public && ! auth()->check())
                        <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-indigo-500">
                            <span class="inline-block align-middle mr-8">
                                This test is available only for registered users. Please <a href="{{ route('login') }}" class="hover:underline">Log in</a> or <a href="{{ route('register') }}" class="hover:underline">Register</a>
                            </span>
                        </div>
                    @else

                        <front.quizzes.show :quiz="$quiz" />
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div>
        <span class="text-bold">Question {{ $currentQuestionIndex + 1 }} of {{ $this->questionsCount }}:</span>
        <h2 class="mb-4 text-2xl">{{ $currentQuestion->question_text }}</h2>

        @if ($currentQuestion->code_snippet)
            <pre class="mb-4 border-2 border-solid bg-gray-50 p-2">{{ $currentQuestion->code_snippet }}</pre>
        @endif

        @foreach($currentQuestion->questionOptions as $option)
            <div>
                <label for="option.{{ $option->id }}">
                    <input type="radio"
                           id="option.{{ $option->id }}"
                           wire:model="questionsAnswers.{{ $currentQuestionIndex }}"
                           name="questionsAnswers.{{ $currentQuestionIndex }}"
                           value="{{ $option->id }}">
                    {{ $option->option }}
                </label>
            </div>
        @endforeach

        @if ($currentQuestionIndex < $this->questionsCount - 1)
            <div class="mt-4">
                <x-secondary-button x-on:click="secondsLeft = {{ config('quiz.secondsPerQuestion') }}; $wire.changeQuestion();">
                    Next question
                </x-secondary-button>
            </div>
        @else

            <div class="mt-4">
                <x-primary-button wire:click.prevent="submit">Submit</x-primary-button>
            </div>


        @endif


    </div>

    <div
        x-data="{ secondsLeft: {{ config('quiz.secondsPerQuestion') }} }"
        x-init="setInterval(() => { if (secondsLeft > 1) { secondsLeft--; } else { secondsLeft = {{ config('quiz.secondsPerQuestion') }}; $wire.changeQuestion(); } }, 1000);">

        <div class="mb-2">
            Time left for this question: <span x-text="secondsLeft" class="font-bold"></span> sec.
        </div>
    </div>

</x-app-layout>
