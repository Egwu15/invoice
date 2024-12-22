<?php

use Livewire\Volt\Component;
use App\Models\ItemType;
use App\Models\DiscountType;
use App\Models\Item;
use App\Livewire\Forms\ItemForm;
use App\Models\Business;

new class extends Component {
    public $itemTypes;
    public $discountTypes;
    public ItemForm $form;

    public function mount(): void
    {
        $this->itemTypes = ItemType::all();
        $this->discountTypes = DiscountType::all();
    }
    public function render(): mixed
    {
        return view('livewire.pages.invoice.create-invoice')->layout('layouts.app');
    }

    public function save(): void
    {
        $this->form->createItem();
        $businessId = Business::where('user_id', auth()->id())->first();

        Item::create(array_merge($this->form->toArray(), ['business_id' => $businessId->id]));
        $this->form->reset();
        session()->flash('message', 'Item created successfully');
        redirect()->route('item.view');
    }
}; ?>
 {{-- 'invoice_number',
 'business_id',
 'due_date',
 'total_amount',
 'discount_id',
 'tax_rate', --}}


 <body class="bg-gray-100 font-sans">
    <div class="container mx-auto py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4">Invoice #12345</h1>

            <!-- Invoice Details -->
            <form>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                        <input type="date" id="due_date" name="due_date" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount</label>
                        <input type="number" id="total_amount" name="total_amount" readonly 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="discount_type" class="block text-sm font-medium text-gray-700">Discount Type</label>
                        <select id="discount_type" name="discount_type" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Discount Type</option>
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed Amount</option>
                        </select>
                    </div>

                    <div>
                        <label for="discount_id" class="block text-sm font-medium text-gray-700">Discount Amount</label>
                        <input type="number" id="discount_id" name="discount_id" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="tax_rate" class="block text-sm font-medium text-gray-700">Tax Rate</label>
                        <input type="number" id="tax_rate" name="tax_rate" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                        <select id="currency" name="currency" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Currency</option>
                            <option value="usd">USD</option>
                            <option value="eur">EUR</option>
                            <option value="ngn">NGN</option>
                        </select>
                    </div>

                    <div>
                        <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                        <select id="contact" name="contact" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Contact</option>
                            <option value="contact1">John Doe</option>
                            <option value="contact2">Jane Smith</option>
                        </select>
                    </div>
                </div>

                <!-- Invoice Items -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4">Invoice Items</h2>

                    <div id="items-container" class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <input type="text" placeholder="Item Description" 
                                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <input type="number" placeholder="Quantity" 
                                   class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <input type="number" placeholder="Price" 
                                   class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <button type="button" class="text-red-500 hover:text-red-700">Remove</button>
                        </div>
                    </div>

                    <button type="button" id="add-item-btn" 
                            class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">
                        Add Item
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-green-500 text-white font-semibold rounded-md shadow hover:bg-green-600">
                        Save Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const itemsContainer = document.getElementById('items-container');
        const addItemBtn = document.getElementById('add-item-btn');

        addItemBtn.addEventListener('click', () => {
            const itemRow = document.createElement('div');
            itemRow.className = 'flex items-center space-x-4';
            itemRow.innerHTML = `
                <input type="text" placeholder="Item Description" 
                       class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <input type="number" placeholder="Quantity" 
                       class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <input type="number" placeholder="Price" 
                       class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <button type="button" class="text-red-500 hover:text-red-700">Remove</button>
            `;

            itemRow.querySelector('button').addEventListener('click', () => {
                itemRow.remove();
            });

            itemsContainer.appendChild(itemRow);
        });
    </script>
</body>
