<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Autorizacao;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("site.index");
    }

    public function login()
    {
        return view("site.login");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!$this->permissaoUsuario($request, "cadastrar_clientes")){
            return redirect("/");
        }

        $id = null;
        return view("site.form_usuarios", compact("id"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        if(!$this->permissaoUsuario($request, "atualizar_clientes")){
            return redirect("/");
        }

        return view("site.form_usuarios", compact("id", "usuario", "autorizacao"));
    }


    
}
