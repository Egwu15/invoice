<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Invoice</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans">

    <header>

        @if (Route::has('login'))
            <livewire:welcome.navigation />
        @endif
    </header>

    <main class="md:max-w-[90%] mx-auto px-2">
        <div class="grid lg:grid-cols-2 place-items-center pt-16 pb-8 md:pt-12 md:pb-24 ">
            <div class="py-6 md:order-1 hidden md:block">
                <img src={{ asset('images/hero.png') }} alt="Astronaut in the air" widths="200, 400, 600"
                    sizes="(max-width: 800px) 100vw, 620px" loading="eager" format="avif" />
            </div>
            <div>
                <h1 class="text-5xl lg:text-6xl xl:text-7xl font-bold lg:tracking-tight xl:tracking-tighter">
                    Marketing website done with Astro
                </h1>
                <p class="text-lg mt-4 text-slate-600 max-w-xl">
                    Astroship is a starter template for startups, marketing websites & landing
                    pages.<wbr /> Built with Astro.build and TailwindCSS. You can quickly
                    create any website with this starter.
                </p>
                <div class="mt-6 flex flex-col sm:flex-row gap-3 ">
                    <a class="btn bg-black text-white rounded-md text-lg" /> Register for Free </a>
                    <a class="text-black btn btn-outline px-8 rounded-md border-2 text-lg">Login</a>
                </div>
            </div>
        </div>

        <div class="mt-16 md:mt-0">
            <h2 class="text-4xl lg:text-5xl font-bold lg:tracking-tight">
                Everything you need to start a website
            </h2>
            <p class="text-lg mt-4 text-slate-600">
                Astro comes batteries included. It takes the best parts of state-of-the-art
                tools and adds its own innovations.
            </p>
        </div>
        {{-- Features --}}
        <div class="grid sm:grid-cols-2 md:grid-cols-3 mt-16 gap-16">

            <div class="flex gap-4 items-start">
                <div class="mt-1 bg-black rounded-full  p-2 flex">
                    <x-mary-icon name="o-document-text" class="text-white my-auto " />
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Generate Invoices</h3>
                    <p class="text-slate-500 mt-2 leading-relaxed"> Create professional invoices with just a few clicks.
                    </p>
                </div>
            </div>
            <div class="flex gap-4 items-start">
                <div class="mt-1 bg-black rounded-full  p-2 flex">
                    <x-mary-icon name="o-user-group" class="text-white my-auto " />
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Store Contacts</h3>
                    <p class="text-slate-500 mt-2 leading-relaxed"> Keep track of client information for faster
                        billing.</p>
                </div>
            </div>
            <div class="flex gap-4 items-start">
                <div class="mt-1 bg-black rounded-full  p-2 flex">
                    <x-mary-icon name="o-currency-dollar" class="text-white my-auto " />
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Track Payments</h3>
                    <p class="text-slate-500 mt-2 leading-relaxed"> Monitor amounts paid and outstanding balances in one
                        place.</p>
                </div>
            </div>
            <div class="flex gap-4 items-start">
                <div class="mt-1 bg-black rounded-full  p-2 flex">
                    <x-mary-icon name="o-briefcase" class="text-white my-auto " />
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Send Invoices</h3>
                    <p class="text-slate-500 mt-2 leading-relaxed">Deliver invoices directly to your clients’ inboxes.
                    </p>
                </div>
            </div>
            <div class="flex gap-4 items-start">
                <div class="mt-1 bg-black rounded-full  p-2 flex">
                    <x-mary-icon name="o-chart-bar" class="text-white my-auto " />
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Reporting & Analytics</h3>
                    <p class="text-slate-500 mt-2 leading-relaxed"> Gain insights with detailed reports on your billing
                        activity.</p>
                </div>
            </div>
            <div class="flex gap-4 items-start">
                <div class="mt-1 bg-black rounded-full  p-2 flex">
                    <x-mary-icon name="o-briefcase" class="text-white my-auto " />
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Recurring Invoices</h3>
                    <p class="text-slate-500 mt-2 leading-relaxed">Easily replicate existing invoices and improve
                        workflow.</p>
                </div>
            </div>



        </div>
        <div
            class="bg-black p-8 md:px-20 md:py-20 mt-20 mx-auto max-w-5xl rounded-lg flex flex-col items-center text-center">
            <h2 class="text-white text-4xl md:text-6xl tracking-tight">
                Build faster websites.
            </h2>
            <p class="text-slate-400 mt-4 text-lg md:text-xl">
                Pull content from anywhere and serve it fast with Astro's next-gen island
                architecture.
            </p>
            <div class="flex mt-5">
                <a class="btn border-white rounded text-lg bg-white" href="#" >Get Started</a>
            </div>
        </div>
        <div class="text-center my-14">
            <p>Copyright ©{{ date('Y') }} Invoice. All rights reserved.</p>
        </div>
    </main>




</body>

</html>
