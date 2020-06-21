<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
class Login extends TestCase
{
    use DatabaseMigrations;
    public function testErrorNoData()
    {
        $this->json('POST', '/api/login')
            ->seeJsonStructure([
                'error'
            ]);
    }
    public function testErrorWithoutEmail()
    {
        $this->json('POST', '/api/login', ['email' => '', 'password' => 'aaaa'])
            ->seeJsonStructure([
                'error'
            ]);
    }
    public function testErrorWithoutPass()
    {
        $this->json('POST', '/api/login', ['email' => 'luccasrobert@teste.com', 'password' => ''])
            ->seeJsonStructure([
                'error'
            ]);
    }
    public function testErrorWrongPass()
    {
        factory('App\Users')->create(['email'=>'luccasroberto@teste.com']);
        $this->json('POST', '/api/login', ['email' => 'luccasroberto@teste.com', 'password' => 'aaaa'])
            ->seeJsonStructure([
                'error'
            ]);
    }
    public function testErrorWrongEmail()
    {
        factory('App\Users')->create(['password'=>'12345678']);
        $this->json('POST', '/api/login', ['email' => 'luccasroberto@teste.com', 'password' => '12345'])
            ->seeJsonStructure([
                'error'
            ]);
    }
    public function testSuccess()
    {
        factory('App\Users')->create(['email'=>'luccasroberto@teste.com','password'=>Hash::make('12345678')]);
        $this->json('POST', '/api/login', ['email' => 'luccasroberto@teste.com', 'password' => '12345678'])
            ->seeJsonStructure([
                'token',
                'token_type',
                'expires_in'
            ]);
    }
}
