<th class="bg-gray-50 px-6 py-3 text-left">
    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Description</span>
</th>
<th class="bg-gray-50 px-6 py-3 text-left"> {{-- [tl! add:start --}}
    <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Questions count</span>
</th>

// ...

<td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
    {{ $quiz->description }}
</td>
<td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"> {{-- [tl! add:start --}}
    {{ $quiz->questions_count }}
</td>
