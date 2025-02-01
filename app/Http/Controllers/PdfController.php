<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PdfService;
use App\Models\Invoice;

class PdfController extends Controller
{
    public function index(Request $request)
    {
        $invoice = Invoice::with(['business', 'customer'])->find(1);
        // dd($invoice);
       

        $pdfService = new PdfService();
        return $pdfService->download($invoice);
    }
}
