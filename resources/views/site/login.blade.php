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
      #login {
        max-width: 95%;
        margin: auto;
        width: 380px;
        margin-top: 5%;
      }

      #logo-cliente {
        max-width: 100%;
        margin: auto;
        width: 700px;    
      }

      #logo-santri {
        max-width: 50%;
        margin: auto;
        width: 380px;    
      }
    </style>

  </head>
  <body>
    <script src="/static/js/jquery.js"></script>

    <div id="login">
      <img id="logo-cliente" class="w3-margin-top" src="/static/imagens/logo_cliente.jpg"/>
      <input class="w3-input w3-border w3-margin-top" type="text" placeholder="Usuário" id="user">
      <input class="w3-input w3-border w3-margin-top" type="password" placeholder="Senha" id="senha">
      <button class="w3-button w3-theme w3-margin-top w3-block" onclick="login()">Logar</button>
      
      <a href="http://www.santri.com.br">
        <img id="logo-santri" class="w3-right w3-margin-top" src="/static/imagens/logo_santri.svg"/>
      </a>
    </div>

    <script>
      function login(){
        $.ajax({
          url : "/api/login",
          method : "POST",
          data : {
            login : $("#user").val(),
            senha : $("#senha").val(),
          }, success : function(res){
            console.log(res)
            window.location.href = "/"
          }
        })
      }
    </script>
  </body>
</html>