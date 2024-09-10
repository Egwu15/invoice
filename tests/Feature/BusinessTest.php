<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use Livewire\Volt\Volt;

class BusinessTest extends TestCase
{

    use RefreshDatabase;
    
    public function test_redirect_to_business_if_there_is_no_business(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);


        $response = $this->get('/dashboard');

        $response->assertRedirect('/business/create');
    }

    public function test_redirect_to_dashboard_if_has_business(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Business::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get('/business/create');

        $response->assertRedirect('/dashboard');
    }

    public function test_can_create_business(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);
        $business = Business::factory()->make();

        $component = Volt::test('business')
            ->set('form.businessName', $business->name)
            ->set('form.businessType', $business->business_type);

        $component->call('createBusiness')
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));


        $this->assertDatabaseHas('businesses', [
            'name' => $business->name,
            'user_id' => $user->id,
            'business_type' => $business->business_type,
        ]);
    }
}
