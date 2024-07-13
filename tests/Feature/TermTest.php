<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TermTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_access_terms_page()
    {
        $response = $this->get(route('terms.index'));
        $response->assertStatus(200);
    }

    public function test_logged_in_user_can_access_terms_page()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('terms.index'));
        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_terms_page()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('terms.index'));
        $response->assertStatus(403);
    }
}