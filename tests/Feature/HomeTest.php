<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;


    //未ログインのユーザーは会員側のトップページにアクセスできる
    public function test_guest_can_access_home_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    //ログイン済みの一般ユーザーは会員側のトップページにアクセスできる

   
   public function test_authenticated_user_can_access_home_page()
   {
       $user = User::factory()->create();

       $this->actingAs($user);

       $response = $this->get('/');

       $response->assertStatus(200);
   }
    

    //ログイン済みの管理者は会員側のトップページにアクセスできない
    
   public function test_authenticated_admin_cannot_access_home_page()
   {
       $admin = Admin::factory()->create();

       $this->actingAs($admin, 'admin');

       $response = $this->get('/');

       $response->assertRedirect('/admin/home'); // 管理者用のリダイレクト先を適宜変更
   }

}
