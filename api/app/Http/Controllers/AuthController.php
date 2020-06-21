<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
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
            return response()->json(['error' => $validator->errors()->messages()], 400);
        }

        $email = $request->input('email');
        $password = $request->input('password');

        $user = UsersController::findByEmail($email);
        $user = $user->getData()->data;

        if (empty($user->email)) {
            return response()->json(['error' => 'Usuario ou senha invalidos'], 401);
        }

        if (!UsersController::verifyPass($password, $user->password)) {
            return response()->json(['error' => 'Usuario ou senha invalidos'], 401);
        }

        $credentials = ['email' => $email, 'password' => $password];

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }

        return $this->responseWithToken($token);
    }
}
