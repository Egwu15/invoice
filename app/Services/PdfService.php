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
            // $this->debugNonUtf8Characters($invoice);
            $pdf = Pdf::loadView('livewire.pages.invoice.invoiceTemplates.template1', ['invoice' => $invoice]);
            $pdf->render();
            return  $pdf->download('invoice.pdf');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    private function debugNonUtf8Characters($data)
    {
        array_walk_recursive($data, function ($value, $key) {
            if (is_string($value) && !mb_check_encoding($value, 'UTF-8')) {
                dd("Non-UTF-8 character found in key: $key, value: $value\n");
            }
        });
    }
}
