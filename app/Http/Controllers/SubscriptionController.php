<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    //createアクション

    public function create()
    {
        $intent = Auth::user()->createSetupIntent();

        return view('subscription.create', [
            'intent' => $intent,
        ]);
    }

    //storeアクション
    //price_1Pb07QRpxDmtEN7N8t9g85Au

    public function store(Request $request)
    {
        $user = $request->user();
        
        $paymentMethodId = $request->input('paymentMethodId');

        $user->newSubscription('premium_plan', 'price_1Pb07QRpxDmtEN7N8t9g85Au')
             ->create($paymentMethodId);



        return redirect()->route('home')->with('flash_message', '有料プランへの登録が完了しました。');
    }

    //editアクション
    public function edit()
    {
        $user = Auth::user();
        $intent = $user->createSetupIntent();

        return view('subscription.edit', [
            'user' => $user,
            'intent' => $intent,
        ]);
}
    //updateアクション
public function update(Request $request)
    {
        $user = $request->user();
        $paymentMethodId = $request->input('paymentMethodId');

        $user->updateDefaultPaymentMethod($paymentMethodId);

        return redirect()->route('home')->with('flash_message', 'お支払い方法を変更しました。');
    }

    //cancelアクション
    public function cancel()
    {
        return view('subscription.cancel');
    }

    //destroyアクション
    public function destroy(Request $request)
    {
        $user = $request->user();

        if ($user->subscription('premium_plan')->canceled()) {
            return redirect()->route('home')->with('flash_message', '既に有料プランを解約しています。');
        }

        $user->subscription('premium_plan')->cancelNow();

        return redirect()->route('home')->with('flash_message', '有料プランを解約しました。');
    }
}
//use Illuminate\Http\Request;

// Route::post('/user/subscribe', function (Request $request) {
//     $request->user()->newSubscription(
//         'default', 'price_monthly'
//     )->create($request->paymentMethodId);



