<?php

use Livewire\Volt\Component;
use App\Models\Item;
use App\Models\Business;
use App\Livewire\Forms\ItemForm;
use App\Models\ItemType;
use App\Models\DiscountType;

new class extends Component {
    private Business $business;
    public Item $item;
    public ItemForm $form;
    public $itemTypes;
    public $discountTypes;

    public function mount(Item $item)
    {
        $this->item = $item;
        $this->business = auth()->user()->business;
        $this->itemTypes = ItemType::all();
        $this->discountTypes = DiscountType::all();
        if ($this->item->business_id != $this->business->id) {
            return abort(403);
        }
        // $this->form = new ItemForm();x
    }

    public function render(): mixed
    {
        $this->form->setItem($this->item);
        return view('livewire.pages.item.edit-item')->layout('layouts.app');
    }

    public function update(): void
    {
        $this->form->createItem();
        $businessId = Business::where('user_id', auth()->id())->first();
        $this->item->update($this->form->toArray());
        $this->form->reset();
        session()->flash('message', 'Item updated successfully');
        redirect()->route('item.view');
    }
}; ?>

<div>
    <form wire:submit='update' class=" flex items-center justify-center px-5 py-14">
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

                    <button class="btn btn-neutral w-full max-w-lg mt-6">Update Item</button>
                </div>
    </form>
</div>
