<?php
session_start();
require "logica_autenticacao.php";
require "conexao.php";

if(!autenticado()){
    redireciona("index.php");
    die();
}

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$sql = "INSERT INTO seguidores(id_seguidor, id_seguido) VALUES (?, ?)";

try{
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$_SESSION["id_usuario"], $id]);
}catch(Exception $e){
    $result = false;
    $error = $e->getMessage();
}

$count = $stmt->rowCount();


if($result && $count >= 1){
    $_SESSION["result"] = $result;
    $_SESSION["msg_sucesso"] = "Usuário Seguido com Sucesso";
 

    
}elseif($count == 0){
    $_SESSION["result"] = false;
    $_SESSION["msg_erro"] = "Não foi encontrado nenhum registro com o ID = $id";
    $_SESSION["erro"] = $error;
    
}else{
    $_SESSION["result"] = $result;
    $_SESSION["msg_erro"] = "Falha ao seguir usuário";
    $_SESSION["erro"] = $error;
}

if (!empty($_SERVER['HTTP_REFERER'])) {
    // Redireciona para a página anterior
    redireciona($_SERVER['HTTP_REFERER']);
    die();
} else {
    redireciona("index.php");
    die();
}