<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/airlock/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'token_name' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['As credenciais informadas estão invalidas.'],
        ]);
    }
    $token = $user->createToken($request->token_name)->plainTextToken;
    return response()->json(['token' => $token]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::namespace('Admin')->group(function(){
            // Controllers Within The "App\Http\Controllers\Admin" Namespace
        Route::prefix('admin')->group(function (){
            Route::get('users', function () {
                // Matches The "/admin/users" URL
            });
        });
    });

    Route::namespace('Api')->group(function(){
        // Controllers Within The "App\Http\Controllers\Admin" Namespace
        Route::prefix('user')->group(function (){
            Route::get('show', 'UserController@show')->name('user.show');
            Route::put('update', 'UserController@update')->name('user.update');
            Route::delete('delete', 'UserController@delete')->name('user.delete');
        });

        Route::apiResource('oferta', 'OfertaMaterialController');
        Route::get('classificacao', 'ClassificacaoController@index');
        Route::get('unidade_medida', 'UnidadeMedidaController@index');

        Route::post('/oferta/uploadImage/{id}', 'OfertaMaterialController@uploadImage')->name('oferta.uploadImage');
        Route::get('/getOfertasUser', 'OfertaMaterialController@getOfertasUser')->name('oferta.getOfertasUser');
        Route::get('/sucessOferta/{id}', 'OfertaMaterialController@sucessOferta')->name('oferta.sucessOferta');

        Route::apiResource('coleta_oferta', 'ColetaOfertaController');
    });
});

Route::post('user/store', 'Api\UserController@store')->name('user.store');
