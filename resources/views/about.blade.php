<x-guest-static-layout>

    <div class="text-center mt-5 md:mt-10">
        <p class="text-4xl font-bold">About</p>
        <p class="text-lg">We are a small passionate team.</p>
    </div>

    <div class="flex flex-col gap-3 mx-auto max-w-4xl mt-16">
        <h2 class="font-bold text-3xl text-gray-800">
            Empowering the world with Astro.
        </h2>
        <p class="text-lg leading-relaxed text-slate-500">
            We're a multi-cultural team from around the world! We come from diverse
            backgrounds, bringing different personalities, experiences and skills to
            the job. This is what makes our team so special.
        </p>
    </div>
    <div class="grid md:grid-cols-2 gap-10 mx-auto max-w-4xl mt-12">

        <div class="group">
            <div class="w-full aspect-square">
                <img src='https://i.pravatar.cc/400' alt='Ted' sizes="(max-width: 800px) 100vw, 400px" width={400}
                    height={400}
                    class="w-full rounded-sm transition group-hover:-translate-y-1 group-hover:shadow-xl bg-white object-cover object-center aspect-square" />
            </div>

            <div class="mt-4 text-center">
                <h2 class="text-lg text-gray-800">Egwu Ted</h2>
                <h3 class="text-sm text-slate-500">
                    Developer
                </h3>
            </div>
        </div>
        
        <div class="group">
            <div class="w-full aspect-square">
                <img src='https://i.pravatar.cc/500' alt='Ted' sizes="(max-width: 800px) 100vw, 400px" width={400}
                    height={400}
                    class="w-full rounded-sm transition group-hover:-translate-y-1 group-hover:shadow-xl bg-white object-cover object-center aspect-square" />
            </div>

            <div class="mt-4 text-center">
                <h2 class="text-lg text-gray-800">Charles Oloyede</h2>
                <h3 class="text-sm text-slate-500">
                    Product manager
                </h3>
            </div>
        </div>

    </div>

</x-guest-static-layout>
