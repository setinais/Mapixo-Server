<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'nome' => 'required|max:255',
                'email' => 'required|email|unique:users|max:255',
                'telefone' => 'required',
                'password' => 'required|confirmed',
            ], [
                'required'    => 'O :attribute é obrigatorio.',
                'password.required'    => 'A senha é obrigatoria.',

                'email' => 'Este e-mail esta invalido.',
                'confirmed' => 'As senhas não conferem.',
                'unique'      => 'Este :attribute ja está cadastrado.',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Foram encontrados erros!',
                'errors' => true,
                'data' => $validator->errors()
            ], 422);
        }

        $user = new User();

        $user->name = $request['nome'];
        $user->email = $request['email'];
        $user->telefone = $request['telefone'];
        $user->password = Hash::make($request['password']);

        $user->save();

        return response()->json([
            'message' => 'Cadastro realizado com sucesso!',
            'errors' => false,
            'data' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $user)
    {
        //
    }
}
