<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_access_company_page()
    {
        $response = $this->get(route('company.index'));
        $response->assertStatus(200);
    }

    public function test_logged_in_user_can_access_company_page()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get(route('company.index'));
        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_company_page()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->get(route('company.index'));
        $response->assertStatus(403);
    }
}