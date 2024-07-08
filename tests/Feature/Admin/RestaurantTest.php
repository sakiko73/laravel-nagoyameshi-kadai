<?php

namespace Tests\Feature\Admin;

use App\Models\Restaurant;
use App\Models\User;
use App\Models\Admin;
use App\Models\Category;
use App\Models\RegularHoliday;
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
        // カテゴリのダミーデータを3つ作成し、それらのIDの配列を定義する
        $category1 = Category::create(['name' => 'カテゴリ1']);
        $category2 = Category::create(['name' => 'カテゴリ2']);
        $category3 = Category::create(['name' => 'カテゴリ3']);
        $category_ids = [$category1->id, $category2->id, $category3->id];

        // 定休日のダミーデータを3つ作成し、それらのIDの配列を定義する
        $regularHolidays = RegularHoliday::factory()->count(3)->create();
        $regular_holiday_ids = $regularHolidays->pluck('id')->toArray();

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
            'category_ids' => $category_ids,
            'regular_holiday_ids' => $regular_holiday_ids,
        ]);

        // レスポンスがリダイレクトであることを確認
        $response->assertRedirect(route('admin.login'));

        // データベースにレストランが存在しないことを確認
        $this->assertDatabaseMissing('restaurants', [
            'name' => 'テスト',
            'description' => 'テスト',
        ]);
    }

    /**
     * ログイン済みの一般ユーザーは店舗を登録できない
     */
    public function test_user_cannot_store_restaurant()
    {
        // カテゴリのダミーデータを3つ作成し、それらのIDの配列を定義する
        $category1 = Category::create(['name' => 'カテゴリ1']);
        $category2 = Category::create(['name' => 'カテゴリ2']);
        $category3 = Category::create(['name' => 'カテゴリ3']);
        $category_ids = [$category1->id, $category2->id, $category3->id];

        // 定休日のダミーデータを3つ作成し、それらのIDの配列を定義する
        $regularHolidays = RegularHoliday::factory()->count(3)->create();
        $regular_holiday_ids = $regularHolidays->pluck('id')->toArray();

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
            'category_ids' => $category_ids,
            'regular_holiday_ids' => $regular_holiday_ids,
        ]);
        $response->assertRedirect(route('admin.login'));

        // データベースにレストランが存在しないことを確認
        $this->assertDatabaseMissing('restaurants', [
            'name' => 'テスト',
            'description' => 'テスト',
        ]);
    }

    /**
     * ログイン済みの管理者は店舗を登録できる
     */
    public function test_admin_can_store_restaurant()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        // カテゴリのダミーデータを3つ作成し、それらのIDの配列を定義する
        $category1 = Category::create(['name' => 'カテゴリ1']);
        $category2 = Category::create(['name' => 'カテゴリ2']);
        $category3 = Category::create(['name' => 'カテゴリ3']);
        $category_ids = [$category1->id, $category2->id, $category3->id];

        // 定休日のダミーデータを3つ作成し、それらのIDの配列を定義する
        $regularHolidays = RegularHoliday::factory()->count(3)->create();
        $regular_holiday_ids = $regularHolidays->pluck('id')->toArray();

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
            'category_ids' => $category_ids,
            'regular_holiday_ids' => $regular_holiday_ids,
        ]);
        // レスポンスがリダイレクトであることを確認
        $response->assertRedirect(route('admin.restaurants.index'));
        // データベースにレストランが存在しないことを確認
        $this->assertDatabaseHas('restaurants', [
            'name' => 'テスト',
            'description' => 'テスト',
        ]);
        // データベースcategory_restaurantにcategory_idsが存在しないことを確認
        $restaurant = Restaurant::where('name', 'テスト')->first();
        foreach ($category_ids as $category_id) {
            $this->assertDatabaseHas('category_restaurant', [
                'category_id' => $category_id,
                'restaurant_id' => $restaurant->id,
            ]);
        }

        // データベースregular_holiday_restaurantにregular_holiday_idsが存在しないことを確認
        foreach ($regular_holiday_ids as $regular_holiday_id) {
            $this->assertDatabaseHas('regular_holiday_restaurant', [
                'regular_holiday_id' => $regular_holiday_id,
                'restaurant_id' => $restaurant->id,
            ]);
        }
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

        // カテゴリのダミーデータを3つ作成し、それらのIDの配列を定義する
        $category1 = Category::create(['name' => 'カテゴリ1']);
        $category2 = Category::create(['name' => 'カテゴリ2']);
        $category3 = Category::create(['name' => 'カテゴリ3']);
        $category_ids = [$category1->id, $category2->id, $category3->id];

        // 定休日のダミーデータを3つ作成し、それらのIDの配列を定義する
        $regularHolidays = RegularHoliday::factory()->count(3)->create();
        $regular_holiday_ids = $regularHolidays->pluck('id')->toArray();

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
            'category_ids' => $category_ids,
            'regular_holiday_ids' => $regular_holiday_ids,
        ]);
        $response->assertRedirect(route('admin.login'));
        // データベースにレストランが存在しないことを確認
        $this->assertDatabaseMissing('restaurants', [
            'name' => '更新テスト',
            'description' => '更新テスト',
        ]);
        // データベースcategory_restaurantにcategory_idsが存在しないことを確認
        foreach ($category_ids as $category_id) {
            $this->assertDatabaseMissing('category_restaurant', [
                'category_id' => $category_id,
                'restaurant_id' => $restaurant->id,
            ]);
        }
        // データベースregular_holiday_restaurantにregular_holiday_idsが存在しないことを確認
        foreach ($regular_holiday_ids as $regular_holiday_id) {
            $this->assertDatabaseMissing('regular_holiday_restaurant', [
                'regular_holiday_id' => $regular_holiday_id,
                'restaurant_id' => $restaurant->id,
            ]);
        }
    }

    /**
     * ログイン済みの一般ユーザーは店舗を更新できない
     */
    public function test_user_cannot_update_restaurant()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $restaurant = Restaurant::factory()->create();

        // カテゴリのダミーデータを3つ作成し、それらのIDの配列を定義する
        $category1 = Category::create(['name' => 'カテゴリ1']);
        $category2 = Category::create(['name' => 'カテゴリ2']);
        $category3 = Category::create(['name' => 'カテゴリ3']);
        $category_ids = [$category1->id, $category2->id, $category3->id];

        // 定休日のダミーデータを3つ作成し、それらのIDの配列を定義する
        $regularHolidays = RegularHoliday::factory()->count(3)->create();
        $regular_holiday_ids = $regularHolidays->pluck('id')->toArray();

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
            'regular_holiday_ids' => $regular_holiday_ids,
        ]);
        $response->assertRedirect(route('admin.login'));
        // データベースにレストランが存在しないことを確認
        $this->assertDatabaseMissing('restaurants', [
            'name' => '更新テスト',
            'description' => '更新テスト',
        ]);
        // データベースcategory_restaurantにcategory_idsが存在しないことを確認
        foreach ($category_ids as $category_id) {
            $this->assertDatabaseMissing('category_restaurant', [
                'category_id' => $category_id,
                'restaurant_id' => $restaurant->id,
            ]);
        }
        // データベースregular_holiday_restaurantにregular_holiday_idsが存在しないことを確認
        foreach ($regular_holiday_ids as $regular_holiday_id) {
            $this->assertDatabaseMissing('regular_holiday_restaurant', [
                'regular_holiday_id' => $regular_holiday_id,
                'restaurant_id' => $restaurant->id,
            ]);
        }
    }

    /**
     * ログイン済みの管理者は店舗を更新できる
     */
    public function test_admin_can_update_restaurant()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $restaurant = Restaurant::factory()->create();

        // カテゴリのダミーデータを3つ作成し、それらのIDの配列を定義する
        $category1 = Category::create(['name' => 'カテゴリ1']);
        $category2 = Category::create(['name' => 'カテゴリ2']);
        $category3 = Category::create(['name' => 'カテゴリ3']);
        $category_ids = [$category1->id, $category2->id, $category3->id];

        // 定休日のダミーデータを3つ作成し、それらのIDの配列を定義する
        $regularHolidays = RegularHoliday::factory()->count(3)->create();
        $regular_holiday_ids = $regularHolidays->pluck('id')->toArray();

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
            'category_ids' => $category_ids,
            'regular_holiday_ids' => $regular_holiday_ids,
        ]);
        $response->assertRedirect(route('admin.restaurants.index'));
        $this->assertDatabaseHas('restaurants', [
            'name' => '更新テスト',
            'description' => '更新テスト',
        ]);
        // データベースcategory_restaurantにcategory_idsが存在しないことを確認
        foreach ($category_ids as $category_id) {
            $this->assertDatabaseHas('category_restaurant', [
                'category_id' => $category_id,
                'restaurant_id' => $restaurant->id,
            ]);
        }
        // データベースregular_holiday_restaurantにregular_holiday_idsが存在しないことを確認
        foreach ($regular_holiday_ids as $regular_holiday_id) {
            $this->assertDatabaseHas('regular_holiday_restaurant', [
                'regular_holiday_id' => $regular_holiday_id,
                'restaurant_id' => $restaurant->id,
            ]);
        }
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