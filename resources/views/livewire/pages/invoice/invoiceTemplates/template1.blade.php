<?php

namespace App\Http\Livewire;

use Livewire\Volt\Component;
use App\Models\Invoice;
use App\Services\PdfService;

new class extends Component {
    public $invoiceData;
    public $invoice;

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function printInvoice()
    {
        // Logic for printing invoice
    }

    public function downloadInvoice()
    {
        $pdfService = new PdfService();
        // response()->download($pdfService->download(), 'invoice.pdf');
        // dd($file);
    }

    public function emailInvoice()
    {
        // Logic for emailing invoice
    }

    public function render(): mixed
    {
        // dd($this->invoiceData);
        return view('livewire.pages.invoice.invoiceTemplates.template1', ['invoice' => $this->invoice])->layout('layouts.app');
    }
};
?>
<html>

<head>
    <style>
        @import url('{{ public_path('css/app.css') }}');
    </style>
</head>

<body>

    <div class=" py-8 flex flex-col justify-center sm:py-12">


        <div class=" p py-10 bg-white md:mx-0 shadow-xl rounded-lg sm:rounded-3xl ">
            <div class="mx-auto w-full">
                <!-- Header Section -->
                <div class="flex items-center justify-between mb-10 w-full">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Invoice</h1>
                        <p class="text-sm text-gray-500">Issued by {{ $invoice->business->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-700">Invoice #{{ $invoice->invoice_number }}</p>
                        <p class="text-sm text-gray-500">Date: {{ $invoice->created_at }}</p>
                        <p class="text-sm text-gray-500">Due Date: {{ $invoice->due_date }}</p>
                    </div>
                </div>

                <!-- Company and Client Details -->

                <div style="display: grid;  grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                    <div class="md:mb-2 mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">From:</h3>
                        <p class="text-sm text-gray-600">{{ $invoice->business->name }}</p>
                        <p class="text-sm text-gray-600">{{ $invoice->business->address }}</p>
                        <p class="text-sm text-gray-600">{{ $invoice->business->phone_number }}</p>
                        <p class="text-sm text-gray-600">{{ $invoice->business->email }}</p>
                    </div>
                    <div class="text-right">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">To:</h3>
                        <p class="text-sm text-gray-600">{{ $invoice->customer->name }}</p>
                        <p class="text-sm text-gray-600">{{ $invoice->customer->address }}</p>
                        <p class="text-sm text-gray-600">{{ $invoice->customer->email }}</p>
                    </div>
                </div>


                <!-- Invoice Items Table -->
                <div class="overflow-x-auto mb-10">
                    <table class="w-full">
                        <thead>
                            <tr class="text-sm font-medium text-gray-700 border-b border-gray-200">
                                <th class="py-3 text-left">Description</th>
                                <th class="py-3 text-right">Qty</th>
                                <th class="py-3 text-right">Rate</th>
                                <th class="py-3 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->invoiceItems as $item)
                                <tr class="text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                                    <td class="py-4 text-left">{{ $item->description }}</td>
                                    <td class="py-4 text-right">{{ $item->quantity }}</td>
                                    <td class="py-4 text-right">${{ number_format($item->price, 2) }}</td>
                                    <td class="py-4 text-right">${{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totals Section -->
                <div class="flex justify-end mb-10">
                    <div class="text-right">
                        <p class="text-sm text-gray-600 mb-1">Subtotal:
                            ${{ number_format($invoice->total_amount) }}
                        </p>
                        <p class="text-sm text-gray-600 mb-1">Tax ({{ $invoice->tax_rate }}%):
                            ${{ number_format(($invoice->total_amount * $invoice->tax_rate) / 100) }}
                        </p>
                        <p class="text-lg font-bold text-gray-800">Total:
                            ${{ number_format($invoice->total_amount + ($invoice->total_amount * $invoice->tax_rate) / 100, 2) }}
                        </p>
                    </div>
                </div>

                <!-- Payment Terms -->
                <div class="border-t pt-8 mb-10">
                    <p class="text-sm text-gray-600 mb-1">Payment Terms: Net 30</p>
                    <p class="text-sm text-gray-600">Please make checks payable to
                        {{ $invoice->business->name }}
                    </p>
                </div>


            </div>
        </div>
    </div>
</body>

</html>
