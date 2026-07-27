<?php
session_start();
require 'logica_autenticacao.php';
require "conexao.php";

if(!autenticado()){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Operação não permitida!";
    $_SESSION["msg"] = "Você não tem permissão para acessar essa página.";

    redireciona("index.php");
    die();
}

$data = json_decode(file_get_contents('php://input'), true);

$is_group = $data['is_group'] ?? false;
$users = $data['users'] ?? [];
$groupName = $data['groupName'] ?? null;

// Adiciona o usuário logado à lista (se ainda não estiver)
if (!$is_group && count($users) !== 1) {
    echo json_encode(['success' => false, 'message' => 'Chat privado requer exatamente um outro usuário.']);
    exit;
}
if (!in_array($_SESSION["id_usuario"], $users)) {
    $users[] = $_SESSION["id_usuario"];
}

try {
    if ($is_group) {
        if (empty($groupName)) {
            echo json_encode(['success' => false, 'message' => 'Nome do grupo é obrigatório.']);
            exit;
        }

        // Cria grupo
        $stmt = $conn->prepare("INSERT INTO chats (nome, is_group) VALUES (?, 1)");
        $stmt->execute([$groupName]);
        $chatId = $conn->lastInsertId();

        // Insere membros
        $stmt = $conn->prepare("INSERT INTO chat_users (id_chat, id_usuario) VALUES (?, ?)");
        foreach ($users as $user) {
            $stmt->execute([$chatId, $user]);
        }

        echo json_encode(['success' => true, 'message' => 'Grupo criado com sucesso.', 'id_chat' => $chatId]);
    } else {
        // Verifica se o chat privado já existe
        $stmt = $conn->prepare("SELECT id FROM chats 
            WHERE is_group = 0 AND id IN (
                SELECT id_chat FROM chat_users WHERE id_usuario IN (?, ?)
                GROUP BY id_chat HAVING COUNT(*) = 2
            )");
        $stmt->execute([$users[0], $users[1]]);
        $existingChat = $stmt->fetch();

        if ($existingChat) {
            echo json_encode(['success' => true, 'message' => 'Chat privado já existe.', 'id_chat' => $existingChat['id']]);
            exit;
        }

        // Cria novo chat privado
        $stmt = $conn->prepare("INSERT INTO chats (is_group) VALUES (0)");
        $stmt->execute();
        $chatId = $conn->lastInsertId();

        // Insere membros
        $stmt = $conn->prepare("INSERT INTO chat_users (id_chat, id_usuario) VALUES (?, ?)");
        foreach ($users as $user) {
            $stmt->execute([$chatId, $user]);
        }

        echo json_encode(['success' => true, 'message' => 'Chat privado criado.', 'id_chat' => $chatId]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao criar chat: ' . $e->getMessage()]);
}
