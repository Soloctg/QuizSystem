<x-app-layout>

    <div class="mt-4">
        <x-input-label for="question_options" value="Question options"/>
            @foreach($questionOptions as $index => $questionOption)
                <div class="flex mt-2">
                    <x-text-input type="text" wire:model="questionOptions.{{ $index }}.option" class="w-full" name="questions_options_{{ $index }}" id="questions_options_{{ $index }}" autocomplete="off"/>

                    <div class="flex items-center">
                        <input type="checkbox" class="mr-1 ml-4" wire:model.defer="questionOptions.{{ $index }}.correct"> Correct
                        <button wire:click="removeQuestionsOption({{ $index }})" type="button" class="ml-4 rounded-md border border-transparent bg-red-200 px-4 py-2 text-xs uppercase text-red-500 hover:bg-red-300 hover:text-red-700">
                            Delete
                        </button>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('questionOptions.' . $index . '.option')" class="mt-2" />
            @endforeach

        <x-input-error :messages="$errors->get('questionOptions')" class="mt-2" />

        <x-primary-button wire:click="addQuestionsOption" type="button" class="mt-2">
            Add
        </x-primary-button>
    </div>

</x-app-layout>
