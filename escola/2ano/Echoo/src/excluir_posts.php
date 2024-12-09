<?php
session_start();
require "conexao.php";
require "logica_autenticacao.php";

$idPost = filter_input(INPUT_GET, "idPost", FILTER_SANITIZE_NUMBER_INT);
$idUserPost = filter_input(INPUT_GET, "idUserPost", FILTER_SANITIZE_NUMBER_INT);
$adm = filter_input(INPUT_GET, "adm", FILTER_SANITIZE_NUMBER_INT);

if(!administrador() && $idUserPost != $_SESSION["id_usuario"]){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Operação não permitida!";
    $_SESSION["msg"] = "Você não tem permissão para excluir um post que não é seu.";
    redireciona("index.php");
    die();
}
if(administrador() && $idUserPost != $_SESSION["id_usuario"] && $adm > 0){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Operação não permitida!";
    $_SESSION["msg"] = "Você não tem permissão para excluir um post que não é seu.";
    redireciona("index.php");
    die();
}

$sql = "DELETE FROM posts 
WHERE id = ? AND id_usuario = ? AND EXISTS (
    SELECT 1 FROM usuarios 
    WHERE id = id_usuario AND administrador = ?
);";

try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$idPost, $idUserPost, $adm]);
    if($result){
        try{
            $sql = "UPDATE usuarios
                    SET qtd_posts = qtd_posts - 1
                    WHERE id = ? AND administrador = ?";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([$idUserPost, $adm]);
        }catch(Exception $e){
            $error2 = $e->getMessage();
        }
    }
} catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
}

$count = $stmt->rowCount();

if($result && $count >= 1){
    $_SESSION["result"] = $result;
    $_SESSION["titulo"] = "Sucesso!";
    $_SESSION["msg"] = "Post (id $idPost) Excluído com Sucesso $erro2 ?? ''";
}elseif($count == 0){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Não foi encontrado nenhum Post de ID $idPost, do usuário de id $idUserPost e permissão $adm $erro2 ?? ''";
    $_SESSION["msg"] = $error;
}else{
    $_SESSION["result"] = $result;
    $_SESSION["titulo"] = "Falha ao excluir Post $erro2 ?? ''";
    $_SESSION["msg"] = $error;
}

redireciona("gerenciar_posts.php");

