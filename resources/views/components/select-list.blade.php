
    <!-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius -->
    <div>
        <div wire:ignore class="w-full">
            <select class="select2 w-full" data-placeholder="Select your option" {{ $attributes }}>
                @if(!isset($attributes['multiple']))
                    <option></option>
                @endif
                @foreach($options as $key => $value)
                    <option value="{{ $key }}" @selected(in_array($key, $selectedOptions))>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                let el = $('#{{ $attributes['id'] }}')

                function initSelect() {
                el.select2({
                    placeholder: 'Select your option',
                    allowClear: !el.attr('required')
                })
            }

            initSelect()
            Livewire.hook('message.processed', (message, component) => {
                initSelect()
            });
            el.on('change', function (e) {
                let data = $(this).select2("val")
                if (data === "") {
                    data = null
                }
                @this.set('{{ $attributes['wire:model'] }}', data)
            });
            });
        </script>
    @endpush
