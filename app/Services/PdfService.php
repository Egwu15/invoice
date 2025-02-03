<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Invoice;
use Illuminate\Support\Facades\Response;

class PdfService
{
    public function download($invoice)
    {
        try {
            $pdf = Pdf::loadView('livewire.pages.invoice.invoiceTemplates.template1', ['invoice' => $invoice]);
            return  $pdf->download('invoice.pdf');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function generate($invoice)
    {
        try {
            $pdf = Pdf::loadView('livewire.pages.invoice.invoiceTemplates.template1', ['invoice' => $invoice]);
            return $pdf->output(); // Returns PDF content as a string
        } catch (\Throwable $th) {
            dd($th);
        }
    }

}
