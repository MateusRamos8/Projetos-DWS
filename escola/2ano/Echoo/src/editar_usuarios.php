<?php
session_start();
require "logica_autenticacao.php";
require "conexao.php";


$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$url_imagem = filter_input(INPUT_POST, "url_imagem", FILTER_SANITIZE_URL);
$adm = filter_input(INPUT_POST, "ad", FILTER_SANITIZE_NUMBER_INT);



if(!autenticado()){
    redireciona("index.php");
    $_SESSION["result"] = false;
    $_SESSION["msg_erro"] = "Operação de edição não permitida.";
    die();
}elseif($_SESSION["id_usuario"] != $id && !administrador()){
    redireciona("index.php");
    $_SESSION["result"] = false;
    $_SESSION["msg_erro"] = "Operação não permitida.";
    $_SESSION["erro"] = "Você está tentando editar um usuário que não é seu.";
    die();
}elseif(administrador() && $_SESSION["id_usuario"] != $id && $adm != 0 && !administradorMax()){
    redireciona("gerenciar_usuarios.php");
    $_SESSION["result"] = false;
    $_SESSION["msg_erro"] = "Operação não permitida";
    $_SESSION["erro"] = "Você está tentando editar um administrador que não é você.";
    die();
}

if(!isset($_POST["id"]) || !isset($_POST["username"]) || !isset($_POST["url_imagem"]) || !isset($_POST["email"]) || !isset($_POST["ad"])){
    $_SESSION["result"] = false;
    $_SESSION["msg_erro"] = "Falha na edição.";
    $_SESSION["erro"] = "Parâmetros não suficientes para realizar a edição.";
    if(administrador()){
        redireciona("gerenciar_usuarios.php");
        die();
    }else{
        redireciona("index.php");
        die();
    }
}

$sql = "UPDATE usuarios SET username = ?, url_imagem = ?, email = ? WHERE id = ? AND administrador = ?";

try{
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$username, $url_imagem, $email, $id, $adm]);
}catch(Exception $e){
    $result = false;
    $error = $e->getMessage();
}

$count = $stmt->rowCount();

if($result && $count >= 1){
    $_SESSION["result"] = $result;
    $_SESSION["msg_sucesso"] = "Usuário $id editado com Sucesso.";
    if($_SESSION["id_usuario"] == $id){
        $_SESSION["username"] = $username;
        $_SESSION["url_imagem"] = $url_imagem;
        $_SESSION["email"] = $email;
        redireciona("form_editar_usuarios.php?id=$id&ad=$adm");
        die();
    }
}elseif($result && $count == 0){
    $_SESSION["result"] = $result;
    $_SESSION["msg_sucesso"] = "Não foi encontrado nenhum registro com os valores especificados.";
    if($_SESSION["id_usuario"] == $id){
        redireciona("form_editar_usuarios.php");
        die();
    }
}else{
    $_SESSION["result"] = $result;
    $_SESSION["msg_erro"] = "Falha ao editar usuário $id.";
    $_SESSION["erro"] = $error;
    redireciona("form_editar_usuarios.php");
    die();
}




redireciona("gerenciar_usuarios.php");
die();

