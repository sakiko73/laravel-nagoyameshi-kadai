<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 未ログインのユーザーは管理者側の会員一覧ページにアクセスできない
     */
    public function test_guest_cannot_access_admin_user_index(): void
    {
        $response = $this->get('/admin/users');
        $response->assertRedirect('/admin/login');
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の会員一覧ページにアクセスできない
     */
    public function test_authenticated_user_cannot_access_admin_user_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/admin/users');
        $response->assertRedirect('/admin/login');
    }

    /**
     * ログイン済みの管理者は管理者側の会員一覧ページにアクセスできる
     */
    public function test_admin_can_access_admin_user_index(): void
    {
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'nagoyameshi',
        ]);

        $this->assertTrue(Auth::guard('admin')->check());
        $response = $this->get('/admin/users');
        $response->assertStatus(200);
    }

    /**
     * 未ログインのユーザーは管理者側の会員詳細ページにアクセスできない
     */
    public function test_guest_cannot_access_admin_user_show(): void
    {
        $response = $this->get('/admin/users/');
        $response->assertRedirect('/admin/login');
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の会員詳細ページにアクセスできない
     */
    public function test_authenticated_user_cannot_access_admin_user_show(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/admin/users/' . $user->id);
        $response->assertRedirect('/admin/login');
    }

    /**
     * ログイン済みの管理者は管理者側の会員詳細ページにアクセスできる
     */
    public function test_admin_can_access_admin_user_show(): void
    {
        $user = User::factory()->create();
        $admin = new Admin();
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('nagoyameshi');
        $admin->save();

        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'nagoyameshi',
        ]);

        $this->assertTrue(Auth::guard('admin')->check());
        $response = $this->get('/admin/users/' . $user->id);
        $response->assertStatus(200);
    }
}