<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Role;
use App\Models\Condition;
use DateTime;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ManagementController;

class ViewTest extends TestCase
{
    use RefreshDatabase;

    public function testUserView(){
        Role::create([
            'score' => 100
        ]);
        $this->assertDatabaseHas('roles',[
            'score' => 100
        ]);
        Role::create([
            'score' => 1
        ]);
        $this->assertDatabaseHas('roles',[
            'score' => 1
        ]);

        $data_admin = [
            'role_id' => 1,
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'P@ssw0rd',
            'email_verified_at' => new DateTime('2024-01-01'),
            'user_icon' => '',
        ];
        $admin = User::factory()->create($data_admin);
        $this->assertDatabaseHas('users',[
            'role_id' => 1,
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'P@ssw0rd',
            'user_icon' => '',
        ]);

        $data_user = [
            'role_id' => 2,
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => 'P@ssw0rd',
            'email_verified_at' => new DateTime('2024-01-01'),
            'user_icon' => '',
        ];
        $user = User::factory()->create($data_user);
        $this->assertDatabaseHas('users',[
            'role_id' => 2,
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => 'P@ssw0rd',
            'user_icon' => '',
        ]);

        Condition::create([
            'condition' => '新品・未使用',
        ]);
        $this->assertDatabaseHas('conditions',[
            'condition' => '新品・未使用',
        ]);

        $data_item = [
            'user_id' => 2,
            'item_name' => 'テスト商品',
            'price' => 1000,
            'brand_name' => 'テストブランド',
            'description' => 'テストデータの説明',
            'condition_id' => 1,
            'item_img' => 'http://localhost/storage/img/test_image.png',
        ];
        $item = Item::create($data_item);
        $this->assertDatabaseHas('items',[
            'user_id' => 2,
            'item_name' => 'テスト商品',
            'price' => 1000,
            'brand_name' => 'テストブランド',
            'description' => 'テストデータの説明',
            'condition_id' => 1,
            'item_img' => 'http://localhost/storage/img/test_image.png',
        ]);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/item/'.$item->id);
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/mypage');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/mypage/profile');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/sell');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/purchase/'. $item->id);
        $response->assertStatus(500);

        $response = $this->actingAs($user)->get('/purchase/address/'.$item->id);
        $response->assertStatus(200);


        $response = $this->actingAs($user)->get('/management');
        $response->assertStatus(403);

        $response = $this->actingAs($admin)->get('/management');
        $response->assertStatus(200);

    }

}
