<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function testHello(){
        $this->assertTrue(true);
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/no_route');
        $response->assertStatus(404);

        User::factory()->create([
            'role_id'=>'2',
            'name'=>'aaa',
            'email'=>'bbb@ccc.com',
            'password'=>'test12345',
            'user_icon'=>'',
        ]);
        $this->assertDatabaseHas('users',[
            'role_id'=>'2',
            'name'=>'aaa',
            'email'=>'bbb@ccc.com',
            'password'=>'test12345',
            'user_icon'=>'',
        ]);
    }
}
