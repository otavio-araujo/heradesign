<div class="text-xs">
    {{ $getRecord()->conta_pagar_id === NULL ? $getRecord()->contaReceber->descricao : $getRecord()->contaPagar->descricao }}
</div>