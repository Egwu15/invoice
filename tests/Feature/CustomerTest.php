<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Livewire\Volt\Volt;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class CustomerTest extends TestCase
{

    use RefreshDatabase;
    public function test_redirect_to_create_business_if_no_business(): void
    {

        $user = User::factory()->make();
        /** @var User $user */
        $this->actingAs($user);
        $response = $this->get(route('customer.create'));
        $response->assertRedirect(Route('business.create'));
    }

    public function test_create_customer(): void
    {

        $user = User::factory()->create();
        /** @var User $user */
        $this->actingAs($user);
        $customer = Customer::factory()->make(['user_id' => $user->id]);

        $component = Volt::test('pages.customer.create-customer-form')
            ->set('form', $customer->toArray());
        $component->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('Customers', $customer->toArray());
    }


    public function test_view_create_customer(): void
    {

        $user = User::factory()->create();
        Customer::factory()->make(['user_id' => $user->id]);


        /** @var User $user */
        $this->actingAs($user);
        $this->get(route('customer.create'));
        Volt::test('pages.customer.create-customer-form')
            ->assertSee('Add a customer to your business')
            ->assertHasNoErrors();
    }

    public function test_view_customer_list(): void
    {


        $customer = Customer::factory()->create();

        /** @var User $user */
        $this->actingAs($customer->user);
        $this->get(route('customer.view'));
        Volt::test('pages.customer.view-customer')
            ->assertSee('Add Customer')
            ->assertHasNoErrors()
            ->assertSee($customer->name)
        ;
    }

    public function test_can_update_customer(): void
    {

        $user = User::factory()->create();
        $oldCustomer = Customer::factory()->create(['user_id' => $user->id]);
        $customer = Customer::factory(['user_id' => $user->id])->make();

        /** @var User $user */
        $this->actingAs($user);

        Log::info($customer->toArray());
        $this->get(route('customer.edit', ['customer' => $oldCustomer]));
        Volt::test('pages.customer.edit-customer', ['customer' => $oldCustomer])
            ->set('form', $customer->toArray())
            ->call('edit')
            ->assertHasNoErrors()
            ->assertRedirect(route('customer.view'));

        $this->assertDatabaseHas('Customers', $customer->toArray());

        Volt::test('pages.customer.view-customer')
            ->assertSee($customer->name);
    }

    public function test_can_delete_customer(): void
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create(['user_id' => $user->id]);

        /** @var User $user */
        $this->actingAs($user);

        $this->get(route('customer.view', ['customer' => $customer]));
        Volt::test('pages.customer.view-customer')
            ->call('deleteCustomer', $customer->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('Customers', $customer->toArray());
    }
}
