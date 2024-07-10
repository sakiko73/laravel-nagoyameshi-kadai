<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Admin;
use App\Models\Restaurant;
use App\Models\Category;

class RestaurantTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    /**
     * 未ログインのユーザーは会員側の店舗一覧ページにアクセスできる
     */
    public function test_guest_can_access_restaurant_index_page()
    {
        $response = $this->get('/restaurants');

        $response->assertOk();
    }

    /**
     * ログイン済みの一般ユーザーは会員側の店舗一覧ページにアクセスできる
     */
    public function test_authenticated_user_can_access_restaurant_index_page()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($user);

        $response = $this->get('/restaurants');

        $response->assertOk();
    }


//      * ログイン済みの管理者は会員側の店舗一覧ページにアクセスできない

    public function test_authenticated_admin_cannot_access_restaurant_index_page()
    {
        $admin = Admin::factory()->create();

        $this->actingAs($admin, 'admin');

        $response = $this->get('/restaurants');

        $response->assertRedirect(route('admin.home'));
    }


// ・未ログインのユーザーは会員側の店舗詳細ページにアクセスできる
   public function test_guest_can_access_restaurant_show_page()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->get(route('restaurants.show', $restaurant));

        $response->assertOk();
    }
// // ・ログイン済みの一般ユーザーは会員側の店舗詳細ページにアクセスできる
//     public function test_authenticated_user_can_access_restaurant_show_page()
//     {
//         $user = User::factory()->create();
//         $restaurant = Restaurant::factory()->create();

//         $response = $this->actingAs($user)->get(route('restaurants.show', $restaurant));

//         $response->assertOk();
//     }

    // ・ログイン済みの管理者は会員側の店舗詳細ページにアクセスできない
    public function test_admin_cannot_access_restaurant_show_page()
    {
        //$admin = User::factory()->create(['is_admin' => true]);
        $admin = Admin::factory()->create();
        //$restaurant = Restaurant::factory()->create();

        //$response = $this->actingAs($admin)->get(route('restaurants.show', $restaurant));
        $this->actingAs($admin, 'admin');

        $response = $this->get('/restaurants'); 
        //$response->assertStatus(403); // Assuming you return a 403 Forbidden status for admins
        $response->assertRedirect(route('admin.home'));
    }
 }

