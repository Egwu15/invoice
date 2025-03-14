<?php
use App\Services\AuthService;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>

    <div class="text-center font-bold text-xl mb-4">
        <h2>
            Create an account with us!
        </h2>
        <progress class="progress w-56 progress-primary" value="50" max="100"></progress>
    </div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-mary-input wire:model="name" id="name" class="block mt-1 w-full border-gray-500" type="text"
                name="name" required autofocus autocomplete="name" />

        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-mary-input wire:model="email" id="email" class="block mt-1 w-full border-gray-500" type="email"
                name="email" required autocomplete="username" />

        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-mary-input wire:model="password" id="password" class="block mt-1 w-full border-gray-500" type="password"
                name="password" required autocomplete="new-password" />


        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-mary-input wire:model="password_confirmation" id="password_confirmation"
                class="block mt-1 w-full border-gray-500" type="password" name="password_confirmation" required
                autocomplete="new-password" />


        </div>
        <div class="w-full text-center mt-3">
            <x-primary-button class="w-full bg-primary py-3">
                <p class="mx-auto">Register</p>
            </x-primary-button>
        </div>
        <div class="text-center mt-4">

            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 border-gray-500"
                href="{{ route('login') }}" wire:navigate>
                Already registered?
            </a>


        </div>
    </form>
</div>
