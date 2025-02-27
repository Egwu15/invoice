<?php

use Livewire\Volt\Component;
use App\Models\ItemType;
use App\Models\DiscountType;
use App\Models\Item;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Str;
use Mary\Traits\Toast;
use Illuminate\Support\Collection;

new class extends Component {
    use Toast;
    public $itemTypes;
    public $discountTypes;
    public $dueDate;
    public $invoiceNumber = '';
    public $totalAmount = 0;
    public Collection $customers;
    public $searchTerm = '';
    public $productSearchTerm = '';
    public $invoiceItems = [];
    public $selectedInvoiceItems = [];
    public bool $openItemModal = false;
    public int $contact;
    public $selectedDiscountType;
    public $selectedDiscountAmount;
    public $currency;
    public $taxRate = 7;

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
    public bool $setPaymentModal = false;

    public function mount(): void
    {
        $this->itemTypes = ItemType::all();
        $this->discountTypes = DiscountType::all();
        $this->invoiceNumber = substr(Str::uuid(), 0, 6);
        $this->customers = Customer::all();
        $this->invoiceItems = Item::all();
        $this->currency = $this->currencies[0]['name'];
    }
    public function render(): mixed
    {
        return view('livewire.pages.invoice.create-invoice')->layout('layouts.app');
    }

    public function rules(): array
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
    public function searchCustomers($value): void
    {
        $this->searchTerm = $value;
        if (!empty($this->searchTerm)) {
            $this->customers = Customer::select('id', 'name')
                ->where('name', 'like', "%{$this->searchTerm}%")
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

        // Create a new invoice record

        $contactCollection = Customer::where('id', $this->contact)->exists();

        if (!$contactCollection) {
            $this->warning('Contact not found', css: 'bg-red-500 text-white');
            return;
        }

        $isInvoiceNumberUsed = Invoice::where('invoice_number', $this->invoiceNumber)->exists();

        if ($isInvoiceNumberUsed) {
            $this->warning('Invoice number Exists', css: 'bg-red-500 text-white');
            return;
        }


        $invoice = new Invoice();
        $invoice->fill([
            'invoice_number' => $this->invoiceNumber,
            'due_date' => $this->dueDate,
            'total_amount' => $this->totalAmount,
            'total_paid' => 0,
            'tax_rate' => $this->taxRate ?? 0,
            'payment_status' => 'pending',
            'customer_id' => $this->contact,
            'currency' => $this->currency,
            'business_id' => auth()->user()->business->id,
            'discount_id' => $this->selectedDiscountType?->id ?? null,
        ]);

        // Save the invoice
        $invoice->save();


        // Save associated invoice items
        foreach ($this->selectedInvoiceItems as $item) {

            $invoiceItem = new InvoiceItem();
            $invoiceItem->fill([
                'invoice_id' => $invoice->id,
                'id' => $item['id'],
                'description' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'image' => Item::find($item['id'])->only(['image'])['image'],

            ]);
            $invoiceItem->save();
        }

        // Clear selected items
        $this->selectedInvoiceItems = [];

        // Reset form fields
        $this->invoiceNumber = substr(Str::uuid(), 0, 6);
        $this->dueDate = null;
        $this->totalAmount = 0;
        $this->taxRate = 0;
        $this->currency = $this->currencies[0];

        $this->success(title: 'Invoice created Successfully', css: 'bg-green-500 text-white');
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
                    <x-mary-choices icon="o-users" label="Contact" wire:model="contact" :options="$customers"
                        placeholder="Search ..." single searchable class="w-full border-gray-500" />


                </div>
                <x-mary-collapse>
                    <x-slot:heading>
                        Discount, Tax and Currency
                    </x-slot:heading>
                    <x-slot:content>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <x-mary-select label="Discount Type" icon="o-user" :options="$discountTypes"
                                option-label="type_name" class="border-gray-500" wire:model="selectedDiscountType" />
                            <x-mary-input wire:model="selectedDiscountAmount" label="Discount Amount"
                                class="border-gray-500" />
                            <x-mary-input wire:model="taxRate" label="Tax Rate" class="border-gray-500" />
                            <x-mary-select label="Currency" icon="o-user" :options="$currencies" wire:model="currency" option-value="name"
                                class="border-gray-500" />
                        </div>
                    </x-slot:content>
                </x-mary-collapse>

                <div>

                    {{-- product Modal --}}


                    <x-mary-modal wire:model="openItemModal" class="backdrop-blur">
                        <div>

                            <input type="text" placeholder="Search Items" id="search"
                                wire:model.debounce.live="productSearchTerm"
                                class="w-full border-gray-300 rounded-md shadow-sm my-4 p-3 focus:border-none outline-none">
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




                {{-- selected invoice items --}}
                <div id="items-container" class="mt-4 ">
                    @foreach ($selectedInvoiceItems as $index => $item)
                        <x-mary-list-item :item="$selectedInvoiceItems" class="">

                            <x-slot:value>
                                <h5 wire:model="selectedInvoiceItems.{{ $index }}.name"
                                    class="rounded-md shadow-sm border-none">
                                    {{ $selectedInvoiceItems[$index]['name'] }}
                                </h5>
                            </x-slot:value>
                            <x-slot:sub-value class="flex ">
                                <x-mary-input type="number" label="Quantity"
                                    wire:model="selectedInvoiceItems.{{ $index }}.quantity" min="1"
                                    class=" border-gray-300 rounded-md shadow-sm border md:mr-2"
                                    wire:change="updateTotalAmount" />

                                <x-mary-input type="number" label="Price"
                                    wire:model="selectedInvoiceItems.{{ $index }}.price" min="0"
                                    class=" border-gray-300 rounded-md shadow-sm border md:ml-2"
                                    wire:change="updateTotalAmount" />
                            </x-slot:sub-value>

                            <x-slot:actions class="flex  x">
                                <div class=" justify-end">
                                    <x-mary-button icon="o-trash" class="text-red-500"
                                        wire:click="removeItem({{ $index }})" spinner />
                                </div>
                            </x-slot:actions>
                        </x-mary-list-item>
                    @endforeach
                </div>
                <div class="flex justify-center p-4">
                    <x-mary-button type="button" icon="o-plus-circle" class="" @click="$wire.openItemModal = true">
                        Add Item
                    </x-mary-button>
                </div>



                <x-slot:actions>
                    <x-mary-button label="Save Invoice" class="w-full px-6 btn bg-primary text-white" type="submit" spinner="save"
                        @click="$wire.save()" />
                </x-slot:actions>

            </x-mary-form>
        </div>



        <script>
            function invoiceForm() {
                return {
                    invoiceItems: @entangle('invoiceItems'),
                    selectedInvoiceItems: @entangle('selectedInvoiceItems'),
                };
            }
        </script>

    </div>
</div>
