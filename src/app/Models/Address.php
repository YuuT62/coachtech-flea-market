<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable =[
        'postcode',
        'user_id',
        'prefecture',
        'city',
        'block',
        'building',
        'register',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function prefecture(){
        return $this->belongsTo(Prefecture::class);
    }

    public function purchase(){
        return $this->hasMany(Purchase::class);
    }

    public function scopeUserSearch($query, $user_id){
        if(!empty($user_id)){
            $query->where('user_id', $user_id);
        }
    }
}
