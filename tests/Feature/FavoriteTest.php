<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    // indexアクションのテスト
    public function test_guest_cannot_access_favorite_index()
    {
        $response = $this->get(route('favorites.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_free_member_cannot_access_favorite_index()
    {
        $user = User::factory()->create(['membership' => 'free']);
        $response = $this->actingAs($user)->get(route('favorites.index'));
        $response->assertStatus(403);
    }

    public function test_paid_member_can_access_favorite_index()
    {
        $user = User::factory()->create(['membership' => 'paid']);
        $response = $this->actingAs($user)->get(route('favorites.index'));
        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_favorite_index()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('favorites.index'));
        $response->assertStatus(403);
    }

    // storeアクションのテスト
    public function test_guest_cannot_add_favorite()
    {
        $restaurant = Restaurant::factory()->create();
        $response = $this->post(route('favorites.store', $restaurant->id));
        $response->assertRedirect(route('login'));
    }

    public function test_free_member_cannot_add_favorite()
    {
        $user = User::factory()->create(['membership' => 'free']);
        $restaurant = Restaurant::factory()->create();
        $response = $this->actingAs($user)->post(route('favorites.store', $restaurant->id));
        $response->assertStatus(403);
    }

    public function test_paid_member_can_add_favorite()
    {
        $user = User::factory()->create(['membership' => 'paid']);
        $restaurant = Restaurant::factory()->create();
        $response = $this->actingAs($user)->post(route('favorites.store', $restaurant->id));
        $response->assertStatus(302);
        $this->assertDatabaseHas('restaurant_user', [
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);
    }

    public function test_admin_cannot_add_favorite()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $restaurant = Restaurant::factory()->create();
        $response = $this->actingAs($user)->post(route('favorites.store', $restaurant->id));
        $response->assertStatus(403);
    }

    // destroyアクションのテスト
    public function test_guest_cannot_remove_favorite()
    {
        $restaurant = Restaurant::factory()->create();
        $response = $this->delete(route('favorites.destroy', $restaurant->id));
        $response->assertRedirect(route('login'));
    }

    public function test_free_member_cannot_remove_favorite()
    {
        $user = User::factory()->create(['membership' => 'free']);
        $restaurant = Restaurant::factory()->create();
        $user->favorite_restaurants()->attach($restaurant->id);
        $response = $this->actingAs($user)->delete(route('favorites.destroy', $restaurant->id));
        $response->assertStatus(403);
    }

    public function test_paid_member_can_remove_favorite()
    {
        $user = User::factory()->create(['membership' => 'paid']);
        $restaurant = Restaurant::factory()->create();
        $user->favorite_restaurants()->attach($restaurant->id);
        $response = $this->actingAs($user)->delete(route('favorites.destroy', $restaurant->id));
        $response->assertStatus(302);
        $this->assertDatabaseMissing('restaurant_user', [
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);
    }

    public function test_admin_cannot_remove_favorite()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $restaurant = Restaurant::factory()->create();
        $user->favorite_restaurants()->attach($restaurant->id);
        $response = $this->actingAs($user)->delete(route('favorites.destroy', $restaurant->id));
        $response->assertStatus(403);
    }
}
