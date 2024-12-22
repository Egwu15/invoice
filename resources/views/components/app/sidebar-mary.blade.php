<div>

    <x-slot:sidebar drawer="main-drawer" collapsible collapse-text="Hide" class="bg-gray-100" right-mobile>

        <x-mary-menu activate-by-route>

            {{-- User --}}
            @if ($user = auth()->user())
                <x-mary-menu-separator />

                <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                    class="-mx-2 !-my-2 rounded">
                    <x-slot:actions>
                        <x-mary-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff"
                            no-wire-navigate link="/logout" />
                    </x-slot:actions>
                </x-mary-list-item>

                <x-mary-menu-separator />
            @endif

            <x-mary-menu-item title="Dashboard" icon="o-home" link="/" />

            <x-mary-menu-sub title="Customers" icon="o-identification">
                <x-mary-menu-item title="Create Customer" icon="o-user-plus" link="{{ route('customer.create') }}" />
                <x-mary-menu-item title="View Customers" icon="o-user" link="{{ route('customer.view') }}" />
            </x-mary-menu-sub>

            <x-mary-menu-sub title="Items" icon="o-shopping-cart">
                <x-mary-menu-item title="Add Items" icon="o-folder-plus" link="{{ route('item.create') }}" />
                <x-mary-menu-item title="view Items" icon="o-folder" link="{{ route('item.view') }}" />
            </x-mary-menu-sub>

            <x-mary-menu-sub title="Invoice" icon="o-shopping-cart">
                <x-mary-menu-item title="Invoice" icon="o-receipt-percent" link="{{ route('invoice.create') }}" />
            </x-mary-menu-sub>
            <x-mary-menu-sub title="Coming Soon" icon="o-cog-6-tooth">
                <x-mary-menu-item title="Estimate" icon="o-wifi" link="####" />
                <x-mary-menu-item title="Schedular" icon="o-archive-box" link="####" />

            </x-mary-menu-sub>
        </x-mary-menu>
    </x-slot:sidebar>
</div>
