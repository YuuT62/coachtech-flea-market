<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Favorite;

class ItemController extends Controller
{
    // 商品一覧表示
    public function index(){
        $items=Item::get();
        $favorites=[];
        if(Auth::check()){
            $favorites=Favorite::UserSearch(Auth::id())->with('item')->get();
        }
        return view('.list.index', compact('items', 'favorites'));
    }

    public function item(Request $request){
        $item=Item::with(['condition', 'categories'])->find($request['item_id']);
        $comments=Comment::with('user')->ItemSearch($item->id)->get()->reverse();
        $favorite_count=Item::withCount('favorite')->findOrFail($item->id)->favorite_count;
        $comment_count=Item::withCount('comment')->findOrFail($item->id)->comment_count;
        return view('.detail.item', compact('item', 'comments', 'favorite_count', 'comment_count'));
    }

    public function favorite(Request $request){
        $user_id = Auth::id(); //1.ログインユーザーのid取得
        $item_id = $request->item_id; //2.投稿idの取得
        $already_favorite = Favorite::where('user_id', $user_id)->where('item_id', $item_id)->exists(); //3.

        if (!$already_favorite) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
            $favorite = new Favorite; //4.Likeクラスのインスタンスを作成
            $favorite->item_id = $item_id; //Likeインスタンスにreview_id,user_idをセット
            $favorite->user_id = $user_id;
            $favorite->save();
        } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete
            Favorite::UserSearch($user_id)->ItemSearch($item_id)->delete();
        }
        //5.この投稿の最新の総いいね数を取得
        $item_favorites_count = Item::withCount('favorite')->findOrFail($item_id)->favorite_count;
        $param = [
            'favorite_count' => $item_favorites_count,
        ];
        return response()->json($param); //6.JSONデータをjQueryに返す
    }

    public function comment(Request $request){
        $user_id = Auth::id();
        $item_id = $request['item_id'];
        $comment = $request['comment'];
        Comment::create([
            'user_id' => $user_id,
            'item_id' => $item_id,
            'comment' => $comment,
        ]);

        return redirect('/item/'. $item_id);
    }

    public function delete(Request $request){
        $item_id = $request['item_id'];
        Comment::find($request['comment_id'])->delete();

        return redirect('/item/'. $item_id);
    }
}
