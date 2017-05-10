<?php

    require_once('db.class.php');

    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    $obj_db = new db();

    $link = $obj_db->conecta_mysql();

    $usuario_existe = false;
    $email_existe = false;

    //verificar se usuário já existe
    $sql = "select * from usuarios where usuario = '$usuario'";
    if($resultado_id = mysqli_query($link, $sql)){

      $dados_usuario = mysqli_fetch_array($resultado_id);

      if (isset($dados_usuario['usuario'])) {
        $usuario_existe = true;
      }
    }else {
      echo "Erro ao tentar localizar o registro de usuário";
    }


    //verificar se o email já existe
    $sql = "select * from usuarios where email = '$email' ";
    if($resultado_id = mysqli_query($link, $sql)){

      $dados_usuario = mysqli_fetch_array($resultado_id);

      if (isset($dados_usuario['email'])) {
        $email_existe = true;
      }
    }else {
      echo "Erro ao tentar localizar o registro de e-mail";
    }

    if ($usuario_existe || $email_existe) {
      $retorno_get = '';

      if ($usuario_existe) {
        $retorno_get.= 'erro_usuario=1&';
      }

      if ($email_existe) {
        $retorno_get.= "erro_email=1&";
      }

        header('Location: inscrevase.php?'.$retorno_get);
        die();
    }

    $sql = "insert into usuarios(usuario, email, senha) values ('$usuario', '$email', '$senha')";

    //executar a query
    if(mysqli_query($link,$sql)){
        echo 'Usuário cadastrado com sucesso';
    }else{
        echo 'Erro ao registrar o usuário';
    }

?>
