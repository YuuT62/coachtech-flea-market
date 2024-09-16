<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function mypage(){
        $user=Auth::user();
        $items=Item::UserSearch($user->id)->get();
        return view('.list.mypage', compact('user', 'items'));
    }

    public function edit(){
        $user_id=Auth::id();
        $user=User::find($user_id);
        if($user->address->where('register', 1)->isEmpty()){
            return view('.form.profile', compact('user'));
        }else{
            $address=$user->address->where('register', 1)->first();
            return view('.form.profile', compact('user', 'address'));
        }
    }

    public function update(Request $request){
        $user_id = Auth::id();
        $user = User::find($user_id);
        if($request->file('user_icon') !== null && $request['name'] !== null && $request['name'] !== $user->name){
            $path=Storage::disk('public')->putFile('user-icon', $request->file('user_icon'));
            $full_path = Storage::disk('public')->url($path);
            $user->update([
            'name' => $request['name'],
            'user_icon' => $full_path,
            ]);
        }elseif($request->file('user_icon') !== null){
            $path=Storage::disk('public')->putFile('user-icon', $request->file('user_icon'));
            $full_path = Storage::disk('public')->url($path);
            $user->update([
            'user_icon' => $full_path,
            ]);
        }elseif($request['name'] !== null && $request['name'] !== $user->name){
            $user->update([
            'name' => $request['name'],
            ]);
        }


        $postcode = $request['postcode'];
        $address = $request['address'];

        if (preg_match('@^(.{2,3}?[都道府県])(.+?郡.+?[町村]|.+?市.+?区|.+?[市区町村])(.+)@u', $address, $matches) == 1) {
            $address = [
                'prefecture' => $matches[1],
                'city' => $matches[2],
                'block' => $matches[3],
            ];

            if($user->address->where('register', 1)->isEmpty()){
            Address::create([
                'postcode' => $postcode,
                'user_id' => $user->id,
                'prefecture' => $address['prefecture'],
                'city' => $address['city'],
                'block' => $address['block'],
                'building' => $request['building'],
                'register' => true,
            ]);
            }else{
                Address::UserSearch($user_id)->where('register', 1)->update([
                    'postcode' => $postcode,
                    'user_id' => $user_id,
                    'prefecture' => $address['prefecture'],
                    'city' => $address['city'],
                    'block' => $address['block'],
                    'building' => $request['building'],
                    'register' => true,
                ]);
            }
        }
        return redirect('/mypage');

    }
}

