<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Users;


class UsersController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password'
            ],
            [
                'required' => 'O campo :attribute é obrigatorio',
                'email' => 'Campo :attribute invalido',
                'email.unique' => 'Este :attribute já existe',
                'confirm_password.required' => 'O campo confirmar senha é obrigatorio',
                'confirm_password.same' => 'As senha não são iguais',
                'password.min' => 'A senha precisa ter ao menos 8 caractares',
                'password.required' => 'A senha precisa ter ao menos 8 caractares'
            ]
        );
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
        $email = $request->input('email');
        $password = $request->input('password');
        $user = new Users;
        $user->email = $email;
        $user->password = Hash::make($password);
        return $user->save();
    }

    public function findAll()
    {
        $user = Users::all();
        return $user;
    }

    public function findByEmail($email)
    {
        $user = Users::where('email', $email)->first();
        return $user;
    }

    public function verifyPass($pass, $hash)
    {
        return Hash::check($pass, $hash);
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'required' => 'O campo :attribute é obrigatorio',
                'email' => 'Campo :attribute invalido',
                'password.required' => 'A senha precisa ter ao menos 8 caractares'
            ]
        );

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $email = $request->input('email');
        $password = $request->input('password');
        $user = $this->findByEmail($email);
        if (count($user) == 0) {
            return false;
        }
        if (!$this->verifyPass($password, $user->password)) {
            return false;
        }

        return true;
    }
}
