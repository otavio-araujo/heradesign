<x-utils.badge type='{{ $getState()->id }}' message='{{ $getState()->nome }}'>
    
    <div>
        <select @change="open = ! open" name="status_{{ $getRecord()->id }}" id="status_{{ $getRecord()->id }}" wire:change='statusChange({{ $getRecord()->id }}, $event.target.value)' class="block p-2 mb-6 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @foreach (App\Models\ProposalStatus::all() as $status)
                <option @if ($status->id === $getState()->id) selected @endif value="{{ $status->id }}"><span>{{ $status->nome }}</span></option>
            @endforeach 
        </select>
    </div>
    
</x-utils.badge>

