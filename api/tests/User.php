<?php

use App\Http\Controllers\UsersController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;

class User extends TestCase
{
    use DatabaseMigrations;

    public function testCreate()
    {
        $this->json('POST', '/api/cadastrar', ['email' => 'luccasrobert@teste.com', 'password' => 'teste12345', 'confirm_password' => 'teste12345'])
            ->seeJsonStructure([
                'data'
            ])->assertResponseStatus(201);;
    }

    public function testErrorCreate()
    {
        $this->json('POST', '/api/cadastrar', ['email' => '', 'password' => 'aaaa'])
            ->seeJsonStructure([
                'error'
            ])
            ->assertResponseStatus(422);
    }

    public function testErrorCreateConfirmPass()
    {
        $this->json('POST', '/api/cadastrar', ['email' => 'teste@teste.com', 'password' => '123456789', 'confirm_password' => '12345689'])
            ->seeJsonStructure([
                'error'
            ])
            ->assertResponseStatus(422);
    }

    public function testVerifyPass()
    {
        $pass = '123';
        $hash = Hash::make($pass);
        $this->assertTrue(UsersController::verifyPass($pass, $hash));
    }

    public function testErrorVerifyPass()
    {
        $pass = '123';
        $hash = Hash::make('321');
        $this->assertFalse(UsersController::verifyPass($pass, $hash));
    }

    public function testErrorFindAll()
    {
        $user = factory('App\Users')->create(['email' => 'teste@teste.com']);
        $this->json('GET', '/api/buscar/usuarios')
            ->assertResponseStatus(401);
    }
    public function testFindAll()
    {
        $user = factory('App\Users')->create();
        $this->actingAs($user)
            ->get('/api/buscar/usuarios')
            ->seeJsonStructure(['data'])
            ->assertResponseStatus(200);
    }
    public function testErrorFindByEmail()
    {
        $user = factory('App\Users')->create(['email' => 'teste@teste.com']);
        $this->actingAs($user)
            ->get('/api/buscar/usuario/email/ç~ç~')
            ->seeJsonStructure(['data'])
            ->assertResponseStatus(200);
    }

    public function testFindByEmail()
    {
        $user = factory('App\Users')->create(['email' => 'teste@teste.com']);
        $this->actingAs($user)
            ->get('/api/buscar/usuario/email/' . $user->email)
            ->seeJsonStructure(['data'])
            ->assertResponseStatus(200);
    }

    public function testErrorFindById()
    {
        $user = factory('App\Users')->create();
        $this->actingAs($user)
            ->get('/api/buscar/usuario/id/b')
            ->seeJsonStructure(['error'])
            ->assertResponseStatus(500);
    }

    public function testFindById()
    {
        $user = factory('App\Users')->create();
        $this->actingAs($user)
            ->get('/api/buscar/usuario/id/' . $user->id)
            ->seeJsonStructure(['data'])
            ->assertResponseStatus(200);
    }
}
