<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Favorite;

class Item extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'item_name',
        'price',
        'brand_name',
        'description',
        'condition_id',
        'item_img',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }

    public function condition(){
        return $this->belongsTo(Condition::class);
    }

    public function purchase(){
        return $this->hasOne(Purchase::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function favorite(){
        return $this->hasMany(Favorite::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'category_items', 'item_id', 'category_id');
    }

    public function scopeUserSearch($query, $user_id){
        if(!empty($user_id)){
            $query->where('user_id', $user_id);
        }
    }

    public function isFavoriteBy($user): bool {
        return Favorite::where('user_id', $user->id)->where('item_id', $this->id)->first() !==null;
    }

    public function scopeKeywordSearch($query_item, $keyword){
        if(!empty($keyword)){
            $query_item->where('item_name', 'like', '%'.  $keyword. '%')->orWhereHas('categories', function ($query_category) use($keyword){
                $query_category->where('category', 'like', '%'. $keyword. '%');
            });
        }
    }
}
