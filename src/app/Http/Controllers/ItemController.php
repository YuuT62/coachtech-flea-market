<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Condition;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SellRequest;
use App\Http\Requests\CommentRequest;

class ItemController extends Controller
{
    // 商品一覧表示
    public function index(){
        $items=Item::with('purchase')->latest()->paginate(15);
        $favorites=[];
        if(Auth::check()){
            $favorites=Favorite::UserSearch(Auth::id())->with('item')->get()->reverse();
        }
        return view('.list.index', compact('items', 'favorites'));
    }

    public function search(Request $request){
        $items = Item::with('purchase')->KeywordSearch($request['keyword'])->get();
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

    public function comment(CommentRequest $request){
        $user_id = Auth::id();
        $item_id = $request['item_id'];
        $comment = $request['comment'];
        Comment::create([
            'user_id' => $user_id,
            'item_id' => $item_id,
            'comment' => $comment,
        ]);

        return redirect('/item/'. $item_id)->with('messages','コメントを投稿しました。');
    }

    public function delete(Request $request){
        $item_id = $request['item_id'];
        Comment::find($request['comment_id'])->delete();

        return redirect('/item/'. $item_id)->with('messages','コメントを削除しました。');
    }

    public function sell(){
        $conditions = Condition::all();
        return view('.form.sell', compact('conditions'));
    }

    public function add(SellRequest $request){
        $path=Storage::disk('public')->putFile('item-img', $request->file('item_img'));
        $full_path = Storage::disk('public')->url($path);

        $item = Item::create([
            'user_id' => Auth::id(),
            'item_name' => $request['item_name'],
            'price' => $request['price'],
            'brand_name' => $request['brand_name'],
            'description' => $request['description'],
            'condition_id' => $request['condition'],
            'item_img' => $full_path,
        ]);

        $categories =explode(',', $request['category']);
        foreach($categories as $category){
            if(Category::where('category', $category)->get()->isEmpty()){
                $category_create = Category::create([
                    'category' => $category
                ]);
                CategoryItem::create([
                    'item_id' => $item->id,
                    'category_id' => $category_create->id,
                ]);
            }else{
                CategoryItem::create([
                    'item_id' => $item->id,
                    'category_id' => Category::where('category', $category)->first()->id,
                ]);
            }
        }
        return redirect('/');
    }

    public function purchaseForm(Request $request){
        $item = Item::find($request['item_id']);
        if(User::find(Auth::id())->address->where('register', 1)->isNotEmpty()){
            $register_address = User::find(Auth::id())->address->where('register', 1)->first();
            return view('.purchase.purchase', compact('item', 'register_address'));
        }

        return view('.purchase.purchase', compact('item'));
    }

    public function address(Request $request){
        $item_id = $request['item_id'];
        return view('.form.destination', compact('item_id'));
    }

    public function destination(Request $request){
        $item_id = $request['item_id'];
        $user_id = Auth::id();
        $user = User::find($user_id);

        $postcode = $request['postcode'];
        $address = $request['address'];

        if (preg_match('@^(.{2,3}?[都道府県])(.+?郡.+?[町村]|.+?市.+?区|.+?[市区町村])(.+)@u', $address, $matches) == 1) {
            $address = [
                'prefecture' => $matches[1],
                'city' => $matches[2],
                'block' => $matches[3],
            ];

            if($user->address->where('postcode', $postcode)->isNotEmpty() && $user->address->where('city', $address['city'])->isNotEmpty() && $user->address->where('block', $address['block'])->isNotEmpty()){
                return redirect('/purchase/'. $item_id);
            }else{
                $destination_address= Address::create([
                    'postcode' => $postcode,
                    'user_id' => $user->id,
                    'prefecture' => $address['prefecture'],
                    'city' => $address['city'],
                    'block' => $address['block'],
                    'building' => $request['building'],
                    'register' => false,
                ]);
                $request->session()->put(['postcode' => $postcode, 'address' => $request['address'], 'building' => $request['building'], 'address_id' => $destination_address->id]);
                return redirect('/purchase/'. $item_id);
            }
        }else{
            return redirect('/purchase/'. $item_id);
        }
    }
}
