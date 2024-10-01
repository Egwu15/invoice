<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\CustomerForm;
use App\Models\Customer;

new class extends Component {
    public CustomerForm $form;

    public function render(): mixed
    {
        return view('livewire.pages.customer.create-customer-form')->layout('layouts.app');
    }

    public function save(): void
    {
        $this->form->createCustomer();

        Customer::create(array_merge($this->form->all(), ['user_id' => auth()->user()->id]));
        $this->reset();
        session()->flash('success', 'Customer Added successfully.');
        $this->redirect(route('customer.view', absolute: false), navigate: true);
    }
}; ?>

<form wire:submit='save' class="h-screen md:h-[80vh] flex items-center justify-center px-5">
    <div class="text-center w-full">
        <h1 class="font-bold text-xl">Add a customer to your business</h1>
        <div class=" my-3 ">
            <input wire:model='form.name' id="name" type="text" placeholder="Name"
                class="input input-bordered w-full max-w-lg mt-3 " />
            <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <input wire:model='form.email' id="email" type="text" placeholder="Email"
                class="input input-bordered w-full max-w-lg" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <input wire:model='form.phone' id="phone" type="text" placeholder="Phone Number"
                class="input input-bordered w-full max-w-lg" />
            <x-input-error :messages="$errors->get('form.phone')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <input wire:model='form.address' id="address" type="text" placeholder="Address"
                class="input input-bordered w-full max-w-lg" />
            <x-input-error :messages="$errors->get('form.address')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <textarea wire:model='form.note' id="note" type="text" placeholder="Note to self"
                class="textarea textarea-bordered w-full max-w-lg"></textarea>
            <x-input-error :messages="$errors->get('form.note')" class="" />
        </div>

        <button class="btn btn-neutral w-full max-w-lg">Create customer</button>
    </div>
</form>
