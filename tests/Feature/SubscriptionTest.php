<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    // createアクションのテスト
    public function test_guest_cannot_access_subscription_create_page()
    {
        $response = $this->get('/subscription/create');
        $response->assertRedirect('/login');
    }

    public function test_free_user_can_access_subscription_create_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/subscription/create');
        $response->assertStatus(200);
    }

    public function test_subscribed_user_cannot_access_subscription_create_page()
    {
        $user = User::factory()->create();
        $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
        $response = $this->actingAs($user)->get('/subscription/create');
        $response->assertRedirect('/subscription/edit');
    }

    public function test_admin_cannot_access_subscription_create_page()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->get('/subscription/create');
        $response->assertRedirect('/subscription/edit');
    }

    // storeアクションのテスト
    public function test_guest_cannot_subscribe_to_premium_plan()
    {
        $response = $this->post('/subscription/store', ['paymentMethodId' => 'pm_card_visa']);
        $response->assertRedirect('/login');
    }

    public function test_free_user_can_subscribe_to_premium_plan()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/subscription/store', ['paymentMethodId' => 'pm_card_visa']);
        $user->refresh();
        $response->assertRedirect('/home');
        $this->assertTrue($user->subscribed('premium_plan'));
    }

    public function test_subscribed_user_cannot_subscribe_to_premium_plan()
    {
        $user = User::factory()->create();
        $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
        $response = $this->actingAs($user)->post('/subscription/store', ['paymentMethodId' => 'pm_card_visa']);
        $response->assertRedirect('/subscription/edit');
    }

    public function test_admin_cannot_subscribe_to_premium_plan()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->post('/subscription/store', ['paymentMethodId' => 'pm_card_visa']);
        $response->assertRedirect('/subscription/edit');
    }

    // editアクションのテスト
    public function test_guest_cannot_access_subscription_edit_page()
    {
        $response = $this->get('/subscription/edit');
        $response->assertRedirect('/login');
    }

    public function test_free_user_cannot_access_subscription_edit_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/subscription/edit');
        $response->assertRedirect('/subscription/create');
    }

    public function test_subscribed_user_can_access_subscription_edit_page()
    {
        $user = User::factory()->create();
        $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
        $response = $this->actingAs($user)->get('/subscription/edit');
        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_subscription_edit_page()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->get('/subscription/edit');
        $response->assertRedirect('/subscription/create');
    }

    // updateアクションのテスト
    public function test_guest_cannot_update_payment_method()
    {
        $response = $this->patch('/subscription/update', ['paymentMethodId' => 'pm_card_mastercard']);
        $response->assertRedirect('/login');
    }

    public function test_free_user_cannot_update_payment_method()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->patch('/subscription/update', ['paymentMethodId' => 'pm_card_mastercard']);
        $response->assertRedirect('/subscription/create');
    }

    public function test_subscribed_user_can_update_payment_method()
    {
        $user = User::factory()->create();
        $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
        $oldPaymentMethodId = $user->defaultPaymentMethod()->id;

        $response = $this->actingAs($user)->patch('/subscription/update', ['paymentMethodId' => 'pm_card_mastercard']);
        $user->refresh();
        $newPaymentMethodId = $user->defaultPaymentMethod()->id;

        $response->assertRedirect('/home');
        $this->assertNotEquals($oldPaymentMethodId, $newPaymentMethodId);
    }

    public function test_admin_cannot_update_payment_method()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->patch('/subscription/update', ['paymentMethodId' => 'pm_card_mastercard']);
        $response->assertRedirect('/subscription/create');
    }

    // cancelアクションのテスト
    public function test_guest_cannot_access_subscription_cancel_page()
    {
        $response = $this->get('/subscription/cancel');
        $response->assertRedirect('/login');
    }

    public function test_free_user_cannot_access_subscription_cancel_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/subscription/cancel');
        $response->assertRedirect('/subscription/create');
    }

    public function test_subscribed_user_can_access_subscription_cancel_page()
    {
        $user = User::factory()->create();
        $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
        $response = $this->actingAs($user)->get('/subscription/cancel');
        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_subscription_cancel_page()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->get('/subscription/cancel');
        $response->assertRedirect('/subscription/create');
    }

    // destroyアクションのテスト
    public function test_guest_cannot_cancel_subscription()
    {
        $response = $this->delete('/subscription/destroy');
        $response->assertRedirect('/login');
    }

    public function test_free_user_cannot_cancel_subscription()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete('/subscription/destroy');
        $response->assertRedirect('/subscription/create');
    }

    public function test_subscribed_user_can_cancel_subscription()
    {
        $user = User::factory()->create();
        $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');

        $response = $this->actingAs($user)->delete('/subscription/destroy');
        $user->refresh();

        $response->assertRedirect('/home');
        $this->assertFalse($user->subscribed('premium_plan'));
    }

    public function test_admin_cannot_cancel_subscription()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->delete('/subscription/destroy');
        $response->assertRedirect('/subscription/create');
    }
}