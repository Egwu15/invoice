<x-guest-static-layout>
    <div class=" mx-auto px-4 max-w-[996px] text-center mt-5 md:mt-11">
        <p class="font-bold text-5xl my-3">Plans & Pricing</p>
        <p class="text-xl mb-10">
            Flexible Options for Every Business
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($pricing as $plan)
                <div class="flex flex-col w-full border-2 border-gray-400 border-opacity-50 py-5 px-6 rounded-md">
                    <div class="text-center">
                        <h4 class="text-lg font-medium text-gray-400">{{ $plan['name'] }}</h4>
                        <p class="mt-3 text-4xl font-bold text-black md:text-4xl">
                            @if (is_array($plan['price']))
                                {{ $plan['price']['monthly'] }}
                            @else
                                {{ $plan['price'] }}
                            @endif
                        </p>
                        {{-- Uncomment this block to show the original price when available --}}
                        {{-- 
                @if (is_array($plan['price']) && isset($plan['price']['original']))
                  <p class="mt-1 text-xl font-medium text-gray-400 line-through md:text-2xl">
                    {{ $plan['price']['original'] }}
                  </p>
                @endif 
                --}}
                    </div>
                    <ul class="grid mt-8 text-left gap-y-4 font-bold">
                        @foreach ($plan['features'] as $feature)
                            <li class="flex items-start gap-3 text-gray-800">
                                <!-- Inline SVG for Tick Icon -->
                                <x-mary-icon name='s-check-circle' />
                                <span>{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex mt-8 justify-center">
                        <a href="{{ $plan['button']['link'] ?? '#' }}"
                            class="px-4 py-2 rounded btn w-full {{ $plan['popular'] ? 'bg-purple-950  text-white' : 'btn-outline border-2' }}">
                            {{ $plan['button']['text'] ?? 'Get Started' }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</x-guest-static-layout>
