<?php

namespace App\Http\Controllers\Api;

use App\Classificacao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassificacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classificaca = [];
        foreach (Classificacao::all() as $classi){
            $classificaca[] = $classi->nome;
        }
        return response()->json([
                'message'=> 'Busca Concluida',
                'errors'=> false,
                'data'=> $classificaca
            ],201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Classificacao  $classificacao
     * @return \Illuminate\Http\Response
     */
    public function show(Classificacao $classificacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classificacao  $classificacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classificacao $classificacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classificacao  $classificacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classificacao $classificacao)
    {
        //
    }
}
