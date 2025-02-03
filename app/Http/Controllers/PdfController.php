<?php

namespace App\Http\Controllers;

use App\Mail\SendReceipt;
use Illuminate\Http\Request;
use App\Services\PdfService;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;

class PdfController extends Controller
{
    public function download(Request $request)
    {
        $invoiceId = $request->input('invoice');
        $invoice = Invoice::with(['business', 'customer'])->findOrFail($invoiceId);
        if (!$invoice) abort(404);
        $pdfService = new PdfService();
        return $pdfService->download($invoice);
    }

    public function sendMail(Request $request)
    {
        $invoice = Invoice::with(['business', 'customer'])->find(1);
        // $pdfService = new PdfService();
        // $pdfContent =  $pdfService->generate($invoice);
        return view('mail.invoice.invoice-sent', ['invoice' => $invoice]);
        // Mail::to('egwutedd@gmail.com')->send(new SendReceipt($invoice, $pdfContent));
    }
}
