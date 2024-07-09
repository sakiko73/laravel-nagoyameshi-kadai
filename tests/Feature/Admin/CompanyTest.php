<?php

namespace Tests\Feature\Admin;

use App\Models\Company;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 未ログインのユーザーは管理者側の会社概要ページにアクセスできない
     */
    public function test_guest_cannot_access_admin_company_index()
    {
        $response = $this->get(route('admin.company.index'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の会社概要ページにアクセスできない
     */
    public function test_user_cannot_access_admin_company_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('admin.company.index'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者は管理者側の会社概要ページにアクセスできる
     */
    public function test_admin_can_access_admin_company_index()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $company = Company::factory()->create();
        $response = $this->get(route('admin.company.index'));
        $response->assertOk();
    }

    /**
     * 未ログインのユーザーは管理者側の会社概要編集ページにアクセスできない
     */
    public function test_guest_cannot_access_admin_company_edit()
    {
        $company = Company::factory()->create();

        $response = $this->get(route('admin.company.edit', $company));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の会社概要編集ページにアクセスできない
     */
    public function test_user_cannot_access_admin_company_edit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create();

        $response = $this->get(route('admin.company.edit', $company));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者は管理者側の会社概要編集ページにアクセスできる
     */
    public function test_admin_can_access_admin_company_edit()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $company = Company::factory()->create();

        $response = $this->get(route('admin.company.edit', $company));
        $response->assertOk();
    }

    /**
     * 未ログインのユーザーは会社概要を更新できない
     */
    public function test_guest_cannot_update_company()
    {
        $company = Company::factory()->create();

        $response = $this->patch(route('admin.company.update', $company), [
            'name' => '更新テスト',
            'postal_code' => '1234567',
            'address' => '更新テスト',
            'representative' => '更新テスト',
            'establishment_date' => '更新テスト',
            'capital' => '更新テスト',
            'business' => '更新テスト',
            'number_of_employees' => '更新テスト',
        ]);

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは会社概要を更新できない
     */
    public function test_user_cannot_update_company()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create();

        $response = $this->patch(route('admin.company.update', $company), [
            'name' => '更新テスト',
            'postal_code' => '1234567',
            'address' => '更新テスト',
            'representative' => '更新テスト',
            'establishment_date' => '更新テスト',
            'capital' => '更新テスト',
            'business' => '更新テスト',
            'number_of_employees' => '更新テスト',
        ]);

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者は会社概要を更新できる
     */
    public function test_admin_can_update_company()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $company = Company::factory()->create();

        $response = $this->patch(route('admin.company.update', $company), [
            'name' => '更新テスト',
            'postal_code' => '1234567',
            'address' => '更新テスト',
            'representative' => '更新テスト',
            'establishment_date' => '更新テスト',
            'capital' => '更新テスト',
            'business' => '更新テスト',
            'number_of_employees' => '更新テスト',
        ]);

        $response->assertRedirect(route('admin.company.index'));
        $this->assertDatabaseHas('companies', [
            'name' => '更新テスト',
            'postal_code' => '1234567',
        ]);
    }
}