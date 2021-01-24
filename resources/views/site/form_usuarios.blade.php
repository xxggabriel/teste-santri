<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title>santri</title>

  <link rel="stylesheet" href="/static/css/w3.css">
  <link rel="stylesheet" href="/static/css/santri.css">
  <link rel="stylesheet" href="/static/css/toastr.css">

  <link rel="stylesheet" href="/static/css-awesome/brands.css">
  <link rel="stylesheet" href="/static/css-awesome/fontawesome.css">
  <link rel="stylesheet" href="/static/css-awesome/regular.css">
  <link rel="stylesheet" href="/static/css-awesome/solid.css">
  <link rel="stylesheet" href="/static/css-awesome/svg-with-js.css">
  <link rel="stylesheet" href="/static/css-awesome/v4-shims.css">

</head>

<body>
  <script src="/static/js/jquery.js"></script>
  <div>
    <div id="lista_usuarios" class="w3-margin">

      <h4>Cadastro de usuários</h4>

      <div style="display: none;">
        <label>Usuário 1</label>
      </div>

      <div>
        <label>Nome</label>
        <input type="text" class="w3-input w3-block w3-border" id="nome" value="">
      </div>

      <div>
        <label>Login</label>
        <input type="text" class="w3-input w3-block w3-border" id="login">
      </div>

      @if(empty($id))
        <div>
          <label>Senha</label>
          <input type="password" class="w3-input w3-block w3-border" id="senha">
        </div>
      @endif
      <div>
        <label>Ativo</label>
        <input type="text" class="w3-input w3-block w3-border" id="ativo">
      </div>

      <ul>
        <li><input type="checkbox" id="cadastrar_clientes"> <label>Cadastrar clientes</label></li>
        <li><input type="checkbox" id="excluir_clientes"> <label>Excluir clientes</label></li>
        <li><input type="checkbox" id="atualizar_clientes"> <label>Atualizar clientes</label></li>
      </ul>

      <button class="w3-button w3-theme w3-margin-top w3-margin-bottom" onclick="gravar({{$id}})">Gravar</button>
      <a href="/">
        <button class="w3-button w3-theme w3-margin-top w3-margin-bottom w3-right">Cancelar</button>
      </a>

    </div>
  </div>

  <script>
    preencherCampos({{$id}})
    function gravar(id = null){
      url = "/api/usuario/criar"
      if(id){
        url = "/api/usuario/atualizar/"+id
      }
      $.ajax({
        url : url,
        method : "POST",
        data : {
          nome_completo : $("#nome").val(),
          login : $("#login").val(),
          senha : $("#senha").val(),
          ativo : $("#ativo").val(),
          chave_autorezacao : {
            "cadastrar_clientes"  : $("#cadastrar_clientes").is(':checked'),
            "atualizar_clientes"  : $("#cadastrar_clientes").is(':checked'),
            "excluir_clientes"    : $("#excluir_clientes").is(':checked'),
          }, 
        }, success : function(res){
            window.location.href = "/";
          }
      })
    }

    function preencherCampos(id = null){
      if(id){
        $.ajax({
          url : "/api/usuario/"+id,
          success : function(res){
            console.log(res)
            $("#login").val(res.data.usuario.LOGIN)
            $("#nome").val(res.data.usuario.NOME_COMPLETO)
            $("#ativo").val(res.data.usuario.ATIVO)

            res.data.autorizacao.forEach((key, value) => {
              console.log("AQUI")
              $("#"+key.CHAVE_AUTORIZACAO).attr("checked", "checked");
            });
          }
        })
      }
    }
  </script>
</body>
</html>