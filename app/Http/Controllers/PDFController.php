<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PDFController extends Controller
{
    public function pdf ()
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('reports.proposta1');
        return $pdf->stream();
    }
}
