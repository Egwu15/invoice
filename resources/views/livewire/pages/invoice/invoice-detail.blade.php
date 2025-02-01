<?php

use Livewire\Volt\Component;
use App\Models\Invoice;
use App\Models\Business;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;
    private $invoice;

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function render(): mixed
    {
        $userId = auth()->user()->id;

        $matchingBusinesses = Business::whereIn('user_id', [$userId])->get();

        if ($this->invoice === null || empty($matchingBusinesses)) {
            redirect(route('dashboard'));
        }

        return view('livewire.pages.invoice.invoice-detail', ['invoice' => $this->invoice])->layout('layouts.app');
    }

    // public function deleteCustomer(Customer $customer)
    // {
    //     if ($customer->user_id != Business::select()) {
    //         session()->flash('error', 'Unable to delete this account');
    //         return;
    //     }
    //     $customer->delete();
    // }
}; ?>


<div class="container mx-auto py-6">
    <!-- Invoice Card -->

    <x-mary-card class="bg-white shadow-lg rounded-lg p-6">



        <x-slot:title>
            <h1 class="text-2xl font-semibold mb-4">Invoice Details</h1>
            <div class="md:flex my-3 gap-4">
                <x-mary-button label="Download Receipt" external icon="o-arrow-down-tray" class="mb-2 md:mb-0"/>
                <x-mary-button label="Send Receipt" external icon="o-paper-airplane" />
                <x-mary-button label="View Receipt" external icon="o-eye" />
            </div>
        </x-slot:title>
        <!-- Invoice Information -->

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-medium">Invoice Number:</h2>
                <p>{{ $invoice->invoice_number }}</p>
            </div>
            <div>
                <h2 class="text-lg font-medium">Status:</h2>
                <p>{{ $invoice->is_sent ? 'Sent' : 'Not Sent' }}</p>
            </div>
            <div>
                <h2 class="text-lg font-medium">Customer:</h2>
                <p>{{ $invoice->customer->name ?? 'N/A' }}</p>
            </div>
            <div>
                <h2 class="text-lg font-medium">Business:</h2>
                <p>{{ $invoice->business->name ?? 'N/A' }}</p>
            </div>
            <div>
                <h2 class="text-lg font-medium">Due Date:</h2>
                <p>{{ $invoice->due_date }}</p>
            </div>
            <div>
                <h2 class="text-lg font-medium">Total Amount:</h2>
                <p>{{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}</p>
            </div>
            <div>
                <h2 class="text-lg font-medium">Total Paid:</h2>
                <p>{{ $invoice->currency }} {{ number_format($invoice->total_paid, 2) }}</p>
            </div>
            <div>
                <h2 class="text-lg font-medium">Tax Rate:</h2>
                <p>{{ $invoice->tax_rate }}%</p>
            </div>
            <div>
                <h2 class="text-lg font-medium">Payment Status:</h2>

                @if ($invoice->total_amount > 0)
                    <div>
                        <progress-bar :value="{{ ($invoice->total_paid / $invoice->total_amount) * 100 }}"
                            max="100" class="progress"></progress-bar>
                        <p class="mt-2">
                            {{ ucfirst($invoice->payment_status) }}
                            ({{ number_format(($invoice->total_paid / $invoice->total_amount) * 100, 2) }}%)
                        </p>
                    </div>
                @endif
            </div>
        </div>
        <hr class="mt-5"/>

        <!-- Invoice Items Table -->
        <h2 class="text-xl font-semibold mt-6 mb-4">Invoice Items</h2>
        <div class="overflow-x-auto">
            <table class="table table-zebra-zebra">
                <thead>
                    <tr class="bg-gray-100 text-sm text-gray-800">
                        <th class="border border-gray-300 px-4 py-2">
                            <h2>Image</h2>
                        </th>
                        <th class="border border-gray-300 px-4 py-2">Description</th>
                        <th class="border border-gray-300 px-4 py-2">Price</th>
                        <th class="border border-gray-300 px-4 py-2">Quantity</th>
                        <th class="border border-gray-300 px-4 py-2">Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->invoiceItems as $item)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="Item Image"
                                        class="w-12 h-12 object-cover">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $item->description }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $invoice->currency }}
                                {{ number_format($item->price, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $item->quantity }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $item->discount_id ? 'Discount Applied' : 'No Discount' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-mary-card>
</div>
