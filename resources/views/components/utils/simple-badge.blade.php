@props(['type' => 'default', 'message' => ''])

@if ($type === 'default')
    @php
        $classes = 'bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800';
    @endphp 
@endif

@if ($type === 'dark')
    @php
        $classes = 'bg-gray-100 text-gray-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300';
    @endphp
@endif

@if ($type === 'indigo')
    @php
        $classes = 'bg-indigo-100 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-indigo-200 dark:text-indigo-900';
    @endphp
@endif

@if ($type === 'yellow')
    @php
        $classes = 'bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900';
    @endphp
@endif

@if ($type === 'pink')
    @php
        $classes = 'bg-pink-100 text-pink-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-pink-200 dark:text-pink-900';
    @endphp
@endif

@if ($type === 'red' or $type === 'DESPESAS')
    @php
        $classes = 'bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900';
    @endphp
@endif

@if ($type === 'green' or $type === 'RECEITAS')
    @php
        $classes = 'bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900';
    @endphp
@endif


 
<div>
    <span class="{{ $classes }}">{{ $slot }}</span>
</div>