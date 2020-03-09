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
        'device_name' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['As credenciais informadas estão invalidas.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:airlock')->group(function () {
    Route::namespace('Admin')->group(function(){
            // Controllers Within The "App\Http\Controllers\Admin" Namespace
        Route::prefix('admin')->group(function (){
            Route::get('users', function () {
                // Matches The "/admin/users" URL
            });
        });
    });

    Route::namespace('Admin')->group(function(){
        // Controllers Within The "App\Http\Controllers\Admin" Namespace
        Route::prefix('admin')->group(function (){
            Route::get('users', function () {
                // Matches The "/admin/users" URL
            });
        });
    });
});
