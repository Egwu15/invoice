<div>


    <x-slot:sidebar drawer="main-drawer" collapsible collapse-icon="o-power" class="bg-gray-50" right-mobile>

        <x-mary-menu activeBgColor="bg-purple-500 text-white">

            {{-- User --}}
            @if ($user = auth()->user())
                <x-mary-menu-separator />

                <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                    class="-mx-2 !-my-2 rounded">
                    <x-slot:actions>
                        <x-mary-button icon="o-arrow-left-circle" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff"
                            no-wire-navigate link="/logout" />
                    </x-slot:actions>
                </x-mary-list-item>

                <x-mary-menu-separator />
            @endif

            <x-mary-menu-item title="Dashboard" icon="o-home" link="{{ route('dashboard') }}"
                active="{{ Route::current()->getName() === 'dashboard' }}" />

            {{-- <x-menu-item title="Home" icon="o-home" link="{{ route('dashboard') }}"/> --}}

            <x-mary-menu-sub title="Customers" icon="o-identification" link="{{ route('dashboard') }}">
                <x-mary-menu-item title="Create Customer" icon="o-user-plus" link="{{ route('customer.create') }}"
                    active="{{ Route::current()->getName() === 'customer.create' }}" />
                <x-mary-menu-item title="View Customers" icon="o-user" link="{{ route('customer.view') }}"
                    active="{{ Route::current()->getName() === 'customer.view' }}" />
            </x-mary-menu-sub>

            <x-mary-menu-sub title="Items" icon="o-shopping-cart" class="my-3">
                <x-mary-menu-item title="Add Items" icon="o-folder-plus" link="{{ route('item.create') }}"
                    active="{{ Route::current()->getName() === 'item.create' }}" />
                <x-mary-menu-item title="view Items" icon="o-folder" link="{{ route('item.view') }}"
                    active="{{ Route::current()->getName() === 'item.view' }}" />
            </x-mary-menu-sub>

            <x-mary-menu-sub title="Invoice" icon="o-shopping-cart" class="my-3">
                <x-mary-menu-item title="Add Invoice" icon="o-clipboard-document-list" link="{{ route('invoice.create') }}"
                    active="{{ Route::current()->getName() === 'invoice.create' }}" />
                <x-mary-menu-item title="Invoice" icon="o-receipt-percent" link="{{ route('invoice.view') }}"
                    active="{{ Route::current()->getName() === 'invoice.view' }}" />
            </x-mary-menu-sub>
            <x-mary-menu-sub title="Coming Soon" icon="o-cog-6-tooth" class="my-3">
                <x-mary-menu-item title="Estimate" icon="o-wifi" link="####" />
                <x-mary-menu-item title="Schedular" icon="o-archive-box" link="####" />
            </x-mary-menu-sub>

        </x-mary-menu>
    </x-slot:sidebar>
</div>
