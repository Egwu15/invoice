<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\BusinessForm;

new class extends Component {
    public BusinessForm $form;

    public function render(): mixed
    {
        if (!auth()->check()) {
            redirect()->route('login');
        }
        return view('livewire.business')->layout('layouts.guest');
    }

    public function createBusiness(): void
    {
        $this->form->createBusiness();

        session()->flash('success', 'Business created successfully.');
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<form wire:submit='createBusiness' class="flex items-center justify-center">
    <div class=" w-full">
        <div class="text-center font-bold text-xl mb-4">
            <h2>
                Create an account with us!
            </h2>
            <progress class="progress w-56" value="100" max="100"></progress>
        </div>
        <div class=" my-3">
            <x-input-label for="businessName" value="Business Name" class="text-start" />

            <input wire:model='form.businessName' id="businessName" type="text" placeholder="Business Name"
                class="input input-bordered w-full mb-1 mt-1 " />
            <x-input-error :messages="$errors->get('form.businessName')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <x-input-label for="businessType" value="Business Type" class="text-start" />
            <input wire:model='form.businessType' id="businessType" type="text" placeholder="Business Type"
                class="input input-bordered  w-full mb-1 mt-1" />
            <x-input-error :messages="$errors->get('form.businessType')" class="mt-2" />
        </div>
        <div class=" my-3 ">

            <x-input-label for="email" value="Business email" class="text-start" />
            <input wire:model='form.email' id="email" type="text" placeholder="Business email"
                class="input input-bordered  w-full mb-1 mt-1" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <x-input-label for="phone_number" value="phone number (optional)" class="text-start" />
            <input wire:model='form.phone_number' id="phone_number" type="text" placeholder="Phone Number"
                class="input input-bordered  w-full mb-1 " />
            <x-input-error :messages="$errors->get('form.phone_number')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <x-input-label for="address" value="Address (optional)" class="text-start" />
            <input wire:model='form.address' id="address" type="text" placeholder="Address"
                class="input input-bordered  w-full mb-1 " />
            <x-input-error :messages="$errors->get('form.address')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <x-input-label for="post_office_number" value="Post office number (optional)" class="text-start" />
            <input wire:model='form.post_office_number' id="post_office_number" type="text"
                placeholder="Post office number" class="input input-bordered  w-full mb-3 " />
            <x-input-error :messages="$errors->get('form.post_office_number')" class="mt-2" />
        </div>

        <button class="btn my-3 btn-neutral  w-full mb-1 mt-1">Create business</button>
    </div>
</form>
