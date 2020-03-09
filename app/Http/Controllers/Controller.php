<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $presponse;

    protected function prepare_response(string $message, array $dados, bool $erros){
        $this->presponse = response()->json([
            'message' => $message,
            'errors' => $erros,
            'data' => $dados
        ]);
    }
}
