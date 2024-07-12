<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Reservation;
use App\Models\User;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    // indexアクションのテスト
    public function test_guest_cannot_access_reservation_index()
    {
        $response = $this->get('/reservations');
        $response->assertRedirect('/login');
    }

    public function test_free_member_cannot_access_reservation_index()
    {
        $user = User::factory()->create(['membership' => 'free']);
        $this->actingAs($user);
        $response = $this->get('/reservations');
        $response->assertForbidden();
    }

    public function test_premium_member_can_access_reservation_index()
    {
        $user = User::factory()->create(['membership' => 'premium']);
        $this->actingAs($user);
        $response = $this->get('/reservations');
        $response->assertOk();
    }

    public function test_admin_cannot_access_reservation_index()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $response = $this->get('/reservations');
        $response->assertForbidden();
    }

    // createアクションのテスト
    public function test_guest_cannot_access_reservation_create()
    {
        $response = $this->get('/reservations/create');
        $response->assertRedirect('/login');
    }

    public function test_free_member_cannot_access_reservation_create()
    {
        $user = User::factory()->create(['membership' => 'free']);
        $this->actingAs($user);
        $response = $this->get('/reservations/create');
        $response->assertForbidden();
    }

    public function test_premium_member_can_access_reservation_create()
    {
        $user = User::factory()->create(['membership' => 'premium']);
        $this->actingAs($user);
        $response = $this->get('/reservations/create');
        $response->assertOk();
    }

    public function test_admin_cannot_access_reservation_create()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $response = $this->get('/reservations/create');
        $response->assertForbidden();
    }

    // storeアクションのテスト
    public function test_guest_cannot_store_reservation()
    {
        $response = $this->post('/reservations', [
            'reserved_datetime' => now(),
            'number_of_people' => 5,
        ]);
        $response->assertRedirect('/login');
    }

    public function test_free_member_cannot_store_reservation()
    {
        $user = User::factory()->create(['membership' => 'free']);
        $this->actingAs($user);
        $response = $this->post('/reservations', [
            'reserved_datetime' => now(),
            'number_of_people' => 5,
        ]);
        $response->assertForbidden();
    }

    public function test_premium_member_can_store_reservation()
    {
        $user = User::factory()->create(['membership' => 'premium']);
        $this->actingAs($user);
        $response = $this->post('/reservations', [
            'reserved_datetime' => now(),
            'number_of_people' => 5,
        ]);
        $response->assertRedirect('/reservations');
        $this->assertDatabaseHas('reservations', [
            'number_of_people' => 5,
        ]);
    }

    public function test_admin_cannot_store_reservation()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $response = $this->post('/reservations', [
            'reserved_datetime' => now(),
            'number_of_people' => 5,
        ]);
        $response->assertForbidden();
    }

    // destroyアクションのテスト
    public function test_guest_cannot_destroy_reservation()
    {
        $reservation = Reservation::factory()->create();
        $response = $this->delete('/reservations/' . $reservation->id);
        $response->assertRedirect('/login');
    }

    public function test_free_member_cannot_destroy_reservation()
    {
        $user = User::factory()->create(['membership' => 'free']);
        $this->actingAs($user);
        $reservation = Reservation::factory()->create();
        $response = $this->delete('/reservations/' . $reservation->id);
        $response->assertForbidden();
    }

    public function test_premium_member_cannot_destroy_others_reservation()
    {
        $user = User::factory()->create(['membership' => 'premium']);
        $this->actingAs($user);
        $reservation = Reservation::factory()->create();
        $response = $this->delete('/reservations/' . $reservation->id);
        $response->assertForbidden();
    }

    public function test_premium_member_can_destroy_own_reservation()
    {
        $user = User::factory()->create(['membership' => 'premium']);
        $this->actingAs($user);
        $reservation = Reservation::factory()->create(['user_id' => $user->id]);
        $response = $this->delete('/reservations/' . $reservation->id);
        $response->assertRedirect('/reservations');
        $this->assertDatabaseMissing('reservations', [
            'id' => $reservation->id,
        ]);
    }

    public function test_admin_cannot_destroy_reservation()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
        $reservation = Reservation::factory()->create();
        $response = $this->delete('/reservations/' . $reservation->id);
        $response->assertForbidden();
    }
}