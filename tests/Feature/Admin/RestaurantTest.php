<?php

namespace Tests\Feature\Admin;

use App\Models\Restaurant;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;

    // indexアクション（店舗一覧ページ）
    /**
     * 未ログインのユーザーは管理者側の店舗一覧ページにアクセスできない
     */
    public function test_guest_cannot_access_admin_restaurant_index()
    {
        $response = $this->get(route('admin.restaurants.index'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の店舗一覧ページにアクセスできない
     */
    public function test_user_cannot_access_admin_restaurant_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('admin.restaurants.index'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者は管理者側の店舗一覧ページにアクセスできる
     */
    public function test_admin_can_access_admin_restaurant_index()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();
        $this->actingAs($admin, 'admin');
        $response = $this->get(route('admin.restaurants.index'));
        $response->assertOk();
    }

    // showアクション（店舗詳細ページ）
    /**
     * 未ログインのユーザーは管理者側の店舗詳細ページにアクセスできない
     */
    public function test_guest_cannot_access_admin_restaurant_show()
    {
        $restaurant = Restaurant::factory()->create();
        $response = $this->get(route('admin.restaurants.show', $restaurant));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の店舗詳細ページにアクセスできない
     */
    public function test_user_cannot_access_admin_restaurant_show()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $restaurant = Restaurant::factory()->create();
        $response = $this->get(route('admin.restaurants.show', $restaurant));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者は管理者側の店舗詳細ページにアクセスできる
     */
    public function test_admin_can_access_admin_restaurant_show()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();
        $this->actingAs($admin, 'admin');
        $restaurant = Restaurant::factory()->create();
        $response = $this->get(route('admin.restaurants.show', $restaurant));
        $response->assertOk();
    }

    // createアクション（店舗登録ページ）
   /**
     * 未ログインのユーザーは管理者側の店舗登録ページにアクセスできない
     */
    public function test_guest_cannot_access_admin_restaurant_create()
    {
        $response = $this->get(route('admin.restaurants.create'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の店舗登録ページにアクセスできない
     */
    public function test_user_cannot_access_admin_restaurant_create()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('admin.restaurants.create'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者は管理者側の店舗登録ページにアクセスできる
     */
    public function test_admin_can_access_admin_restaurant_create()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();
        $this->actingAs($admin, 'admin');
        $response = $this->get(route('admin.restaurants.create'));
        $response->assertOk();
    }

    // storeアクション（店舗登録機能）
    /**
     * 未ログインのユーザーは店舗を登録できない
     */
    public function test_guest_cannot_store_restaurant()
    {
        $response = $this->post(route('admin.restaurants.store'), [
            'name' => 'テスト',
            'description' => 'テスト',
            'lowest_price' => 1000,
            'highest_price' => 5000,
            'postal_code' => '0000000',
            'address' => 'テスト',
            'opening_time' => '10:00:00',
            'closing_time' => '20:00:00',
            'seating_capacity' => 50,
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは店舗を登録できない
     */
    public function test_user_cannot_store_restaurant()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.restaurants.store'), [
            'name' => 'テスト',
            'description' => 'テスト',
            'lowest_price' => 1000,
            'highest_price' => 5000,
            'postal_code' => '0000000',
            'address' => 'テスト',
            'opening_time' => '10:00:00',
            'closing_time' => '20:00:00',
            'seating_capacity' => 50,
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者は店舗を登録できる
     */
    public function test_admin_can_store_restaurant()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();
        $this->actingAs($admin, 'admin');
        $response = $this->post(route('admin.restaurants.store'), [
            'name' => 'テスト',
            'description' => 'テスト',
            'lowest_price' => 1000,
            'highest_price' => 5000,
            'postal_code' => '0000000',
            'address' => 'テスト',
            'opening_time' => '10:00',
            'closing_time' => '20:00',
            'seating_capacity' => 50,
        ]);
        $response->assertRedirect(route('admin.restaurants.index'));
        $this->assertDatabaseHas('restaurants', [
            'name' => 'テスト',
            'description' => 'テスト',
        ]);
    }

    // editアクション（店舗編集ページ）
    /**
     * 未ログインのユーザーは管理者側の店舗編集ページにアクセスできない
     */
    public function test_guest_cannot_access_admin_restaurant_edit()
    {
        $restaurant = Restaurant::factory()->create();
        $response = $this->get(route('admin.restaurants.edit', $restaurant));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の店舗編集ページにアクセスできない
     */
    public function test_user_cannot_access_admin_restaurant_edit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $restaurant = Restaurant::factory()->create();
        $response = $this->get(route('admin.restaurants.edit', $restaurant));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者は管理者側の店舗編集ページにアクセスできる
     */
    public function test_admin_can_access_admin_restaurant_edit()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();
        $this->actingAs($admin, 'admin');
        $restaurant = Restaurant::factory()->create();
        $response = $this->get(route('admin.restaurants.edit', $restaurant));
        $response->assertOk();
    }

    // updateアクション（店舗更新機能）
    /**
     * 未ログインのユーザーは店舗を更新できない
     */
    public function test_guest_cannot_update_restaurant()
    {
        $restaurant = Restaurant::factory()->create();
        $response = $this->put(route('admin.restaurants.update', $restaurant), [
            'name' => '更新テスト',
            'description' => '更新テスト',
            'lowest_price' => 1500,
            'highest_price' => 5500,
            'postal_code' => '1111111',
            'address' => '更新テスト',
            'opening_time' => '09:00:00',
            'closing_time' => '21:00:00',
            'seating_capacity' => 60,
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは店舗を更新できない
     */
    public function test_user_cannot_update_restaurant()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $restaurant = Restaurant::factory()->create();
        $response = $this->put(route('admin.restaurants.update', $restaurant), [
            'name' => '更新テスト',
            'description' => '更新テスト',
            'lowest_price' => 1500,
            'highest_price' => 5500,
            'postal_code' => '1111111',
            'address' => '更新テスト',
            'opening_time' => '09:00:00',
            'closing_time' => '21:00:00',
            'seating_capacity' => 60,
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者は店舗を更新できる
     */
    public function test_admin_can_update_restaurant()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();
        $this->actingAs($admin, 'admin');
        $restaurant = Restaurant::factory()->create();
        $response = $this->put(route('admin.restaurants.update', $restaurant), [
            'name' => '更新テスト',
            'description' => '更新テスト',
            'lowest_price' => 1500,
            'highest_price' => 5500,
            'postal_code' => '1111111',
            'address' => '更新テスト',
            'opening_time' => '09:00',
            'closing_time' => '21:00',
            'seating_capacity' => 60,
        ]);
        $response->assertRedirect(route('admin.restaurants.index'));
        $this->assertDatabaseHas('restaurants', [
            'name' => '更新テスト',
            'description' => '更新テスト',
        ]);
    }

    // destroyアクション（店舗削除機能）
    /**
     * 未ログインのユーザーは店舗を削除できない
     */
    public function test_guest_cannot_delete_restaurant()
    {
        $restaurant = Restaurant::factory()->create();
        $response = $this->delete(route('admin.restaurants.destroy', $restaurant));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは店舗を削除できない
     */
    public function test_user_cannot_delete_restaurant()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $restaurant = Restaurant::factory()->create();
        $response = $this->delete(route('admin.restaurants.destroy', $restaurant));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者は店舗を削除できる
     */
    public function test_admin_can_delete_restaurant()
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();
        $this->actingAs($admin, 'admin');
        $restaurant = Restaurant::factory()->create();
        $response = $this->delete(route('admin.restaurants.destroy', $restaurant));
        $response->assertRedirect(route('admin.restaurants.index'));
        $this->assertDatabaseMissing('restaurants', [
            'id' => $restaurant->id,
        ]);
    }
}