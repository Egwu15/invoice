<div class="drawer">
    <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col">
        <!-- Navbar -->
        <nav class="navbar bg-base-100 shadow-lg">
            <!-- Mobile: Dropdown menu -->
            <div class="navbar-start ">
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                    <ul tabindex="0"
                        class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-96 text-lg">
                        <li>
                            <a wire:navigate href="{{ route('pricing') }}"
                                class="{{ request()->routeIs('pricing') ? 'text-primary' : '' }}">
                                Pricing
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('about') }}"
                                class="{{ request()->routeIs('about') ? 'text-primary' : '' }}">
                                About
                            </a>

                        </li>
                        <li>
                            <a wire:navigate href="{{ route('contact') }}"
                                class="{{ request()->routeIs('contact') ? 'text-primary' : '' }}">
                                Contact
                            </a>

                        </li>

                        @auth
                            <li>
                                <a href="{{ url('/dashboard') }}" wire:navigate
                                    class="rounded-md px-3 py-2 hover:bg-gray-200">
                                    Dashboard
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" wire:navigate
                                    class="rounded-md px-3 py-2 hover:bg-gray-200 {{ request()->routeIs('login') ? 'text-primary' : 'text-black' }}">
                                    Log in
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li>
                                    <a href="{{ route('register') }}" wire:navigate
                                        class="rounded-md px-3 py-2 hover:bg-gray-200  {{ request()->routeIs('register') ? 'text-primary' : 'text-black' }}">
                                        Register
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
                <!-- Brand / Logo -->
                <a href="{{ route('welcome') }}" wire:navigate class="btn btn-ghost normal-case text-xl">Invoice App</a>
            </div>

            <!-- Desktop: Horizontal menu -->
            <div class="navbar-end hidden lg:flex">
                <ul class="menu menu-horizontal p-0">
                    <li>
                        <a wire:navigate href="{{ route('pricing') }}"
                            class="{{ request()->routeIs('pricing') ? 'text-primary' : '' }}">
                            Pricing
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('about') }}"
                            class="{{ request()->routeIs('about') ? 'text-primary' : '' }}">
                            About
                        </a>
                    </li>
                    <li>
                        <a wire:navigate href="{{ route('contact') }}"
                            class="{{ request()->routeIs('contact') ? 'text-primary' : '' }}">
                            Contact
                        </a>
                    </li>

                    @auth
                        <li>
                            <a href="{{ url('/dashboard') }}" wire:navigate
                                class="rounded-md px-3 py-2 hover:bg-gray-200 ">
                                Dashboard
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" wire:navigate
                                class="rounded-md px-3 py-2 hover:bg-gray-200 {{ request()->routeIs('login') ? 'text-primary' : 'text-black' }}">
                                Log in
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li>
                                <a href="{{ route('register') }}" wire:navigate
                                    class="rounded-md px-3 py-2 hover:bg-gray-200 {{ request()->routeIs('register') ? 'text-primary' : 'text-black' }}">
                                    Register
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </nav>

        <!-- Page content here -->

    </div>
    {{-- <div class="drawer-side">
        <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>
        <ul class="menu bg-base-200 min-h-full w-80 p-4">
            <!-- Sidebar content here -->
            <li><a>Sidebar Item 1</a></li>
            <li><a>Sidebar Item 2</a></li>
        </ul>
    </div> --}}
</div>

{{-- <nav class="-mx-3 flex flex-1 justify-end">
    
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Dashboard
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Log in
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Register
            </a>
        @endif
    @endauth
</nav> --}}
