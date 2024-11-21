<?php
session_start();
require "logica_autenticacao.php";


require "conexao.php";

$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$senha = filter_input(INPUT_POST, "senha");

$sql = "SELECT id, username, email, url_imagem, senha FROM usuarios WHERE username = ?";

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

    $_SESSION["result_login"] = true;
}
else{
    //NÃO DEU CERTO
    unset($_SESSION["id_usuario"]);
    unset($_SESSION["email"]);
    unset($_SESSION["username"]);
    unset($_SESSION["url_imagem"]);

    $_SESSION["result_login"] = false;
    $_SESSION["erro"] = "Username ou senha incorretos. " . $error;
}

redireciona("form_login.php");
?>