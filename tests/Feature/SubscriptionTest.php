<?php

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
//use Tests\TestCase;
//use App\Models\User;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
//     public function test_example(): void
//     {
//         $response = $this->get('/');

//         $response->assertStatus(200);
//     }


//     // createアクションのテスト
//     public function test_guest_cannot_access_subscription_create_page()
//     {
//         $response = $this->get('/subscription/create');
//         $response->assertRedirect('/login');
//     }

//     public function test_free_user_can_access_subscription_create_page()
//     {
//         $user = User::factory()->create();
//         $response = $this->actingAs($user)->get('/subscription/create');
//         $response->assertStatus(200);
//     }

//     public function test_subscribed_user_cannot_access_subscription_create_page()
//     {
//         $user = User::factory()->create();
//         $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
//         $response = $this->actingAs($user)->get('/subscription/create');
//         $response->assertRedirect('/subscription/edit');
//     }

//     public function test_admin_cannot_access_subscription_create_page()
//     {
//         $admin = User::factory()->create(['is_admin' => true]);
//         $response = $this->actingAs($admin)->get('/subscription/create');
//         $response->assertRedirect('/subscription/edit');
//     }

//     // storeアクションのテスト
//     public function test_guest_cannot_subscribe_to_premium_plan()
//     {
//         $response = $this->post('/subscription/store', ['paymentMethodId' => 'pm_card_visa']);
//         $response->assertRedirect('/login');
//     }

//     public function test_free_user_can_subscribe_to_premium_plan()
//     {
//         $user = User::factory()->create();
//         $response = $this->actingAs($user)->post('/subscription/store', ['paymentMethodId' => 'pm_card_visa']);
//         $user->refresh();
//         $response->assertRedirect('/home');
//         $this->assertTrue($user->subscribed('premium_plan'));
//     }

//     public function test_subscribed_user_cannot_subscribe_to_premium_plan()
//     {
//         $user = User::factory()->create();
//         $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
//         $response = $this->actingAs($user)->post('/subscription/store', ['paymentMethodId' => 'pm_card_visa']);
//         $response->assertRedirect('/subscription/edit');
//     }

//     public function test_admin_cannot_subscribe_to_premium_plan()
//     {
//         $admin = User::factory()->create(['is_admin' => true]);
//         $response = $this->actingAs($admin)->post('/subscription/store', ['paymentMethodId' => 'pm_card_visa']);
//         $response->assertRedirect('/subscription/edit');
//     }

//     // editアクションのテスト
//     public function test_guest_cannot_access_subscription_edit_page()
//     {
//         $response = $this->get('/subscription/edit');
//         $response->assertRedirect('/login');
//     }

//     public function test_free_user_cannot_access_subscription_edit_page()
//     {
//         $user = User::factory()->create();
//         $response = $this->actingAs($user)->get('/subscription/edit');
//         $response->assertRedirect('/subscription/create');
//     }

//     public function test_subscribed_user_can_access_subscription_edit_page()
//     {
//         $user = User::factory()->create();
//         $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
//         $response = $this->actingAs($user)->get('/subscription/edit');
//         $response->assertStatus(200);
//     }

//     public function test_admin_cannot_access_subscription_edit_page()
//     {
//         $admin = User::factory()->create(['is_admin' => true]);
//         $response = $this->actingAs($admin)->get('/subscription/edit');
//         $response->assertRedirect('/subscription/create');
//     }

//     // updateアクションのテスト
//     public function test_guest_cannot_update_payment_method()
//     {
//         $response = $this->patch('/subscription/update', ['paymentMethodId' => 'pm_card_mastercard']);
//         $response->assertRedirect('/login');
//     }

//     public function test_free_user_cannot_update_payment_method()
//     {
//         $user = User::factory()->create();
//         $response = $this->actingAs($user)->patch('/subscription/update', ['paymentMethodId' => 'pm_card_mastercard']);
//         $response->assertRedirect('/subscription/create');
//     }

//     public function test_subscribed_user_can_update_payment_method()
//     {
//         $user = User::factory()->create();
//         $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
//         $oldPaymentMethodId = $user->defaultPaymentMethod()->id;

//         $response = $this->actingAs($user)->patch('/subscription/update', ['paymentMethodId' => 'pm_card_mastercard']);
//         $user->refresh();
//         $newPaymentMethodId = $user->defaultPaymentMethod()->id;

//         $response->assertRedirect('/home');
//         $this->assertNotEquals($oldPaymentMethodId, $newPaymentMethodId);
//     }

//     public function test_admin_cannot_update_payment_method()
//     {
//         $admin = User::factory()->create(['is_admin' => true]);
//         $response = $this->actingAs($admin)->patch('/subscription/update', ['paymentMethodId' => 'pm_card_mastercard']);
//         $response->assertRedirect('/subscription/create');
//     }

//     // cancelアクションのテスト
//     public function test_guest_cannot_access_subscription_cancel_page()
//     {
//         $response = $this->get('/subscription/cancel');
//         $response->assertRedirect('/login');
//     }

//     public function test_free_user_cannot_access_subscription_cancel_page()
//     {
//         $user = User::factory()->create();
//         $response = $this->actingAs($user)->get('/subscription/cancel');
//         $response->assertRedirect('/subscription/create');
//     }

//     public function test_subscribed_user_can_access_subscription_cancel_page()
//     {
//         $user = User::factory()->create();
//         $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
//         $response = $this->actingAs($user)->get('/subscription/cancel');
//         $response->assertStatus(200);
//     }

//     public function test_admin_cannot_access_subscription_cancel_page()
//     {
//         $admin = User::factory()->create(['is_admin' => true]);
//         $response = $this->actingAs($admin)->get('/subscription/cancel');
//         $response->assertRedirect('/subscription/create');
//     }

//     // destroyアクションのテスト
//     public function test_guest_cannot_cancel_subscription()
//     {
//         $response = $this->delete('/subscription/destroy');
//         $response->assertRedirect('/login');
//     }

//     public function test_free_user_cannot_cancel_subscription()
//     {
//         $user = User::factory()->create();
//         $response = $this->actingAs($user)->delete('/subscription/destroy');
//         $response->assertRedirect('/subscription/create');
//     }

//     public function test_subscribed_user_can_cancel_subscription()
//     {
//         $user = User::factory()->create();
//         $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');

//         $response = $this->actingAs($user)->delete('/subscription/destroy');
//         $user->refresh();

//         $response->assertRedirect('/home');
//         $this->assertFalse($user->subscribed('premium_plan'));
//     }

//     public function test_admin_cannot_cancel_subscription()
//     {
//         $admin = User::factory()->create(['is_admin' => true]);
//         $response = $this->actingAs($admin)->delete('/subscription/destroy');
//         $response->assertRedirect('/subscription/create');
//     }
// }
use RefreshDatabase;
 
     // 未ログインのユーザーは有料プラン登録ページにアクセスできない
     public function test_guest_cannot_access_subscription_create()
     {
         $response = $this->get(route('subscription.create'));
 
         $response->assertRedirect(route('login'));
     }
 
     // ログイン済みの無料会員は有料プラン登録ページにアクセスできる
     public function test_free_user_can_access_subscription_create()
     {
         $user = User::factory()->create();
 
         $response = $this->actingAs($user)->get(route('subscription.create'));
 
         $response->assertStatus(200);
     }
 
     // ログイン済みの有料会員は有料プラン登録ページにアクセスできない
     public function test_premium_user_cannot_access_subscription_create()
     {
         $user = User::factory()->create();
         $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
 
         $response = $this->actingAs($user)->get(route('subscription.create'));
 
         $response->assertRedirect(route('subscription.edit'));
     }
 
     // ログイン済みの管理者は有料プラン登録ページにアクセスできない
     public function test_admin_cannot_access_subscription_create()
     {
         $admin = new Admin();
         $admin->email = 'admin@example.com';
         $admin->password = Hash::make('nagoyameshi');
         $admin->save();
 
         $response = $this->actingAs($admin, 'admin')->get(route('subscription.create'));
 
         $response->assertRedirect(route('admin.home'));
     }
 
     // 未ログインのユーザーは有料プランに登録できない
     public function test_guest_cannot_access_subscription_store()
     {
         $request_parameter = [
             'paymentMethodId' => 'pm_card_visa'
         ];
 
         $response = $this->post(route('subscription.store'), $request_parameter);
 
         $response->assertRedirect(route('login'));
     }
 
     // ログイン済みの無料会員は有料プランに登録できる
     public function test_free_user_can_access_subscription_store()
     {
         $user = User::factory()->create();
 
         $request_parameter = [
             'paymentMethodId' => 'pm_card_visa'
         ];
 
         $response = $this->actingAs($user)->post(route('subscription.store'), $request_parameter);
 
         $response->assertRedirect(route('home'));
 
         $user->refresh();
         $this->assertTrue($user->subscribed('premium_plan'));
     }
 
     // ログイン済みの有料会員は有料プランに登録できない
     public function test_premium_user_cannot_access_subscription_store()
     {
         $user = User::factory()->create();
         $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
 
         $request_parameter = [
             'paymentMethodId' => 'pm_card_visa'
         ];
 
         $response = $this->actingAs($user)->post(route('subscription.store'), $request_parameter);
 
         $response->assertRedirect(route('subscription.edit'));
     }
 
     // ログイン済みの管理者は有料プランに登録できない
     public function test_admin_cannot_access_subscription_store()
     {
         $admin = new Admin();
         $admin->email = 'admin@example.com';
         $admin->password = Hash::make('nagoyameshi');
         $admin->save();
 
         $request_parameter = [
             'paymentMethodId' => 'pm_card_visa'
         ];
 
         $response = $this->actingAs($admin, 'admin')->post(route('subscription.store'), $request_parameter);
 
         $response->assertRedirect(route('admin.home'));
     }
 
     // 未ログインのユーザーはお支払い方法編集ページにアクセスできない
     public function test_guest_cannot_access_subscription_edit()
     {
         $response = $this->get(route('subscription.edit'));
 
         $response->assertRedirect(route('login'));
     }
 
     // ログイン済みの無料会員はお支払い方法編集ページにアクセスできない
     public function test_free_user_cannot_access_subscription_edit()
     {
         $user = User::factory()->create();
 
         $response = $this->actingAs($user)->get(route('subscription.edit'));
 
         $response->assertRedirect(route('subscription.create'));
     }
 
     // ログイン済みの有料会員はお支払い方法編集ページにアクセスできる
     public function test_premium_user_can_access_subscription_edit()
     {
         $user = User::factory()->create();
         $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
 
         $response = $this->actingAs($user)->get(route('subscription.edit'));
 
         $response->assertStatus(200);
     }
 
     // ログイン済みの管理者はお支払い方法編集ページにアクセスできない
     public function test_admin_cannot_access_subscription_edit()
     {
         $admin = new Admin();
         $admin->email = 'admin@example.com';
         $admin->password = Hash::make('nagoyameshi');
         $admin->save();
 
         $response = $this->actingAs($admin, 'admin')->get(route('subscription.edit'));
 
         $response->assertRedirect(route('admin.home'));
     }
 
     // 未ログインのユーザーはお支払い方法を更新できない
     public function test_guest_cannot_access_subscription_update()
     {
         $request_parameter = [
             'paymentMethodId' => 'pm_card_mastercard'
         ];
 
         $response = $this->patch(route('subscription.update'), $request_parameter);
 
         $response->assertRedirect(route('login'));
     }
 
     // ログイン済みの無料会員はお支払い方法を更新できない
     public function test_free_user_cannot_access_subscription_update()
     {
         $user = User::factory()->create();
 
         $request_parameter = [
             'paymentMethodId' => 'pm_card_mastercard'
         ];
 
         $response = $this->actingAs($user)->patch(route('subscription.update'), $request_parameter);
 
         $response->assertRedirect(route('subscription.create'));
     }
 
     // ログイン済みの有料会員はお支払い方法を更新できる
     public function test_premium_user_can_access_subscription_update()
     {
         $user = User::factory()->create();
         $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
 
         $original_payment_method_id = $user->defaultPaymentMethod()->id;
 
         $request_parameter = [
             'paymentMethodId' => 'pm_card_mastercard'
         ];
 
         $response = $this->actingAs($user)->patch(route('subscription.update'), $request_parameter);
 
         $response->assertRedirect(route('home'));
 
         $user->refresh();
         $this->assertNotEquals($original_payment_method_id, $user->defaultPaymentMethod()->id);
     }
 
     // ログイン済みの管理者はお支払い方法を更新できない
     public function test_admin_cannot_access_subscription_update()
     {
         $admin = new Admin();
         $admin->email = 'admin@example.com';
         $admin->password = Hash::make('nagoyameshi');
         $admin->save();
 
         $request_parameter = [
             'paymentMethodId' => 'pm_card_mastercard'
         ];
 
         $response = $this->actingAs($admin, 'admin')->patch(route('subscription.update'), $request_parameter);
 
         $response->assertRedirect(route('admin.home'));
     }
 
     // 未ログインのユーザーは有料プラン解約ページにアクセスできない
     public function test_guest_cannot_access_subscription_cancel()
     {
         $response = $this->get(route('subscription.cancel'));
 
         $response->assertRedirect(route('login'));
     }
 
     // ログイン済みの無料会員は有料プラン解約ページにアクセスできない
     public function test_free_user_cannot_access_subscription_cancel()
     {
         $user = User::factory()->create();
 
         $response = $this->actingAs($user)->get(route('subscription.cancel'));
 
         $response->assertRedirect(route('subscription.create'));
     }
 
     // ログイン済みの有料会員は有料プラン解約ページにアクセスできる
     public function test_premium_user_can_access_subscription_cancel()
     {
         $user = User::factory()->create();
         $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
 
         $response = $this->actingAs($user)->get(route('subscription.cancel'));
 
         $response->assertStatus(200);
     }
 
     // ログイン済みの管理者は有料プラン解約ページにアクセスできない
     public function test_admin_cannot_access_subscription_cancel()
     {
         $admin = new Admin();
         $admin->email = 'admin@example.com';
         $admin->password = Hash::make('nagoyameshi');
         $admin->save();
 
         $response = $this->actingAs($admin, 'admin')->get(route('subscription.cancel'));
 
         $response->assertRedirect(route('admin.home'));
     }
 
     // 未ログインのユーザーは有料プランを解約できない
     public function test_guest_cannot_access_subscription_destroy()
     {
         $response = $this->delete(route('subscription.destroy'));
 
         $response->assertRedirect(route('login'));
     }
 
     // ログイン済みの無料会員は有料プランを解約できない
     public function test_free_user_cannot_access_subscription_destroy()
     {
         $user = User::factory()->create();
 
         $response = $this->actingAs($user)->delete(route('subscription.destroy'));
 
         $response->assertRedirect(route('subscription.create'));
     }
 
     // ログイン済みの有料会員は有料プランを解約できる
     public function test_premium_user_can_access_subscription_destroy()
     {
         $user = User::factory()->create();
         $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')->create('pm_card_visa');
 
         $response = $this->actingAs($user)->delete(route('subscription.destroy'));
 
         $response->assertRedirect(route('home'));
 
         $user->refresh();
         $this->assertFalse($user->subscribed('premium_plan'));
     }
 
     // ログイン済みの管理者は有料プランを解約できない
     public function test_admin_cannot_access_subscription_destroy()
     {
         $admin = new Admin();
         $admin->email = 'admin@example.com';
         $admin->password = Hash::make('nagoyameshi');
         $admin->save();
 
         $response = $this->actingAs($admin, 'admin')->delete(route('subscription.destroy'));
 
         $response->assertRedirect(route('admin.home'));
     }
}
