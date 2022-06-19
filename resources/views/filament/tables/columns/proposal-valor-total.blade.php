<div>
    R${{ number_format($getRecord()->headboards->sum('valor_total') + $getRecord()->proposalItems->sum('valor_total') , 2, ',', '.')  }}
</div>