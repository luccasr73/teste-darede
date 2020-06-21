<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Users;
class UsersController extends Controller
{
    public function validateData(Request $request){
        return $this->validate($request, [
            'password' => 'required',
            'email' => 'required|email|unique:users'
        ]);
    }

    public function create(Request $request){

        $this->validateData($request);
        $email = $request->input('email');
        $password = $request->input('password');
        $user = new Users;
        $user->email = $email;
        $user->password = Hash::make($password);
        return $user->save();
    }

    public function findAll(){
        $user = Users::all();
        return $user;
    }

    public function findByEmail($email){
        $user = Users::where('email', $email)->first();
        return $user;
    }

    public function verifyPass($pass, $hash){
        return Hash::check($pass, $hash);
    }

    public function login($email, $pass){
        $user = $this->findByEmail($email);
        if(count($user)==0){
            return false;
        }
        if(!$this->verifyPass($pass,$user->password)){
            return false;
        }

        return true;
    }
}
