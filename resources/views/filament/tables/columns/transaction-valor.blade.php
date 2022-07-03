<x-utils.simple-badge type="{{ $getRecord()->contaReceber->planoConta->tipoConta->nome ==='RECEITAS' ? 'green' : 'red' }}">
    
    {{ 'R$'.number_format($getState(), 2, ',', '.') }}
    
</x-utils.simple-badge>