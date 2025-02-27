<?php

use App\Models\User;
use Livewire\Volt\Component;
use App\Models\Invoice;
use App\Models\Business;
use Mary\Traits\Toast;
use App\Mail\SendReceipt;
use App\Services\PdfService;
use Illuminate\Support\Facades\Mail;

new class extends Component {
    use Toast;

    public Invoice $invoice;
    public int $percentagePaid = 0;
    public float $totalPaidInput = 0.0;
    public $openTotalPaidPopUp;

    public function mount(Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }

    public function render(): mixed
    {
        /* @var User $userId */
        $userId = auth()->user()->id;

        $this->percentagePaid = ($this->invoice->total_paid / $this->invoice->total_amount) * 100;

        $matchingBusinesses = Business::whereIn('user_id', [$userId])->get();

        if ($this->invoice === null || empty($matchingBusinesses)) {
            redirect(route('dashboard'));
        }

        return view('livewire.pages.invoice.invoice-detail', ['invoice' => $this->invoice])->layout('layouts.app');
    }

    public function sendMail(): void
    {
        //add a once a day limit on attempt of receipt sending for each receipt
        //prevent double send.
        $pdfService = new PdfService();
        $pdfContent = $pdfService->generate($this->invoice);
        try {
            Mail::to('charles.aoloyede@gmail.com')->send(new SendReceipt($this->invoice, $pdfContent));
        } catch (\Throwable $th) {
            $this->warning('Unable to send Email', css: 'bg-red-500 text-white');
        }
        $this->success(title: 'Invoice sent Successfully!', css: 'bg-green-500 text-white');
    }

    public function testMail(): void
    {
        $this->redirectRoute('sendMail');
    }

    public function markAsPaid(): void
    {
        $this->invoice->update(['total_paid' => $this->invoice->total_amount, 'payment_status' => 'paid']);
    }

    public function setTotalPaid(): void
    {
        if ($this->totalPaidInput > $this->invoice->total_amount) {
            $this->warning('Input is greater than total!', css: 'bg-red-500 text-white');
            $this->openTotalPaidPopUp = false;
            return;
        }

        $this->invoice->update(['total_paid' => $this->totalPaidInput, 'payment_status' => 'unpaid']);
        $this->totalPaidInput = 0.0;
        $this->openTotalPaidPopUp = false;

        if ($this->invoice->total_amount == $this->invoice->total_paid) {
            $this->markAsPaid();
            return;
        }
    }
}; ?>


<div class="container mx-auto py-6">
    <!-- Invoice Card -->

    <x-mary-card class="bg-white shadow-lg rounded-lg p-6">

        {{-- Set invoice Dialog --}}
        <x-mary-modal wire:model="openTotalPaidPopUp" class="backdrop-blur">
            <h3 class="text-center font-bold">Set Amount paid</h3>
            <x-mary-form wire:submit="setTotalPaid">
                <x-mary-input label="Amount" wire:model="totalPaidInput" money hint="Enter the value of total paid" />

                <x-slot:actions>
                    <x-mary-button label="Cancel" @click="$wire.openTotalPaidPopUp = false" />
                    <x-mary-button label="Save" class="btn-primary" type="submit" spinner="setTotalPaid" />
                </x-slot:actions>
            </x-mary-form>

        </x-mary-modal>


        <x-slot:title>
            <h1 class="text-2xl font-semibold mb-4">Invoice Details</h1>
            <div class="md:flex my-3 gap-4">
                <x-mary-button label="Download Receipt" external icon="o-arrow-down-tray"
                    class="mb-2 md:mb-0 bg-purple-700 text-white" spinner
                    onclick="window.location.href='{{ route('download', ['invoice' => $invoice]) }}'" />
                <x-mary-button label="Send Receipt" external icon="o-paper-airplane" class=" bg-purple-700 text-white"
                    wire:click="sendMail" spinner />
                <x-mary-button label="Test Mail" external icon="o-eye" class="bg-purple-700 text-white"
                    wire:click='testMail' spinner />
                <x-mary-button label="Set total paid" external icon="o-check" class="bg-purple-700 text-white"
                    @click="$wire.openTotalPaidPopUp = true" />
                <x-mary-button label="Mark as Paid" external icon="o-check" class="bg-purple-700 text-white"
                    wire:click='markAsPaid' spinner />

            </div>
        </x-slot:title>
        <!-- Invoice Information -->

        <div class="grid
                    grid-cols-1 md:grid-cols-2 gap-6">

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

                @if ($invoice->total_amount > 0 && isset($percentagePaid) && is_numeric($percentagePaid))
                    <x-mary-progress-radial value="{{ $percentagePaid }}" max='100'
                        class="mt-3 bg-white text-purple-700 border-4 border-purple-600 " />
                @else
                    <p>Percentage paid not available.</p>
                @endif

            </div>
        </div>
        <hr class="mt-5" />

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
