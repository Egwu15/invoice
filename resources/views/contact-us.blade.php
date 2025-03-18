<x-guest-static-layout>
    <div class="text-center mt-5 md:mt-10">
        <p class="text-4xl font-bold">Contact</p>
        <Fragment slot="text-lg">We are a here to help.</Fragment>
    </div>

    <div class="grid md:grid-cols-2 gap-10 mx-auto max-w-4xl mt-16">
        <div>
            <h2 class="font-medium text-2xl text-gray-800">Contact Astroship</h2>
            <p class="text-lg leading-relaxed text-slate-500 mt-3">
                Have something to say? We are here to help. Fill up the form or send
                email or call phone.
            </p>
            <div class="mt-5">
                <div class="flex items-center mt-2 space-x-2 text-gray-600">
                    <x-mary-icon name="o-map-pin" class="text-gray-400 w-4 h-4" />
                    <span>1734 Sanfransico, CA 93063</span>
                </div>
                <div class="flex items-center mt-2 space-x-2 text-gray-600">
                    <x-mary-icon name='o-envelope' class="text-gray-400 w-4 h-4" /><a
                        href="mailto:hello@astroshipstarter.com">hello@astroshipstarter.com</a>
                </div>
                <div class="flex items-center mt-2 space-x-2 text-gray-600">
                    <x-mary-icon class="text-gray-400 w-4 h-4" name="o-phone" /><a href="tel:+1 (987) 4587 899">+1 (987)
                        4587
                        899</a>
                </div>
            </div>
        </div>
        <div>
            <form action="https://api.web3forms.com/submit" method="POST" id="form" class="needs-validation">
                <input type="hidden" name="access_key" value="YOUR_ACCESS_KEY_HERE" />
                <!-- Create your free access key from https://web3forms.com/ -->
                <input type="checkbox" class="hidden" style="display:none" name="botcheck" />
                <div class="mb-5">
                    <input type="text" placeholder="Full Name" required
                        class="w-full px-4 py-3 border-2 placeholder:text-gray-800 rounded-md outline-hidden focus:ring-4 border-gray-300 focus:border-gray-600 ring-gray-100"
                        name="name" />
                    <div class="empty-feedback invalid-feedback text-red-400 text-sm mt-1">
                        Please provide your full name.
                    </div>
                </div>
                <div class="mb-5">
                    <label for="email_address" class="sr-only">Email Address</label><input id="email_address"
                        type="email" placeholder="Email Address" name="email" required
                        class="w-full px-4 py-3 border-2 placeholder:text-gray-800 rounded-md outline-hidden focus:ring-4 border-gray-300 focus:border-gray-600 ring-gray-100" />
                    <div class="empty-feedback text-red-400 text-sm mt-1">
                        Please provide your email address.
                    </div>

                </div>
                <div class="mb-3">
                    <textarea name="message" required placeholder="Your Message"
                        class="w-full px-4 py-3 border-2 placeholder:text-gray-800 rounded-md outline-hidden h-36 focus:ring-4 border-gray-300 focus:border-gray-600 ring-gray-100"></textarea>
                    <div class="empty-feedback invalid-feedback text-red-400 text-sm mt-1">
                        Please enter your message.
                    </div>
                </div>
                <button type="submit" class="btn w-full bg-purple-950 text-white">Send Message</button>
                <div id="result" class="mt-3 text-center"></div>
            </form>
        </div>
    </div>
</x-guest-static-layout>
