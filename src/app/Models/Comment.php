<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'item_id',
        'comment',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function scopeItemSearch($query, $item_id){
        if(!empty($item_id)){
            $query->where('item_id', $item_id);
        }
    }
}
