@props(['type' => 'default', 'message' => ''])

@if ($type === '1')
    @php
        $classes = 'bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800';
    @endphp 
@endif

@if ($type === '2')
    @php
        $classes = 'bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900';
    @endphp
@endif

@if ($type === '3')
    @php
        $classes = 'bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900';
    @endphp
@endif

@if ($type === '4' or $type === '5')
    @php
        $classes = 'bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900';
    @endphp
@endif
 
<div>
    <div x-data="{open: false}" x-cloak class="relative">
        <span @click="open = ! open" class="{{ $classes }} z-10 cursor-pointer">{{ $message }}</span>
        <div x-show="open" @click.outside="open = false" x-transition class="origin-top-right absolute right-0 mt-2 w-56 z-20" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            <div class="py-1 z-20">
              {{ $slot }}
            </div>
        </div>
    </div>
</div>