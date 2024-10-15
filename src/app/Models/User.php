<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'user_icon'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function address(){
        return $this->hasMany(Address::class);
    }

    public function item(){
        return $this->hasMany(Item::class);
    }

    public function items(){
        return $this->belongsToMany(Item::class, 'favorites', 'user_id', 'item_id');
    }

    public function purchase(){
        return $this->hasMany(Purchase::class);
    }

    public function message(){
        return $this->hasMany(Message::class);
    }

    public function scopeRoleSearch($query, $role_id){
        if(!empty($role_id)){
            $query->where('role_id', $role_id);
        }
    }
}
