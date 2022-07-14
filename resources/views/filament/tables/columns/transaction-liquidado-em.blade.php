<x-utils.simple-badge type='default'>
    
    {{ $getRecord()->conta_pagar_id === NULL ? Carbon\Carbon::make($getRecord()->contaReceber->liquidado_em)->format('d/m/Y') : Carbon\Carbon::make($getRecord()->contaPagar->liquidado_em)->format('d/m/Y') }}
    
</x-utils.simple-badge>