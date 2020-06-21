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
            $this->throwValidationException($request, $validator);
        }

        $email = $request->input('email');
        $password = $request->input('password');

        $user = UsersController::findByEmail($email);
        if (empty($user)) {
            return response('Usuario ou senha não invalidos', 400);
        }

        if (!UsersController::verifyPass($password, $user->password)) {
            return response('Usuario ou senha não invalidos', 400);
        }

        $credentials = ['email' => $email, 'password' => $password];

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Não autorizado'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Deslogado'], 200);
    }
}
