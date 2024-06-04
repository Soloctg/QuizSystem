<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="mt-4">
        <x-input-label for="questions" value="Questions" />
        <x-select-list class="w-full" id="questions" name="questions" :options="$this->listsForFields['questions']" :selectedOptions="$questions" wire:model="questions" multiple />
        <x-input-error :messages="$errors->get('questions')" class="mt-2" />
    </div>
</div>


