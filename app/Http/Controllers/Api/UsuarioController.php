<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Autorizacao;
use App\Http\Controllers\Api\UtilsController;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = Usuario::orderBy('USUARIO_ID', 'desc')->get();
        return UtilsController::retorno($usuarios);
    }

    public function login(Request $request)
    {
        $usuario = Usuario::where("login", $request->input("login"))->first();
        if(!$usuario){
            return UtilsController::retorno([], true, "Login ou senha inválido(s)");
        }

        if($usuario->SENHA !== $request->input("senha")){
            return UtilsController::retorno([], true, "Login ou senha inválido(s)");
        }

        $altorizacoes = Autorizacao::where("USUARIO_ID", $usuario->USUARIO_ID)->get();
        $request->session()->put([
            'logado' => true,
            'usuario' => $usuario,
            'autorizacao' => $altorizacoes
        ]);
        
            

        return UtilsController::retorno();
    }

    public function search(Request $request)
    {
        return UtilsController::retorno(Usuario::where('NOME_COMPLETO', 'LIKE', '%'.$request->input("busca").'%')
                                                    ->orWhere('LOGIN', 'LIKE', '%'.$request->input("busca").'%')
                                                    ->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!$this->permissaoUsuario($request, "cadastrar_clientes")){
            return UtilsController::retorno([], true, "Você não tem permissão para essa ação!");
        }

        $request->validate($this->regras(), $this->mensagem());

        $usuario = new Usuario();
        $usuario->LOGIN = strtolower($request->input("login"));
        $usuario->SENHA = $request->input("senha");
        $usuario->ATIVO = strtoupper($request->input("ativo"));
        $usuario->NOME_COMPLETO = ucwords(strtolower($request->input("nome_completo")));
        $salvo = $usuario->save();

        if(!$salvo){
            return UtilsController::retorno([], true, "Erro inesperado, tente novamente.");
        }
        
        foreach ($request->input("chave_autorezacao") as $key => $value) {
            if($value == "true"){
                $usuarioAutoracoes = new Autorizacao();
                $usuarioAutoracoes->USUARIO_ID = $usuario->USUARIO_ID;
                $usuarioAutoracoes->CHAVE_AUTORIZACAO = $key;
                $usuarioAutoracoes->save();
            }
        }

        return UtilsController::retorno($usuario);
    }

    public function regras($comSenha = true)
    {
        if($comSenha){
            return [
                "login"         => "required|string|max:30|min:4",
                "senha"         => "required|string|max:30|min:4",
                "nome_completo" => "required|string|max:100",
                "ativo"         => "string|max:1|min:1",
            ];
        } else {
            return [
                "login"         => "required|string|max:30|min:4",
                "nome_completo" => "required|string|max:100",
                "ativo"         => "string|max:1|min:1",
            ];
        }
    }

    public function mensagem()
    {
        return [
            "required"  => "O :attribute deve ser preenchido.",
            "max"       => "O :attribute deve ter no máximo :max caracteres.",
            "min"  => "O :attribute deve ter no mínimo :min caracteres.",
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = Usuario::where("USUARIO_ID", $id)->first();
        $autorizacao = Autorizacao::where("USUARIO_ID", $id)->get();
        return UtilsController::retorno([
            "usuario" => $usuario,
            "autorizacao" => $autorizacao
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!$this->permissaoUsuario($request, "atualizar_clientes")){
            return UtilsController::retorno([], true, "Você não tem permissão para essa ação!");
        }

        $request->validate($this->regras(false), $this->mensagem());
        
        $usuario = Usuario::where('USUARIO_ID', $id)->first();
        
        $usuario->LOGIN = strtolower($request->input("login"));
        $usuario->ATIVO = strtoupper($request->input("ativo"));
        $usuario->NOME_COMPLETO = ucwords(strtolower($request->input("nome_completo")));
        $salvo = $usuario->save();
        
        if(!$salvo){
            return UtilsController::retorno([], true, "Erro inesperado, tente novamente.");
        }
        
        foreach (Autorizacao::where("USUARIO_ID", $usuario->USUARIO_ID)->get() as $key) {
            $key->delete();
        }

        foreach ($request->input("chave_autorezacao") as $key => $value) {
            
            if($value == "true"){
                $usuarioAutoracoes = new Autorizacao();
                $usuarioAutoracoes->USUARIO_ID = $usuario->USUARIO_ID;
                $usuarioAutoracoes->CHAVE_AUTORIZACAO = $key;
                $usuarioAutoracoes->save();
            }
        }

        if($this->getUsuario($request)["usuario"]->USUARIO_ID == $usuario->id){
            $request->session()->put([
                'usuario' => $usuario,
                'autorizacao' => $usuarioAutoracoes
            ]);
        }
        
        return UtilsController::retorno($usuario);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        if(!$this->permissaoUsuario($request, "excluir_clientes")){
            return UtilsController::retorno([], true, "Você não tem permissão para essa ação!");
        }

        $autorizacao = Autorizacao::where("USUARIO_ID", $id)->first();
        if($autorizacao){
            $autorizacao->delete();
        }

        $usuario = Usuario::where("USUARIO_ID", $id)->first();
        if($usuario){
            $usuario->delete();
        }
        return UtilsController::retorno();
    }
}
