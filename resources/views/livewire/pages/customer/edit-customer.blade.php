<?php

namespace Livewire;

use Livewire\Volt\Component;
use App\Models\Customer;
use App\Livewire\Forms\CustomerForm;

new class extends Component {
    public Customer $customer;
    public CustomerForm $form;

    public function mount(Customer $customer)
    {
        $this->form->setCustomer($customer);
    }

    public function render(): mixed
    {
        return view('livewire.pages.customer.edit-customer')->layout('layouts.app');
    }

    public function edit(): void
    {
        $this->form->validate();
        $this->customer->update($this->form->all());
        session()->flash('success', 'Customer updated successfully.');
        $this->redirect(route('customer.view', absolute: false), navigate: true);
    }
}; ?>


<div>


    <form wire:submit.prevent='edit' class="h-screen md:h-[80vh] flex items-center justify-center px-5">


        <div class="text-center w-full">
            <h1 class="font-bold text-xl">Edit your customer details</h1>
            <div class=" my-3 ">

                <input wire:model.defer='form.name' id="name" type="text" placeholder="Name"
                    class="input input-bordered w-full max-w-lg mt-3" />
                <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
            </div>
            <div class=" my-3 ">
                <input wire:model='form.email' id="email" type="text" placeholder="Email"
                    class="input input-bordered w-full max-w-lg" value="{{ $customer->email }}" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>
            <div class=" my-3 ">
                <input wire:model='form.phone' id="phone" type="text" placeholder="Phone Number"
                    class="input input-bordered w-full max-w-lg" value="{{ $customer->phone }}" />
                <x-input-error :messages="$errors->get('form.phone')" class="mt-2" />
            </div>
            <div class=" my-3 ">
                <input wire:model='form.address' id="address" type="text" placeholder="Address"
                    class="input input-bordered w-full max-w-lg" value="{{ $customer->address }}" />
                <x-input-error :messages="$errors->get('form.address')" class="mt-2" />
            </div>
            <div class=" my-3 ">
                <textarea wire:model='form.note' id="note" type="text" placeholder="Note to self"
                    class="textarea textarea-bordered w-full max-w-lg" value="{{ $customer->note }}"></textarea>
                <x-input-error :messages="$errors->get('form.note')" class="" />
            </div>

            <button class="btn btn-neutral w-full max-w-lg">
                Update
                <div wire:loading>
                    Loading...
                </div>
            </button>

        </div>
    </form>
</div>
