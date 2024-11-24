<?php
require 'conexao.php';

header('Content-Type: application/json');

// Verifica se o ID foi enviado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID do post não fornecido.']);
    exit;
}

$id = (int) $_GET['id'];

try {
    $sql = "SELECT p.titulo, p.url_imagem, p.conteudo, p.data_criacao, u.username 
            FROM posts p 
            JOIN usuarios u ON p.id_usuario = u.id 
            WHERE p.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        $post['conteudo'] = json_decode($post['conteudo'], true); // Decodifica JSON do conteúdo
        echo json_encode(['success' => true, 'data' => $post]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Post não encontrado.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro ao buscar o post: ' . $e->getMessage()]);
}
