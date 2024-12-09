<?php
session_start();
require "logica_autenticacao.php";

if(autenticado()){
    $_SESSION["result_false"] = false;
    redireciona("form_login.php");
    die();
}

require "conexao.php";

$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$senha = filter_input(INPUT_POST, "senha");

$sql = "SELECT id, username, email, url_imagem, senha, administrador FROM usuarios WHERE username = ?";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
 } catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
 }



$row = $stmt->fetch();




if(password_verify($senha, $row['senha'])){
    $_SESSION["id_usuario"] = $row['id'];
    $_SESSION["email"] = $row['email'];
    $_SESSION["username"] = $row['username'];
    $_SESSION["url_imagem"] = $row['url_imagem'];
    $_SESSION["administrador"] = $row['administrador'];

    $_SESSION["result_login"] = true;

    $_SESSION["result"] = true;
    $_SESSION["titulo"] = "Login realizado com sucesso!";
    $_SESSION["msg"] = "Agora você está autenticado";
}
else{
    //NÃO DEU CERTO
    unset($_SESSION["id_usuario"]);
    unset($_SESSION["email"]);
    unset($_SESSION["username"]);
    unset($_SESSION["url_imagem"]);
    unset($_SESSION["administrador"]);


    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Erro no Login:";
    $_SESSION["msg"] = "Username ou senha incorretos. " . $error;
}

redireciona("form_login.php");
?>