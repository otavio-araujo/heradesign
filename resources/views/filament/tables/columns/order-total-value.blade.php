<div>

    R${{ number_format($getRecord()->proposal->headboards->sum('valor_total') + $getRecord()->proposal->proposalItems->sum('valor_total') , 2, ',', '.')  }}
</div>