<?php

use Livewire\Volt\Component;
use App\Models\Business;
use App\Models\Invoice;
use Carbon\Carbon;

new class extends Component {
    public int $totalPaidInvoices;
    public int $unpaidInvoice;
    public int $totalInvoicesCreated;
    public ?int $totalRevenue;
    public array $weeklyData = [];
    public array $invoiceChartData = [];

    public function mount()
    {
        $businessId = auth()->user()->business->id;

        $this->totalInvoicesCreated = Invoice::where('business_id', $businessId)->count();
        $this->totalRevenue = Invoice::where('business_id', $businessId)->sum('total_paid');

        if ($this->totalRevenue == null) {
            $this->totalRevenue = 0;
        }

        $this->unpaidInvoice = Invoice::where('business_id', $businessId)->where('payment_status', 'unpaid')->count();

        $this->totalPaidInvoices = Invoice::where('business_id', $businessId)->where('payment_status', 'paid')->count();

        $this->prepareInvoiceChart($businessId);
    }
    private function prepareInvoiceChart($businessId)
    {
        $dbDriver = config('database.default');

        if ($dbDriver === 'sqlite') {
            $monthlyInvoiceData = Invoice::selectRaw('strftime("%Y-%m", created_at) as month, COUNT(*) as invoices_generated')->where('business_id', $businessId)->groupBy('month')->orderBy('month')->get();
        } elseif ($dbDriver === 'mysql') {
            $monthlyInvoiceData = Invoice::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as invoices_generated')->where('business_id', $businessId)->groupBy('month')->orderBy('month')->get();
        } else {
            // Handle other database drivers or throw an exception
            throw new \Exception("Unsupported database driver: $dbDriver");
        }
        $labels = [];
        $invoicesGenerated = [];

        foreach ($monthlyInvoiceData as $data) {
            $labels[] = Carbon::parse($data->month . '-01')->format('M Y');
            $invoicesGenerated[] = $data->invoices_generated;
        }

        $this->invoiceChartData = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Invoices Generated',
                        'data' => $invoicesGenerated,
                        'backgroundColor' => 'rgba(126, 34, 206)',
                        'borderColor' => 'rgba(126, 34, 206)',
                        'borderWidth' => 1,
                    ],
                ],
            ],
        ];
    }

    public function render(): mixed
    {
        return view('livewire.pages.dashboard-volt')->layout('layouts.app');
    }
}; ?>
<div>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:flex gap-4 ">
                <div class="card shadow-md rounded px-5 py-5  w-full">
                    <p class="text-gray-500">Total Revenue</p>
                    <div class="flex items-center justify-between">
                        <p class="text-primary font-bold text-3xl mr-2">{{ number_format($totalRevenue, 2) }}</p>
                        <x-mary-icon name="o-banknotes" class="text-primary h-10" />
                    </div>
                    <p class="text-gray-400 text-xs mt-3">Total revenue collected from invoices</p>
                </div>
                <div class="card shadow-md rounded px-5 py-5  w-full">
                    <p class="text-gray-500">Total Invoices Created</p>
                    <div class="flex items-center justify-between">
                        <p class="text-primary font-bold text-3xl mr-2">{{ $totalInvoicesCreated }}</p>
                        <x-mary-icon name="o-banknotes" class="text-primary h-10" />
                    </div>
                    <p class="text-gray-400 text-xs mt-3">Total revenue collected from invoices</p>
                </div>

                <div class="card shadow-md rounded px-5 py-5 w-full">
                    <p class="text-gray-500">Outstanding Invoices</p>
                    <div class="flex items-center justify-between">
                        <p class="text-primary font-bold text-3xl mr-2">{{ $unpaidInvoice }}</p>
                        <x-mary-icon name="o-banknotes" class="text-primary h-10" />
                    </div>
                    <p class="text-gray-400 text-xs mt-3">Total revenue collected from invoices</p>
                </div>


            </div>
            <div class="card shadow-md rounded px-5 py-5">
                <p class="text-gray-500">Paid Invoices</p>
                <div class="flex items-center justify-between">
                    <p class="text-primary font-bold text-3xl mr-2">{{ $totalPaidInvoices }}</p>
                    <x-mary-icon name="o-banknotes" class="text-primary h-10" />
                </div>
                <p class="text-gray-400 text-xs mt-3">Total revenue collected from invoices</p>
            </div>

            {{-- <x-mary-chart wire:model="myChart" class="w-full mx-auto mt-9" /> --}}
            <x-mary-chart wire:model="invoiceChartData"  class="w-full mx-auto mt-9" />
        </div>
    </div>



</div>
