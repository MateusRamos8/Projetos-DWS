<?php
session_start();
require "logica_autenticacao.php";
require "conexao.php";

if(!autenticado()){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Operação não permitida!";
    $_SESSION["msg"] = "Você não tem permissão para acessar essa página.";
    redireciona("index.php");
    die();
}

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$error = ""; // Inicializa a variável

$sql = "SELECT 1 FROM usuarios WHERE id = ? LIMIT 1";

try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$id]);
    $rowUser = $stmt->fetchColumn();

    if(!$rowUser){
        $result = false;
        $error = "Usuário inexistente";
        $_SESSION["result"] = $result;
        $_SESSION["msg"] = "O usuário que você tentou seguir não existe";
        $_SESSION["titulo"] = "Usuário Inexistente";
        if (!empty($_SESSION['last_page'])) {
            // Redireciona para a página anterior
            redireciona($_SESSION['last_page']);
            die();
        } else {
            redireciona("pesquisar_usuarios.php");
            die();
        }
    }
} catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
    $_SESSION["result"] = $result;
    $_SESSION["msg"] = "Erro ao verificar se usuário existe: $error";
    $_SESSION["titulo"] = "Erro no Sistema:";
    if (!empty($_SERVER['HTTP_REFERER'])) {
        // Redireciona para a página anterior
        redireciona($_SERVER['HTTP_REFERER']);
        die();
    } else {
        redireciona("pesquisar_usuarios.php");
        die();
    }
}



$sql = "SELECT id_seguidor, id_seguido FROM seguidores WHERE id_seguidor = ? AND id_seguido = ?";

try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$_SESSION["id_usuario"], $id]);
    $rowSeguidores = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
    $_SESSION["result"] = $result;
    $_SESSION["msg"] = "Erro ao verificar seguidores: $error";
    $_SESSION["titulo"] = "Erro no Sistema:";
    if (!empty($_SESSION['last_page'])) {
        // Red$_SESSION['last_page']nterior
        redireciona($_SESSION['last_page']);
        die();
    } else {
        redireciona("pesquisar_usuarios.php");
        die();
    }
}

if ($result && $rowSeguidores) {
    // Usuário já segue

    $sql = "DELETE FROM seguidores WHERE id_seguidor = ? AND id_seguido = ?";

    try {
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$_SESSION["id_usuario"], $id]);
        $rowDelete = $stmt->rowCount();

        $_SESSION["result"] = $result;
        if ($result && $rowDelete > 0) {
            $_SESSION["titulo"] = "Sucesso!";
            $_SESSION["msg"] = "Usuário desseguido com sucesso";
        } else {
            $_SESSION["msg"] = "Falha ao desseguir o usuário.";
            $_SESSION["titulo"] = "Erro no Sistema:";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        $_SESSION["result"] = false;
        $_SESSION["msg"] = "Erro ao tentar desseguir: $error";
        $_SESSION["titulo"] = "Erro no Sistema:";
    }
} elseif (!$rowSeguidores) {
    // Usuário não segue

    $sql = "INSERT INTO seguidores(id_seguidor, id_seguido) VALUES (?, ?)";

    try {
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$_SESSION["id_usuario"], $id]);
        $rowInsert = $stmt->rowCount();

        $_SESSION["result"] = $result;
        if ($result && $rowInsert > 0) {
            $_SESSION["titulo"] = "Sucesso!";
            $_SESSION["msg"] = "Usuário seguido com sucesso";
        } else {
            $_SESSION["msg"] = "Falha ao seguir o usuário.";
            $_SESSION["titulo"] = "Erro no Sistema:";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        $_SESSION["result"] = false;
        $_SESSION["msg"] = "Erro ao tentar seguir: $error";
        $_SESSION["titulo"] = "Erro no Sistema:";
    }
} else {
    $_SESSION["result"] = false;
    $_SESSION["msg"] = "Não foi possível realizar a operação.";
    $_SESSION["titulo"] = "Erro:";
}



if (!empty($_SESSION['last_page'])) {
    // Redireciona para a página anterior
    redireciona($_SESSION['last_page']);
    die();
} else {
    redireciona("pesquisar_usuarios.php");
    die();
}