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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<div class="min-h-screen py-8 flex flex-col justify-center sm:py-12">
    <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow-xl rounded-lg sm:rounded-3xl sm:p-20">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-10">
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
            <div class="md:flex justify-between mb-10 ">
                <div class="md:mb-2 mb-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">From:</h3>
                    <p class="text-sm text-gray-600">{{ $invoice->business->name }}</p>
                    <p class="text-sm text-gray-600">{{ $invoice->business->address }}</p>
                    <p class="text-sm text-gray-600">{{ $invoice->business->phone_number }}</p>
                    <p class="text-sm text-gray-600">{{ $invoice->business->email }}</p>
                </div>
                <div>
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
                        ${{ number_format($invoice->total_amount - ($invoice->total_amount * $invoice->tax_rate) / 100) }}
                    </p>
                    <p class="text-sm text-gray-600 mb-1">Tax ({{ $invoice->tax_rate }}%):
                        ${{ number_format(($invoice->total_amount * $invoice->tax_rate) / 100) }}
                    </p>
                    <p class="text-lg font-bold text-gray-800">Total:
                        ${{ number_format($invoice->total_amount, 2) }}
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

            <!-- Action Buttons -->
            <div class="flex justify-center space-x-4">
                <button wire:click="printInvoice"
                    class="flex items-center px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 transform hover:scale-105">
                    Print
                </button>
                <button wire:click="downloadInvoice"
                    class="flex items-center px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-all duration-200 transform hover:scale-105">
                    Download
                </button>
                <button wire:click="emailInvoice"
                    class="flex items-center px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50 transition-all duration-200 transform hover:scale-105">
                    Email
                </button>
            </div>
        </div>
    </div>
</div>

</html>
