<?php

namespace Tests\Feature\Admin;

use App\Models\Term;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TermTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 未ログインのユーザーは管理者側の利用規約ページにアクセスできない
     */
    public function test_guest_cannot_access_admin_terms_index()
    {
        $response = $this->get(route('admin.terms.index'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の利用規約ページにアクセスできない
     */
    public function test_user_cannot_access_admin_terms_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.terms.index'));
        $response->assertRedirect(route('admin.login'));
    }



    /**
     * ログイン済みの管理者は管理者側の利用規約ページにアクセスできる
     */
    public function test_admin_can_access_admin_terms_index()
    {   
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        $term = Term::factory()->create();
        $response = $this->get(route('admin.terms.index'));
        $response->assertOk();
    }


    /**
     * 未ログインのユーザーは管理者側の利用規約編集ページにアクセスできない
     */
    public function test_guest_cannot_access_admin_terms_edit()
    {
        $term = Term::factory()->create();

        $response = $this->get(route('admin.terms.edit', $term));
        $response->assertRedirect(route('admin.login'));
    }


    /**
     * ログイン済みの一般ユーザーは管理者側の利用規約編集ページにアクセスできない
     */
    public function test_user_cannot_access_admin_terms_edit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $term = Term::factory()->create();

        $response = $this->get(route('admin.terms.edit', $term));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの管理者は管理者側の利用規約編集ページにアクセスできる
     */
    public function test_admin_can_access_admin_terms_edit()
    {

        $admin = Admin::factory()->create();
$this->actingAs($admin, 'admin');

        $term = Term::factory()->create();

        $response = $this->get(route('admin.terms.edit', $term));
        $response->assertOk();
    }

    /**
     * 未ログインのユーザーは利用規約を更新できない
     */
    public function test_guest_cannot_update_term()
    {
        $term = Term::factory()->create();

        $response = $this->patch(route('admin.terms.update', $term), [
            'content' => '更新テスト',
        ]);

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * ログイン済みの一般ユーザーは利用規約を更新できない
     */
    public function test_user_cannot_update_term()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $term = Term::factory()->create();

        $response = $this->patch(route('admin.terms.update', $term), [
            'content' => '更新テスト',
        ]);

        $response->assertRedirect(route('admin.login'));
    }
    

    /**
     * ログイン済みの管理者は利用規約を更新できる
     */
    public function test_admin_can_update_term()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');

        $term = Term::factory()->create();

        $response = $this->patch(route('admin.terms.update', $term), [
            'content' => '更新テスト',
        ]);

        $response->assertRedirect(route('admin.terms.index'));
        $this->assertDatabaseHas('terms', [
            'content' => '更新テスト',
        ]);
    }
 }
