<?php

namespace App\Http\Controllers\Api;

use App\ColetaOferta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColetaOfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $test = ColetaOferta::where('oferta_material_id', $request['oferta_material_id'])->get();
            if(count($test) >= 1)
                return response()->json([
                    'message'=> 'Oferta com solicitação em aberto',
                    'errors'=> false,
                ],201);
            $sc = new ColetaOferta();
            $sc->oferta_material_id = $request['oferta_material_id'];
            $sc->user_id = $request->user()->id;
            $sc->status = 'Aguardando Coleta';
            $sc->save();

            return response()->json([
                'message'=> 'Busca Concluida',
                'errors'=> false,
                'data' => $sc
            ],201);
        }catch (\Exception $e){
            return response()->json(
                [
                    'message' => 'Erro interno',
                    'errors' => true,
                    'data' => "fdafd"
                ], 500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ColetaOferta  $coletaOferta
     * @return \Illuminate\Http\Response
     */
    public function show(ColetaOferta $coletaOferta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ColetaOferta  $coletaOferta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ColetaOferta $coletaOferta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ColetaOferta  $coletaOferta
     * @return \Illuminate\Http\Response
     */
    public function destroy(ColetaOferta $coletaOferta)
    {
        //
    }
}
