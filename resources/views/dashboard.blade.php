<x-app-layout>
   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:flex gap-4 ">
                <div class="card shadow-md rounded px-5 py-5  w-full">
                    <p class="text-gray-500">Total Revenue</p>
                    <div class="flex items-center justify-between">
                        <p class="text-primary font-bold text-3xl mr-2">20,000,000</p>
                        <x-mary-icon name="o-banknotes" class="text-primary h-10" />
                    </div>
                    <p class="text-gray-400 text-xs mt-3">Total revenue collected from invoices</p>
                </div>
                
                <div class="card shadow-md rounded px-5 py-5  w-full">
                    <p class="text-gray-500">Total Invoices Created</p>
                    <div class="flex items-center justify-between">
                        <p class="text-primary font-bold text-3xl mr-2">20,000,000</p>
                        <x-mary-icon name="o-banknotes" class="text-primary h-10" />
                    </div>
                    <p class="text-gray-400 text-xs mt-3">Total revenue collected from invoices</p>
                </div>

                <div class="card shadow-md rounded px-5 py-5 w-full">
                    <p class="text-gray-500">Outstanding Invoices</p>
                    <div class="flex items-center justify-between">
                        <p class="text-primary font-bold text-3xl mr-2">20,000,000</p>
                        <x-mary-icon name="o-banknotes" class="text-primary h-10" />
                    </div>
                    <p class="text-gray-400 text-xs mt-3">Total revenue collected from invoices</p>
                </div>


            </div>
            <div class="card shadow-md rounded px-5 py-5">
                <p class="text-gray-500">Paid Invoices</p>
                <div class="flex items-center justify-between">
                    <p class="text-primary font-bold text-3xl mr-2">20,000,000</p>
                    <x-mary-icon name="o-banknotes" class="text-primary h-10" />
                </div>
                <p class="text-gray-400 text-xs mt-3">Total revenue collected from invoices</p>
            </div>

            <x-chart wire:model="myChart" />

        </div>
    </div>
</x-app-layout>
