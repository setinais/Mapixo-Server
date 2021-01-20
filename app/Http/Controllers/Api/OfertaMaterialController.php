<?php

namespace App\Http\Controllers\Api;

use App\Classificacao;
use App\Http\Controllers\Controller;
use App\Localizacao;
use App\OfertaMaterial;
use App\UnidadeMedida;
use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\Storage;

class OfertaMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $oferta_all = OfertaMaterial::where('status',0)->get();
            $data = [];
            foreach ($oferta_all as $oa){
                $oa->localizacao_id = Localizacao::find($oa->localizacao_id);
                $oa->unidade_medida_id = UnidadeMedida::find($oa->unidade_medida_id)->nome;
                $oa->classificacao_id = Classificacao::find($oa->classificacao_id)->nome;
                $oa->user_id = User::find($oa->user_id);
                $oa->foto = Storage::url($oa->foto);
                $data[] = $oa;
            }

            return response()->json([
                'message'=> 'Busca Concluida',
                'errors'=> false,
                'data' => $data
            ],201);
        }catch (\Exception $e){
            return response()->json(
                [
                    'message' => 'Erro interno',
                    'errors' => true,
                    'data' => $data
                ], 500
            );
        }
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
            $unidade_medida = UnidadeMedida::where('nome', $request['unidade_medida'])->first();
            $classificacao = Classificacao::where('nome', $request['classificacao'])->first();
            $oferta = new OfertaMaterial();
            $oferta->user_id = $request->user()->id;
            $oferta->nome = $request['nome'];
            $oferta->descricao = $request['descricao'];
            $oferta->qntd =  $request['qntd'];
            $oferta->unidade_medida_id = $unidade_medida->id;
            if(isset($request['valor']))
                $oferta->valor = $request['valor'];
            $oferta->tipo_negociacao = $request['tipo_negociacao'];
//            $oferta->data_expiracao = Date
            $oferta->classificacao_id = $classificacao->id;
            $localizacao = Localizacao::create([
                'latitude' => $request['localizacao_lat'],
                'longitude' => $request['localizacao_long']
            ]);
            $oferta->localizacao_id = $localizacao->id;
            $oferta->save();

            return response()->json([
                'message'=> 'Busca Concluida',
                'errors'=> false,
                'data'=> $oferta
            ],201);
        }catch (\Exception $e){
            return response()->json(
                [
                    'message' => 'Erro interno',
                    'errors' => true,
                    'data' => $e
                ], 500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OfertaMaterial  $ofertaMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try{
            $oa = OfertaMaterial::find($id);
            $oa->localizacao_id = Localizacao::find($oa->localizacao_id);
            $oa->unidade_medida_id = UnidadeMedida::find($oa->unidade_medida_id)->nome;
            $oa->classificacao_id = Classificacao::find($oa->classificacao_id)->nome;
            $oa->user_id = User::find($oa->user_id);
//            $oa->foto = Storage::url($oa->foto);
            $oa->foto = "http://192.168.10.10/storage/".$oa->foto;


            return response()->json([
                'message'=> 'Busca Concluida',
                'errors'=> false,
                'data' => $oa
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OfertaMaterial  $ofertaMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $oferta = OfertaMaterial::find($id);

        $unidade_medida = UnidadeMedida::where('nome', $request['unidade_medida_id'])->first();
        $classificacao = Classificacao::where('nome', $request['classificacao_id'])->first();
        $oferta->nome = $request['nome'];
        $oferta->descricao = $request['descricao'];
        $oferta->qntd =  $request['qntd'];
        $oferta->unidade_medida_id = $unidade_medida->id;
        $oferta->classificacao_id = $classificacao->id;
        $oferta->tipo_negociacao = $request['tipo_negociacao'];
        $oferta->valor = $request['valor'];
        $oferta->save();

        $localizacao = Localizacao::find($oferta->localizacao_id);
        $localizacao->latitude = $request['localizacao_id']['latitude'];
        $localizacao->longitude = $request['localizacao_id']['longitude'];
        $localizacao->save();


        return response()->json([
            'message'=> 'Busca Concluida',
            'errors'=> false,
            'data'=> $oferta
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OfertaMaterial  $ofertaMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy($ofertaMaterial)
    {
        $oferta = OfertaMaterial::find($ofertaMaterial);
        $oferta->delete();
        return response()->json([
            'message'=> 'Busca Concluida',
            'errors'=> false,
            'data' => $oferta->deleted_at
        ],201);

    }
    public function uploadImage($id, Request $request)
    {

        try {
            $validator = Validator::make($request->all(),
                [
                    'user_id' => '',
                    'file' => 'required|mimes:doc,docx,pdf,txt,jpeg,png|max:2048',
                ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            if ($files = $request->file('file')) {
                //store file into document folder
                $file = $request->file->store('documents');
                //store your file into database
                $localrisco = OfertaMaterial::find($id);
                $localrisco->foto = $file;
                $localrisco->save();

                return response()->json(
                    [
                        'message' => 'Imagem Salva!',
                        'errors' => false,
                        'data' => $localrisco
                    ], 200);
            }
        }catch
            (\Exception $e){
                return response()->json(
                    [
                        'message' => 'Falha de carregamento da imagem tente novamente',
                        'errors' => true,
                        'data' => $file
                    ], 404);
            }
    }

    public function getOfertasUser(Request $request){
        try{
            $oferta_all = OfertaMaterial::where('status',0)->where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
            $data = [];
            $data['pendetes'] = [];
            $data['concluidas'] = [];
            foreach ($oferta_all as $oa){
                $oa->localizacao_id = Localizacao::find($oa->localizacao_id);
                $oa->unidade_medida_id = UnidadeMedida::find($oa->unidade_medida_id)->nome;
                $oa->classificacao_id = Classificacao::find($oa->classificacao_id)->nome;
                $oa->user_id = User::find($oa->user_id);
//                $oa->foto = Storage::url($oa->foto);
                $oa->foto = "http://192.168.10.10/storage/".$oa->foto;
                $data['pendetes'][] = $oa;
            }
            $oferta_all = OfertaMaterial::where('status',1)->where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
            foreach ($oferta_all as $oa){
                $oa->localizacao_id = Localizacao::find($oa->localizacao_id);
                $oa->unidade_medida_id = UnidadeMedida::find($oa->unidade_medida_id)->nome;
                $oa->classificacao_id = Classificacao::find($oa->classificacao_id)->nome;
                $oa->user_id = User::find($oa->user_id);
//                $oa->foto = Storage::url($oa->foto);
                $oa->foto = "http://192.168.10.10/storage/".$oa->foto;
                $data['concluidas'][] = $oa;
            }

            return response()->json([
                'message'=> 'Busca Concluida',
                'errors'=> false,
                'data' => $data
            ],201);
        }catch (\Exception $e){
            return response()->json(
                [
                    'message' => 'Erro interno',
                    'errors' => true,
                    'data' => $data
                ], 500
            );
        }
    }

    public function sucessOferta($id){
        $oferta = OfertaMaterial::find($id);
        $oferta->status = true;
        $oferta->save();

        return response()->json([
            'message'=> 'Oferta concluida com sucesso',
            'errors'=> false,
            'data' => []
        ],201);
    }
}
