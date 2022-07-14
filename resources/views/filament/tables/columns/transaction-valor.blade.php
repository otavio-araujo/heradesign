<x-utils.simple-badge type="{{ $getRecord()->conta_pagar_id === NULL ? 'green' : 'red' }}">

    {{-- {{ $getRecord()->conta_pagar_id === NULL ? 'R$'.number_format($getRecord()->contaReceber->valor, 2, ',', '.') : 'R$'.number_format($getRecord()->contaPagar->valor, 2, ',', '.') }} --}}
    {{ 'R$'.number_format($getState(), 2, ',', '.') }}
    
</x-utils.simple-badge>