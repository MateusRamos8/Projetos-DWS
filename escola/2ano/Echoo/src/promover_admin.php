<?php
session_start();
require 'logica_autenticacao.php';
require 'conexao.php';

if(!administrador()){
    redireciona('index.php');
    $_SESSION["result"] = false;
    $_SESSION["msg_erro"] = "Você não possui permissão para acessar essa página";
    die();
}

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$sql = "UPDATE usuarios SET administrador = 1 WHERE id = ?";

try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$id]);
} catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
}

if($result){
    $_SESSION["result"] = $result;
    $_SESSION["msg_sucesso"] = "Usuário $id promovido com Sucesso.";
}else{
    $_SESSION["result"] = $result;
    $_SESSION["msg_erro"] = "Falha ao promover usuário $id.";
    $_SESSION["erro"] = $error;
}

redireciona("gerenciar_usuarios.php");