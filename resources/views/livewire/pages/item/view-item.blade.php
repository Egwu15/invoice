<?php

use Livewire\Volt\Component;
use App\Models\Item;

new class extends Component {
    public function render(): mixed
    {
        $item = '';
        $items = Item::with(['itemType', 'discountType'])
            ->where('business_id', auth()->user()->business->id)
            ->paginate(10);
        Debugbar::info($items);
        return view('livewire.pages.item.view-item', ['items' => $items])->layout('layouts.app');
    }

    public function deleteItem(Item $item)
    {
        $userId = auth()->user()->business->id;
        if ($userId != auth()->user()->id) {
            session()->flash('error', 'Unable to delete this account');
            return;
        }
        $item->delete();
    }
}; ?>

<div>

    <div class="py-12" x-data="{ item: null, showModal: false }">

        {{-- Dialog --}}
        <div x-show="showModal">
            <dialog id="my_modal_1" class="modal" :class="showModal && 'modal-open'">
                <div class="modal-box">
                    <h3 class="text-lg font-bold text-red-500 text-center">Delete?</h3>
                    <p class="py-4 text-center">Are you sure you want to delete this Item?</p>
                    <p class="text-center">This action is irreversable.</p>
                    <div class=" flex justify-center mt-3">
                        <div class="mr-6 ">

                            <button x-on:click="$wire.deleteItem(item); showModal = false"
                                class="btn bg-red-500 text-white">
                                Delete
                            </button>
                        </div>
                        <button class="btn" x-on:click="showModal = false">Close</button>
                    </div>
                </div>
            </dialog>
        </div>

        {{-- End Dialog --}}

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">



                    @if ($items->isEmpty())
                        <x-empty-state title="No Items Added" subTitle="Try adding some products or servicest">
                            <a href="{{ route('item.create') }}" class="btn outline outline-1" wire:navigate>
                                Add Products or Services
                            </a>
                        </x-empty-state>
                    @endif


                    <div class="overflow-x-auto {{ $items->isEmpty() ? 'hidden' : '' }}">

                        <div class="flex justify-end pb-3">
                            <a href="{{ route('item.create') }}" class="btn btn-neutral outline outline-1"
                                wire:navigate>
                                Add Products or Services
                            </a>
                        </div>

                        <table class="table table-zebra">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Item Type</th>
                                    <th>Date added</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($items as $item)
                                    <tr>
                                        <th>{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}
                                        </th>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->amount }}</td>


                                        <td>{{ $item->itemType->name }}</td>
                                        <td>{{ $item->addedAt() }}</td>
                                        <td>
                                            <a href="{{ route('item.edit', ['item' => $item->id]) }}"
                                                class="btn btn-sm btn-neutral outline mr-1">Edit</a>
                                            <button class="btn btn-sm btn-danger outline outline-1"
                                                x-on:click="item = '{{ $item->id }}'; showModal = true;">
                                                Delete
                                            </button>
                                    </tr>
                                @endforeach

                                </tr>
                            </tbody>
                        </table>


                    </div>
                    <div class="mt-10 text-center">{{ $items->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
