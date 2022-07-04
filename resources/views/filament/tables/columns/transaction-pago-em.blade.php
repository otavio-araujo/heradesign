<x-utils.simple-badge type='yellow'>

    {{ $getRecord()->conta_pagar_id === NULL ? Carbon\Carbon::make($getRecord()->contaReceber->pago_em)->format('d/m/Y') : Carbon\Carbon::make($getRecord()->contaPagar->pago_em)->format('d/m/Y') }}
    
</x-utils.simple-badge>