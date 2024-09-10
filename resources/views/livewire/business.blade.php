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
        return view('livewire.business')->layout('layouts.app');
    }

    public function createBusiness(): void
    {

        $this->form->createBusiness();

        session()->flash('success', 'Business created successfully.');
        $this->redirect( route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<form wire:submit='createBusiness' class="h-screen md:h-[80vh] flex items-center justify-center">
    <div class="text-center w-full">
        <h1 class="font-bold ">Create a business for your account</h1>
        <div class=" my-3 ">
            <input wire:model='form.businessName' id="businessName" type="text" placeholder="Business name"
                class="input input-bordered w-full max-w-xs mt-3 " />
            <x-input-error :messages="$errors->get('form.businessName')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <input wire:model='form.businessType' id="businessType" type="text" placeholder="Business type"
                class="input input-bordered w-full max-w-xs" />
            <x-input-error :messages="$errors->get('form.businessType')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <input wire:model='form.businessType' id="businessType" type="text" placeholder="Business type"
                class="input input-bordered w-full max-w-xs" />
            <x-input-error :messages="$errors->get('form.businessType')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <input wire:model='form.businessType' id="businessType" type="text" placeholder="Business type"
                class="input input-bordered w-full max-w-xs" />
            <x-input-error :messages="$errors->get('form.businessType')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <input wire:model='form.businessType' id="businessType" type="text" placeholder="Business type"
                class="input input-bordered w-full max-w-xs" />
            <x-input-error :messages="$errors->get('form.businessType')" class="mt-2" />
        </div>
        <div class=" my-3 ">
            <input wire:model='form.businessType' id="businessType" type="text" placeholder="Business type"
                class="input input-bordered w-full max-w-xs" />
            <x-input-error :messages="$errors->get('form.businessType')" class="mt-2" />
        </div>
        <button class="btn btn-neutral w-full max-w-xs">Create business</button>
    </div>
</form>
