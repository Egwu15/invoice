<?php

use Livewire\Volt\Component;
use App\Models\Customer;

new class extends Component {
    public function render(): mixed
    {

        $customers = Customer::where('business_id', auth()->user()->business->id)->paginate(10);
        return view('livewire.pages.customer.view-customer', ['customers' => $customers])->layout('layouts.app');
    }

    public function deleteCustomer(Customer $customer)
    {
        if ($customer->user_id != auth()->user()->id) {
            session()->flash('error', 'Unable to delete this account');
            return;
        }
        $customer->delete();
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Customers
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ customer: null, showModal: false }">


        {{-- Dialog --}}
        <div x-show="showModal">
            <dialog id="my_modal_1" class="modal" :class="showModal && 'modal-open'">
                <div class="modal-box">
                    <h3 class="text-lg font-bold text-red-500 text-center">Delete?</h3>
                    <p class="py-4 text-center">Are you sure you want to delete this contact?</p>
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

                @if ($customers->isEmpty())
                    <x-empty-state title="No customers yet" subTitle="Add a customer to get started">
                        <a href="{{ route('customer.create') }}" class="btn outline outline-1" wire:navigate>
                            Add Customer
                        </a>
                    </x-empty-state>
                @endif



                <div class="p-6 text-gray-900 {{ $customers->isEmpty() ? 'hidden' : '' }}">
                    <div class="flex justify-end pb-3">
                        <a href="{{ route('customer.create') }}" class="btn btn-neutral outline outline-1"
                            wire:navigate>
                            Add Customer
                        </a>
                    </div>


                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Addres</th>
                                    <th>Date added</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($customers as $customer)
                                    <tr>
                                        <th>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                                        </th>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->address }}</td>
                                        <td>{{ $customer->addedAt() }}</td>
                                        <td>
                                            <a href="{{ route('customer.edit', ['customer' => $customer->id]) }}"
                                                class="btn btn-sm btn-neutral outline mr-1" wire:navigate>Edit</a>
                                            <button class="btn btn-sm btn-danger outline outline-1"
                                                x-on:click="customer = '{{ $customer->id }}'; showModal = true;">
                                                Delete
                                            </button>
                                    </tr>
                                @endforeach

                                </tr>
                            </tbody>
                        </table>


                    </div>
                    <div class="mt-10 text-center">{{ $customers->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
