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

    <style>
      table {
        border-collapse: collapse;
        width: 100%;
      }

      th, td {
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #ddd;
      }

      tr:nth-child(even) {background-color: #f2f2f2;}
    </style>

  </head>
  <body>
    <script src="/static/js/jquery.js"></script>
    <div>
      <div id="lista_usuarios" class="w3-margin">
        <input class="w3-input w3-border w3-margin-top" type="text" placeholder="Nome" id="busca">
        <button class="w3-button w3-theme w3-margin-top" onclick="busca()">Buscar</button>
        <a href="/criar">
          <button class="w3-button w3-theme w3-margin-top w3-right">Cadastrar novo usuário</button>
        </a>

        <table>
          <thead>
            <tr>
              <th>Nome</td>
              <th>Login</td>
              <th>Ativo</td>
              <th>Opções</td>  
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>

      </div>
    </div>
  </body>

  
  <script>
    $.ajax({
      url : "/api/usuario",
      method : "GET",
      success : function(res){
        if(res.error){
          alert(res.message)
        }

        res.data.forEach(usuario => {
          var ativo = "Não"
          if(usuario.ATIVO == 'S'){
            ativo = "Sim"
          }
          $("tbody").append(`
              <tr id="user-${usuario.USUARIO_ID}">
                <td>${usuario.NOME_COMPLETO}</td>
                <td>${usuario.LOGIN}</td>
                <td>${ativo}</td>
                <td>
                  <a href="/atualizar/${usuario.USUARIO_ID}">
                    <button class="w3-button w3-theme w3-margin-top"><i class="fas fa-edit"></i></button>
                  </a>
                  <button class="w3-button w3-theme w3-margin-top" onclick="excluirUsuario(${usuario.USUARIO_ID})"><i class="fas fa-user-times"></i></button>
                </td>
              </tr>
          `);
        });
      }
    })

    function excluirUsuario(id)
    {
      $.ajax({
        url : "/api/usuario/excluir/"+id,
        method : "POST",
        success : function(res){
          if(res.error){
            alert(res.message)
          }

          if(!res.error){
            $(`#user-${id}`).remove();
          }
        }
      })
    }

    function busca()
    {
      $.ajax({
        url : "/api/usuario/busca",
        data : {
          busca : $("#busca").val()
        }, success : function(res){
          $("tbody").html("")
          
          if(res.error){
            alert(res.message)
          }

          res.data.forEach(usuario => {
          var ativo = "Não"
          if(usuario.ATIVO == 'S'){
            ativo = "Sim"
          }
          $("tbody").append(`
              <tr id="user-${usuario.USUARIO_ID}">
                <td>${usuario.NOME_COMPLETO}</td>
                <td>${usuario.LOGIN}</td>
                <td>${ativo}</td>
                <td>
                  <a href="/atualizar/${usuario.USUARIO_ID}">
                    <button class="w3-button w3-theme w3-margin-top"><i class="fas fa-edit"></i></button>
                  </a>
                  <button class="w3-button w3-theme w3-margin-top" onclick="excluirUsuario(${usuario.USUARIO_ID})"><i class="fas fa-user-times"></i></button>
                </td>
              </tr>
          `);
        });
        }
      })
    }
  </script>
</html>