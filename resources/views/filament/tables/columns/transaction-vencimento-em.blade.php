<x-utils.simple-badge type='pink'>
    
    {{ $getRecord()->conta_pagar_id === NULL ? Carbon\Carbon::make($getRecord()->contaReceber->vencimento_em)->format('d/m/Y') : Carbon\Carbon::make($getRecord()->contaPagar->vencimento_em)->format('d/m/Y') }}
    
</x-utils.simple-badge>