<?php

use Livewire\Volt\Component;
use App\Models\ItemType;
use App\Models\DiscountType;
use App\Models\Item;
use App\Livewire\Forms\ItemForm;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;
    public $itemTypes;
    public $discountTypes;
    public ItemForm $form;

    public function mount(): void
    {
        $this->itemTypes = ItemType::all();
    }
    public function render(): mixed
    {
        return view('livewire.pages.item.create-item')->layout('layouts.app');
    }

    public function save(): void
    {
        $this->form->createItem();
        $businessId = Auth::user()->business;

        Item::create(array_merge($this->form->toArray(), ['business_id' => $businessId->id]));

        $this->form->reset();
        session()->flash('message', 'Item created successfully');
        redirect()->route('item.view');
    }
}; ?>



<form wire:submit='save' class=" flex items-center justify-center px-5 py-14">
    <div class="text-center w-full  max-w-lg">
        <h1 class="font-bold text-xl mb-5">Add a Product or Service</h1>


        <div class="text-left w-full max-w-lg  text-sm">
            <label for='name'>Product Name </label>
        </div>
        <div class=" mb-3 ">
            <input wire:model='form.name' id="name" type="text" placeholder="Name of your product or service"
                class="input input-bordered w-full max-w-lg " />
            <x-input-error :messages="$errors->get('form.name')" class="mt-2 text-left" />
        </div>


        <div class="text-left w-full max-w-lg  text-sm">
            <label for='item_type_id'>Item type</label>
        </div>
        <div>
            <select wire:model='form.item_type_id' id="item_type_id"
                class="select select-bordered w-full max-w-lg text-gray-500">
                @foreach ($itemTypes as $itemType)
                    <option value="{{ $itemType->id }}">{{ $itemType->name }}</option>
                @endforeach


            </select>
        </div>

        <div class="text-left w-full max-w-lg mt-3 text-sm">
            <label for='price'>Price</label>
            <div class=" mb-3 ">
                <input wire:model='form.amount' id="amount" type="text" placeholder="Price"
                    class="input input-bordered w-full max-w-lg" />
                <x-input-error :messages="$errors->get('form.amount')" class="mt-2 text-left" />
            </div>

            <div class="text-left w-full max-w-lg text-sm">

                <div class=" mt-3 ">
                    <textarea wire:model='form.description' id="description" type="text" placeholder="Description (optional)"
                        class="textarea textarea-bordered w-full max-w-lg"></textarea>
                    <x-input-error :messages="$errors->get('form.description')" class="text-left" />
                </div>


                <label class="form-control w-full max-w-lg">
                    <div class="label">
                        <span class="label-text">Pick a file</span>
                    </div>
                    <input type="file" wire:model='form.image'
                        class="file-input file-input-bordered w-full max-w-xs" />
                    <x-input-error :messages="$errors->get('form.image')" class="text-left" />
                </label>

                <button class="btn btn-neutral w-full max-w-lg mt-6">Create Item</button>
            </div>
        </div>
    </div>
</form>
