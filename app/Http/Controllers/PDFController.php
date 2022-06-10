<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function pdf ()
    {
        $data = Proposal::find(1);
        // dd($proposta);
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadView('reports.proposta1', $data);

        $pdf = PDF::loadView('reports.proposta1', compact('data'));
        return $pdf->stream('PT-'.$data->id.'.pdf');
    }
}
