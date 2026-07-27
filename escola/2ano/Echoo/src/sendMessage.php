<?php
session_start();
require 'logica_autenticacao.php';
require 'conexao.php'; // Ajuste conforme sua estrutura de projeto

if(!autenticado()){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Operação não permitida!";
    $_SESSION["msg"] = "Você não tem permissão para acessar essa página.";
    redireciona("index.php");
    die();
}

// Verifica se o usuário está autenticado
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false, 'error' => 'Usuário não autenticado']);
    exit;
}

// Captura os dados enviados via POST
$id_chat = filter_input(INPUT_POST, 'id_chat', FILTER_VALIDATE_INT);
$mensagem = trim($_POST['mensagem']);
$id_usuario = $_SESSION['id_usuario']; // ID do usuário logado

if (!$id_chat || empty($mensagem)) {
    echo json_encode(['success' => false, 'error' => 'Dados inválidos']);
    exit;
}

try {
    // Insere a mensagem na tabela
    $sql = "INSERT INTO messages (id_chat, id_sender, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_chat, $id_usuario, $mensagem]);

    // Retorna sucesso
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // Retorna erro
    echo json_encode(['success' => false, 'error' => 'Erro ao enviar mensagem: ' . $e->getMessage()]);
}
