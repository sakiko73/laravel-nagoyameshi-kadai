<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    // indexアクション（カテゴリ一覧ページ）
    /**
     * 未ログインのユーザーは管理者側のカテゴリ一覧ページにアクセスできない
     */
    public function test_guest_cannot_access_admin_category_index()
    {
        $response = $this->get(route('admin.categories.index'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは管理者側のカテゴリ一覧ページにアクセスできない
     */
    public function test_user_cannot_access_admin_category_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('admin.categories.index'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者は管理者側のカテゴリ一覧ページにアクセスできる
     */
    public function test_admin_can_access_admin_category_index()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $response = $this->get(route('admin.categories.index'));
        $response->assertOk();
    }

    // storeアクション（カテゴリ登録機能）
    /**
     * 未ログインのユーザーはカテゴリを登録できない
     */
    public function test_guest_cannot_store_category()
    {
        $response = $this->post(route('admin.categories.store'), [
            'name' => 'テストカテゴリ',
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーはカテゴリを登録できない
     */
    public function test_user_cannot_store_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('admin.categories.store'), [
            'name' => 'テストカテゴリ',
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者はカテゴリを登録できる
     */
    public function test_admin_can_store_category()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $response = $this->post(route('admin.categories.store'), [
            'name' => 'テストカテゴリ',
        ]);
        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'テストカテゴリ',
        ]);
    }

    // updateアクション（カテゴリ更新機能）
    /**
     * 未ログインのユーザーはカテゴリを更新できない
     */
    public function test_guest_cannot_update_category()
    {
        $category = Category::factory()->create();
        $response = $this->put(route('admin.categories.update', $category), [
            'name' => '更新テストカテゴリ',
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーはカテゴリを更新できない
     */
    public function test_user_cannot_update_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create();
        $response = $this->put(route('admin.categories.update', $category), [
            'name' => '更新テストカテゴリ',
        ]);
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者はカテゴリを更新できる
     */
    public function test_admin_can_update_category()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $category = Category::factory()->create();
        $response = $this->put(route('admin.categories.update', $category), [
            'name' => '更新テストカテゴリ',
        ]);
        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => '更新テストカテゴリ',
        ]);
    }

    // destroyアクション（カテゴリ削除機能）
    /**
     * 未ログインのユーザーはカテゴリを削除できない
     */
    public function test_guest_cannot_delete_category()
    {
        $category = Category::factory()->create();
        $response = $this->delete(route('admin.categories.destroy', $category));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーはカテゴリを削除できない
     */
    public function test_user_cannot_delete_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $category = Category::factory()->create();
        $response = $this->delete(route('admin.categories.destroy', $category));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者はカテゴリを削除できる
     */
    public function test_admin_can_delete_category()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $category = Category::factory()->create();
        $response = $this->delete(route('admin.categories.destroy', $category));
        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}