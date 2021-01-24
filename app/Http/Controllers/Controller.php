<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function getUsuario(Request $request)
    {
        return [
            "usuario"       => $request->session()->get("usuario"),
            "autorizacao"   => $request->session()->get("autorizacao"),
        ];
    }

    public function permissaoUsuario($request, $chave)
    {
        $usuario = \App\Models\Autorizacao::where("USUARIO_ID", session()->get("usuario")["USUARIO_ID"])->get();
        foreach ($usuario as $key) {
            if($key->CHAVE_AUTORIZACAO == $chave){
                return true;
            }
        }

        return false;
    }
}
