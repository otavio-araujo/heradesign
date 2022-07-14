<x-utils.simple-badge type="{{ $getRecord()->conta_pagar_id === NULL ? 'green' : 'red' }}">

    {{ $getRecord()->conta_pagar_id === NULL ? 'ENTRADA' : 'SAÍDA' }}
    
</x-utils.simple-badge>