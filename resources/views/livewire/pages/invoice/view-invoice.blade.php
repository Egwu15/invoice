<?php

use Livewire\Volt\Component;
use App\Models\Customer;
use App\Models\Invoice;

new class extends Component {
    public function render(): mixed
    {
        $invoices = Invoice::where('business_id', auth()->user()->business->id)
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('livewire.pages.invoice.view-invoice', ['invoices' => $invoices])->layout('layouts.app');
    }

    public function deleteCustomer(Invoice $invoice)
    {
        if ($invoice->business_id != auth()->user()->business->id) {
            session()->flash('error', 'Unable to delete this invoice');
            return;
        }
        $invoice->delete();
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Invoice
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ customer: null, showModal: false }">


        {{-- Dialog --}}
        <div x-show="showModal">
            <dialog id="my_modal_1" class="modal" :class="showModal && 'modal-open'">
                <div class="modal-box">
                    <h3 class="text-lg font-bold text-red-500 text-center">Delete?</h3>
                    <p class="py-4 text-center">Are you sure you want to delete this invoice?</p>
                    <p class="text-center">This action is irreversible.</p>
                    <div class=" flex justify-center mt-3">
                        <div class="mr-6 ">
                            {{-- <button x-on:click="wire.deleteCustomer(customer); " class="btn bg-red-500 text-white">Delete</button> --}}
                            <button x-on:click="$wire.deleteCustomer(customer); showModal = false"
                                class="btn bg-red-500 text-white">
                                Delete
                            </button>
                        </div>
                        <button class="btn" x-on:click="showModal = false">Close</button>
                    </div>
                </div>
            </dialog>
        </div>

        {{-- End Dialog --}}

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                @if ($invoices->isEmpty())
                    <x-empty-state title="No invoices yet" subTitle="Add a Invoice to get started">
                        <a href="{{ route('invoice.create') }}" class="btn outline outline-1" wire:navigate>
                            Add Customer
                        </a>
                    </x-empty-state>
                @endif



                <div class="p-6 text-gray-900 {{ $invoices->isEmpty() ? 'hidden' : '' }}">
                    <div class="flex justify-end pb-3">
                        <a href="{{ route('invoice.create') }}" class="btn btn-neutral outline outline-1"
                            wire:navigate>
                            Add Invoice
                        </a>
                    </div>


                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Invoice Number</th>
                                    <th>Name</th>
                                    <th>Total</th>
                                    <th>Sent</th>
                                    <th>Due Date</th>
                                    <th>Date added</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <th>{{ ($invoices->currentPage() - 1) * $invoices->perPage() + $loop->iteration }}
                                        </th>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->customer->name }}</td>
                                        <td>{{ $invoice->total_amount }}</td>
                                        @if ($invoice->is_sent)
                                            <td> <x-mary-icon name="o-check-circle" class="w-9 h-9 text-purple-500" />
                                            </td>
                                        @else
                                            <td> <x-mary-icon name="o-x-circle" class="w-9 h-9 text-red-500" /></td>
                                        @endif

                                        <td>{{ $invoice->dueDate() }}</td>
                                        <td>{{ $invoice->addedAt() }}</td>
                                        <td>
                                            <a href="{{ route('invoice.send', ['invoice' => $invoice]) }}"
                                                class="btn btn-sm btn-neutral outline mr-1" wire:navigate>See</a>
                                            <a href="{{ route('invoice.detail', ['invoice' => $invoice]) }}"
                                                class="btn btn-sm btn-neutral outline mr-1" wire:navigate>View</a>
                                     
                                            <button class="btn btn-sm btn-danger outline outline-1"
                                                x-on:click="customer = '{{ $invoice->id }}'; showModal = true;">
                                                Delete
                                            </button>
                                    </tr>
                                @endforeach

                                </tr>
                            </tbody>
                        </table>


                    </div>
                    <div class="mt-10 text-center">{{ $invoices->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
