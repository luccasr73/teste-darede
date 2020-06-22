<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Users;
use Exception;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['create']]);
    }

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
                'email.unique' => 'Este :attribute já está em uso',
                'confirm_password.required' => 'O campo confirmar senha é obrigatorio',
                'confirm_password.same' => 'As senha não são iguais',
                'password.min' => 'A senha precisa ter ao menos 8 caractares',
                'password.required' => 'A senha precisa ter ao menos 8 caractares'
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->messages()], 422);
        }

        try {
            $email = $request->input('email');
            $password = $request->input('password');
            $user = new Users;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();
            return response()->json(['data' => 'Usuario criado com sucesso'], 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ocorreu um erro ao criar o usuario'], 500);
        }
    }

    public static function findAll()
    {
        try {
            $user = Users::all();
            return response()->json(['data' => $user], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ocorreu um erro ao buscar todos os usuarios'], 500);
        }
    }

    public static function findByEmail($email)
    {
        try {
            $user = Users::where('email', $email)->first();
            return response()->json(['data' => $user], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ocorreu um erro ao buscar o usuario'], 500);
        }
    }

    public static function findById($id)
    {
        try {
            if(!is_numeric($id)){
                return response()->json(['error' => 'Formato do id invalido'], 500);
            }
            $user = Users::where('id', $id)->first();
            return response()->json(['data' => $user], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Ocorreu um erro ao buscar o usuario'], 500);
        }
    }

    public static function verifyPass($pass, $hash)
    {
        return Hash::check($pass, $hash);
    }
}
