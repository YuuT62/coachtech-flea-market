<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Role;
use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\Address;
use Illuminate\Http\UploadedFile;
use DateTime;

class ControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testController(){
        // 画像生成
        $image = UploadedFile::fake()->image('test.png');

        // ロール作成
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

        // ユーザー作成
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

        // コンディション作成
        Condition::create([
            'condition' => '新品・未使用',
        ]);

        // 商品作成
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

        // mypage
        $response = $this->actingAs($user)->get('/mypage');
        $response->assertOk();

        //edit
        $response = $this->actingAs($user)->get('/mypage/profile');
        $response->assertOk();

        // update
        $response = $this->actingAs($user)->post('/mypage/profile/update',[
            'name' => "テスト",
            'postcode' => "000-0000",
            'address' => "東京都墨田区押上1-1-2",
            "building" => "テスト",
        ]);
        $response->assertRedirect('/mypage');
        $this->assertDatabaseHas('addresses',[
            'id' => 1,
        ]);

        // index
        $response = $this->actingAs($user)->get('/');
        $response->assertOk();

        // search
        $response = $this->get('/search?keyword=テスト')->assertOk();

        // item
        $response = $this->actingAs($user)->get('/item/'.$item->id);
        $response->assertOk();

        // favorite
        $response = $this->actingAs($user)->post('/favorite',[
            'item_id' => 1,
        ]);
        $response->assertOk();

        // comment
        $response = $this->actingAs($user)->post('/item/comment',[
            'item_id' => 1,
            'comment' => "テスト"
        ]);
        $response->assertRedirect('/item/1');
        $this->assertDatabaseHas('comments',[
            'item_id' => 1,
            'comment' => "テスト"
        ]);

        // delete
        $response = $this->actingAs($user)->post('/item/comment/delete',[
            'item_id' => 1,
            'comment_id' => 1
        ]);
        $response->assertRedirect('/item/1');
        $delete_comment = Comment::where('id', 1)->get();
        $this->assertEmpty($delete_comment);

        // sell
        $response = $this->actingAs($user)->get('/sell');
        $response->assertOk();
        $response = $this->from("/")->actingAs($user)->post('/sell',[
            'item_name' => "テスト",
            'price' => 1000,
            'brand_name' => "テスト",
            'description' => "テスト",
            'condition_id' => 1,
            'item_img' => $image,
            'category' =>"テスト,テスト2",
        ]);
        $response->assertRedirect('/');

        // purchaseForm
        $response = $this->actingAs($user)->get('/purchase/'. $item->id);
        $response->assertStatus(500);

        // address
        $response = $this->actingAs($user)->get('/purchase/address/'.$item->id);
        $response->assertOk();

        // destination
        $response = $this->actingAs($user)->post('/purchase/address/destination/'.$item->id,[
            'item_id' => 1,
            'postcode' => "000-0000",
            'address' => "東京都墨田区押上1-1-2",
            "building" => "テスト",
        ]);
        $response->assertRedirect('/purchase/'. $item->id);
        $this->assertDatabaseHas('addresses',[
            'id' => 1,
        ]);

        // management
        $response = $this->actingAs($user)->get('/management');
        $response->assertStatus(403);
        $response = $this->actingAs($admin)->get('/management');
        $response->assertOk();

        // delete
        $response = $this->actingAs($admin)->post('/user/delete',[
            'user_id' => 2,
        ]);
        $response->assertRedirect('/management');
        $delete_user = User::where('id', 2)->get();
        $this->assertEmpty($delete_user);

        // send
        $response = $this->actingAs($admin)->post('/email',[
            'subject' => "テスト",
            'message' => "テスト",
        ]);
        $response->assertRedirect('/management');
    }
}
