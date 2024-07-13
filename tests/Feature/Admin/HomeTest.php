<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_home_page()
    {
        $response = $this->get(route('admin.home'));
        $response->assertRedirect(route('login'));
    }

    public function test_logged_in_user_cannot_access_admin_home_page()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('admin.home'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_home_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get(route('admin.home'));
        $response->assertStatus(200);
    }
}