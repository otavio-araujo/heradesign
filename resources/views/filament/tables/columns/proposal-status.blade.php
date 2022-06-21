<div class="px-3">
    <div>
        <select name="status_{{ $getRecord()->id }}" id="status_{{ $getRecord()->id }}" wire:change='statusChange({{ $getRecord()->id }}, $event.target.value)' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @foreach (App\Models\ProposalStatus::all() as $status)
                <option @if ($status->id === $getState()->id) selected @endif value="{{ $status->id }}">{{ $status->nome }}</option>
            @endforeach 
        </select>
    </div>
</div>