<?php
session_start();
require 'conexao.php';
require 'logica_autenticacao.php';

if(!administrador()){
    redireciona("index.php");
    die();
}

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$adm = filter_input(INPUT_GET, "ad", FILTER_SANITIZE_NUMBER_INT);

if($_SESSION["id_usuario"] != $id && !administradorMax() && $adm != 0){
    $_SESSION["result"] = false;
    $_SESSION["msg_erro"] = "Operação Não Permitida:";
    $_SESSION["erro"] = "Você está tentando excluir outro administrador.";
    redireciona("gerenciar_usuarios.php");
    die();
}


$sql = "DELETE FROM usuarios WHERE id = ? AND administrador = ?";

try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$id, $adm]);
} catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
}

$count = $stmt->rowCount();

if($result && $count >= 1){
    if($_SESSION["id_usuario"] == $id){
        redireciona("sair.php");
        die();
    }else{
        $_SESSION["result"] = $result;
        $_SESSION["msg_sucesso"] = "Registro (id $id) Excluído com Sucesso";
    }
}elseif($count == 0){
    $_SESSION["result"] = false;
    $_SESSION["msg_erro"] = "Não foi encontrado nenhum registro com o ID = $id e permissão = $adm";
    $_SESSION["erro"] = $error;
}else{
    $_SESSION["result"] = $result;
    $_SESSION["msg_erro"] = "Falha ao excluir registro";
    $_SESSION["erro"] = $error;
}

redireciona("gerenciar_usuarios.php");








