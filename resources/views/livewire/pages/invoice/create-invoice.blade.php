<?php

use Livewire\Volt\Component;
use App\Models\ItemType;
use App\Models\DiscountType;
use App\Models\Item;
use App\Livewire\Forms\ItemForm;
use App\Models\Business;
use App\Models\Customer;
use Illuminate\Support\Str;

new class extends Component {
    public $itemTypes;
    public $discountTypes;
    public $dueDate;
    public $invoiceNumber = '';
    public $totalAmount = 0;
    public $customers = [];
    public $searchTerm = '';
    public $productSearchTerm = '';
    public $invoiceItems = [];
    public $selectedInvoiceItems = [];
    public bool $openItemModal = false;
    public bool $openContactModal = false;
    public Customer $contact;
    public $selectedDiscountType;
    public $selectedDiscountAmount;
    public $currency;
    public $taxRate;

    public $currencies = [
        [
            'id' => 1,
            'name' => 'Naira',
        ],
        [
            'id' => 2,
            'name' => 'Dollars',
        ],
    ];

    public function mount(): void
    {
        $this->itemTypes = ItemType::all();
        $this->discountTypes = DiscountType::all();
        $this->invoiceNumber = substr(Str::uuid(), 0, 6);
        $this->customers = Customer::select('id', 'name')->get();
        $this->invoiceItems = Item::all();
        $this->currency = $this->currencies[0];
    }
    public function render(): mixed
    {
        return view('livewire.pages.invoice.create-invoice')->layout('layouts.app');
    }

    public function rules()
    {
        return [
            'dueDate' => ['required', 'date'],
            'contact' => ['required'],
            'selectedDiscountType' => ['nullable'],
            'selectedDiscountAmount' => ['nullable', 'numeric'],
            'taxRate' => ['nullable', 'numeric', 'between:0,100'],
            'currency' => ['required'],
            'selectedInvoiceItems.*.description' => ['required'],
            'selectedInvoiceItems.*.quantity' => ['required', 'min:1', 'integer'],
            'selectedInvoiceItems.*.price' => ['required', 'numeric', 'min:0'],
        ];
    }
    public function searchCustomers($value)
    {
        $this->searchTerm = $value;
        if (!empty($this->searchTerm)) {
            $this->customers = Customer::select('id', 'name')
                ->where('name', 'like', '%' . $this->searchTerm . '%')
                ->get();
        } else {
            $this->customers = Customer::select('id', 'name')->get();
        }
    }

    public function updatedSearchTerm($value)
    {
        $this->searchCustomers($value);
    }

    public function updatedProductSearchTerm()
    {
        if (!empty($this->productSearchTerm)) {
            $this->invoiceItems = Item::where('name', 'like', '%' . $this->productSearchTerm . '%')->get();
        } else {
            $this->invoiceItems = Item::all();
        }
    }

    public function addItemToSelectedItems($itemId): void
    {
        $item = Item::firstWhere('id', $itemId);

        if ($item && !collect($this->selectedInvoiceItems)->contains('id', $itemId)) {
            $this->selectedInvoiceItems[] = [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'price' => $item->amount,
                'quantity' => 1,
            ];

            $this->updateTotalAmount();
        }
    }

    public function updateTotalAmount(): void
    {
        $this->totalAmount = collect($this->selectedInvoiceItems)->reduce(fn($sum, $item) => $sum + $item['price'] * $item['quantity'], 0);
    }

    public function removeItem($index): void
    {
        array_splice($this->selectedInvoiceItems, $index, 1);
        $this->updateTotalAmount();
    }

    public function save(): void
    {
        $this->validate();
    }
}; ?>



<div>
    <x-mary-modal wire:model="openContactModal" class="backdrop-blur" no-close>
        <div class="mb-5">Press `ESC`, click outside or click `CANCEL` to close.</div>
        <x-mary-button label="Cancel" @click="$wire.openContactModal = false" />
    </x-mary-modal>


    <div class="container mx-auto py-8 md:px-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4">Invoice #{{ $invoiceNumber }}</h1>

            <!-- Invoice Details -->

            <x-mary-form x-data="invoiceForm()" wire:submit="save" no-separator>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-mary-datepicker label="Due Date" wire:model="dueDate" icon="o-calendar"
                        class="border-gray-500" />


                    <x-mary-input readonly value="{{ $totalAmount }}" label="Total amount" class="border-gray-500" />

                    <x-mary-select label="Discount Type" icon="o-user" :options="$discountTypes" option-label="type_name"
                        class="border-gray-500" wire:model="selectedDiscountType" />

                    <x-mary-input wire:model="selectedDiscountAmount" label="Discount Amount" class="border-gray-500" />


                    <x-mary-input wire:model="taxRate" label="Tax Rate" class="border-gray-500" />

                    <x-mary-select label="Currency" icon="o-user" :options="$currencies" wire:model="currency"
                        class="border-gray-500" />

                    <x-mary-choices-offline icon="o-users" label="Contact" wire:model="contact" :options="$customers"
                        placeholder="Search ..." single searchable class="w-full border-gray-500" />
                </div>






                <div>

                    {{-- customer select modal --}}
                    <div>
                        <x-mary-modal wire:model="openContactModal" class="modal">
                            <input type="text" placeholder="Search contacts" id="searchContact"
                                wire:model.debounce.live="searchTerm"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 my-4">
                            @foreach ($customers as $customer)
                                <div
                                    x-on:click = "selectCustomer('{{ $customer->id }}', '{{ $customer->name }}'); $wire.openContactModal = false;">
                                    <p class="bg-gray-100 w-full my-2 px-2 py-2 rounded-md cursor-pointer"
                                        value="{{ $customer->id }}">
                                        {{ $customer->name }}</p>
                                </div>
                            @endforeach
                            <div class="text-center">
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    href="{{ route('customer.create') }}" wire:navigate>
                                    {{ __('Add Customer') }}
                                </a>
                            </div>

                        </x-mary-modal>
                    </div>



                    {{-- product Modal --}}


                    <x-mary-modal wire:model="openItemModal" class="backdrop-blur">
                        <div>

                            <input type="text" placeholder="Search Items" id="search"
                                wire:model.debounce.live="productSearchTerm"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 my-4">
                            @foreach ($invoiceItems as $invoiceItem)
                                <div>
                                    <p class="bg-gray-100 w-full my-2 px-2 py-2 rounded-md cursor-pointer"
                                        value="{{ $invoiceItem->id }}"
                                        wire:click="addItemToSelectedItems({{ $invoiceItem->id }})">
                                        {{ $invoiceItem->name }}</p>
                                </div>
                            @endforeach



                        </div>

                    </x-mary-modal>


                </div>


                <button type="button" class="btn w-full mt-8" @click="$wire.openItemModal = true">
                    Add Item
                </button>

                {{-- selected invoice items --}}
                <div id="items-container" class="space-y-4 mt-4">
                    @foreach ($selectedInvoiceItems as $index => $item)
                        <div class="md:flex md:items-center md:space-x-3">
                            <input type="text" placeholder="Item Description" readonly
                                wire:model="selectedInvoiceItems.{{ $index }}.description"
                                class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <input type="number" placeholder="Quantity"
                                wire:model="selectedInvoiceItems.{{ $index }}.quantity" min="1"
                                class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                wire:change="updateTotalAmount">
                            <input type="number" placeholder="Price"
                                wire:model="selectedInvoiceItems.{{ $index }}.price" min="0"
                                class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 my-4"
                                wire:change="updateTotalAmount">
                            <button type="button" wire:click="removeItem({{ $index }})"
                                class="text-red-500 hover:text-red-700">Remove</button>
                        </div>
                    @endforeach
                </div>




                <x-slot:actions>
                    <x-mary-button label="Save Invoice" class="w-full px-6 btn" type="submit" spinner="save"
                        @click="$wire.save()" />
                </x-slot:actions>

            </x-mary-form>
        </div>



        <script>
            function invoiceForm() {
                return {
                    customers: [],


                    invoiceItems: @entangle('invoiceItems'),
                    selectedInvoiceItems: @entangle('selectedInvoiceItems'),


                    selectCustomer(id, name) {
                        this.selectedCustomerIndex = id;
                        this.selectedCustomerName = name;

                    },


                };
            }
        </script>

    </div>
</div>
