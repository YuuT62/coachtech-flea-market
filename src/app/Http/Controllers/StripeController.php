<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{

    public function success(Request $request){
        if(strpos(url()->previous(), 'success') === false){
            $secretKey = env('STRIPE_SECRET');
            $stripe = new \Stripe\StripeClient($secretKey);
            $session = $stripe->checkout->sessions->retrieve($request['session_id']);
            $item = Item::find($request['item_id']);
            Purchase::create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
                'address_id' => $request['address_id'],
                'payment_method_id' => $request['payment_method_id']
            ]);
            return view('.purchase.success', compact('session', 'item'));
        }else{
            return view('.purchase.success');
        }
    }

    public function cancel(){
        return redirect('/')->with('messages', '支払い処理がキャンセルされました。');
    }
}
