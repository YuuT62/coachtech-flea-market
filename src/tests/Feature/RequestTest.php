<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\SellRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;


class RequestTest extends TestCase
{
    public function testCommentRequest(){
        $data_empty = [
            'comment' => ''
        ];

        $data_full= [
            'comment' => 'test'
        ];

        $request = new CommentRequest();
        $rules = $request->rules();
        $validator = Validator::make($data_empty, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $validator = Validator::make($data_full, $rules);
        $actual = $validator->passes();
        $expected = true;
        $this->assertSame($expected, $actual);
    }

    public function testProfileRequest(){
        $request = new ProfileRequest();
        $rules = $request->rules();
        $image = UploadedFile::fake()->image('test.png');

        $data = [
            'user_icon' => '',
            'name' => '',
            'postcode' => '',
            'address' => '',
            'building' => ''
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'user_icon' => $image,
            'name' => 'テスト',
            'postcode' => '000-0000',
            'address' => '東京都墨田区押上1-1-2',
            'building' => ''
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->passes();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'user_icon' => '',
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'postcode' => '000-0000',
            'address' => '東京都墨田区押上1-1-2aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'building' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->passes();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'user_icon' => '',
            'name' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'postcode' => '000-0000',
            'address' => '東京都墨田区押上1-1-2aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'building' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'user_icon' => '',
            'name' => 1,
            'postcode' => '000-0000',
            'address' => '東京都墨田区押上1-1-2',
            'building' => 1
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'user_icon' => '',
            'name' => 'テスト',
            'postcode' => '0000000',
            'address' => '東京都墨田区押上1-1-2',
            'building' => ''
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'user_icon' => '',
            'name' => 'テスト',
            'postcode' => '00a-000a',
            'address' => '東京都墨田区押上1-1-2',
            'building' => ''
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'user_icon' => '',
            'name' => 'テスト',
            'postcode' => '000-000',
            'address' => '東京都墨田区押上1-1-2',
            'building' => ''
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'user_icon' => '',
            'name' => 'テスト',
            'postcode' => '00-0000',
            'address' => '東京都墨田区押上1-1-2',
            'building' => ''
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'user_icon' => '',
            'name' => 'テスト',
            'postcode' => '000-0000',
            'address' => '東京墨田押上1-1-2',
            'building' => ''
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);


    }

    public function testSellRequest(){
        $request = new SellRequest();
        $rules = $request->rules();
        $image = UploadedFile::fake()->image('test.png');

        $data = [
            'item_img' => $image,
            'category' => '',
            'brand_name' => 'テスト',
            'condition' => 1,
            'item_name' => 'テスト',
            'description' => 'テスト',
            'price' => 1000,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テスト',
            'brand_name' => 'テスト',
            'condition' => 1,
            'item_name' => '',
            'description' => 'テスト',
            'price' => 1000,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テスト',
            'brand_name' => 'テスト',
            'condition' => 1,
            'item_name' => 'テスト',
            'description' => '',
            'price' => 1000,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テスト',
            'brand_name' => 'テスト',
            'condition' => 1,
            'item_name' => 'テスト',
            'description' => 'テスト',
            'price' => "",
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テスト',
            'brand_name' => 'テスト',
            'condition' => "",
            'item_name' => 'テスト',
            'description' => 'テスト',
            'price' => 1000,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テストカテゴリー,テスト',
            'brand_name' => 'テストブランド',
            'condition' => 1,
            'item_name' => 'テスト商品',
            'description' => 'テスト',
            'price' => 1000,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->passes();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テスト',
            'brand_name' => '',
            'condition' => 1,
            'item_name' => 'テスト',
            'description' => 'テスト',
            'price' => 120,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->passes();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テストああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ',
            'brand_name' => 'テストああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ',
            'condition' => 1,
            'item_name' => 'テストああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ',
            'description' => 'テストああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ',
            'price' => 9999999,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->passes();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テストあああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ',
            'brand_name' => 'テスト',
            'condition' => 1,
            'item_name' => 'テスト',
            'description' => 'テスト',
            'price' => 9999999,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テスト',
            'brand_name' => 'テストあああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ',
            'condition' => 1,
            'item_name' => 'テスト',
            'description' => 'テスト',
            'price' => 9999999,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テスト',
            'brand_name' => 'テスト',
            'condition' => 1,
            'item_name' => 'テストあああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ',
            'description' => 'テスト',
            'price' => 9999999,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テスト',
            'brand_name' => 'テスト',
            'condition' => 1,
            'item_name' => 'テスト',
            'description' => 'テストあああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ',
            'price' => 9999999,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テスト',
            'brand_name' => 'テスト',
            'condition' => 1,
            'item_name' => 'テスト',
            'description' => 'テスト',
            'price' => 10000000,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テスト',
            'brand_name' => 'テスト',
            'condition' => 1,
            'item_name' => 'テスト',
            'description' => 'テスト',
            'price' => 120,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->passes();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テスト',
            'brand_name' => 'テスト',
            'condition' => 1,
            'item_name' => 'テスト',
            'description' => 'テスト',
            'price' => 119,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        $data = [
            'item_img' => $image,
            'category' => 'テスト!',
            'brand_name' => 'テスト',
            'condition' => 1,
            'item_name' => 'テスト',
            'description' => 'テスト',
            'price' => 120,
        ];
        $validator = Validator::make($data, $rules);
        $actual = $validator->fails();
        $expected = true;
        $this->assertSame($expected, $actual);

        
    }
}
