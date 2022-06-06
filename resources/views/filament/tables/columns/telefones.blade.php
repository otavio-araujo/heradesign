<div>
    @if ($getRecord()->whatsapp != null)
    <div class="flex items-center">
        <x-heroicon-o-chat-alt class="h-4 w-4 mr-1 text-teal-500" />{{ $getRecord()->whatsapp }}
    </div>
    @endif
    
    @if ($getRecord()->telefone != null)
    <div class="flex items-center">
        <x-heroicon-o-phone class="h-4 w-4 mr-1" />{{ $getRecord()->telefone }}
    </div>
    @endif

    @if ($getRecord()->celular != null)
    <div class="flex items-center">
        <x-heroicon-o-device-mobile class="h-4 w-4 mr-1" />{{ $getRecord()->celular }}
    </div>
    @endif
    
</div>