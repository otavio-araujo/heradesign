<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function pdf (Proposal $record)
    {
        // $data = Proposal::find($id);

        $data = $record;
        // dd($proposta);
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadView('reports.proposta1', $data);

        $pdf = PDF::loadView('reports.proposta1', compact('data'));
        return $pdf->stream('PT-'.$data->id.'.pdf');
    }
}
