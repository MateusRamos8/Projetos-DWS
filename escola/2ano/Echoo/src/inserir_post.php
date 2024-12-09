<?php
session_start();
header('Content-Type: application/json');

require 'conexao.php';
require 'logica_autenticacao.php';

if(!autenticado()){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Operação não permitida!";
    $_SESSION["msg"] = "Você não tem permissão para acessar essa página.";
    redireciona("index.php");
    die();
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['titulo'], $data['url_imagem'], $data['blocks'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Dados inválidos recebidos.']);
    exit;
}



$titulo = filter_var($data['titulo'], FILTER_SANITIZE_SPECIAL_CHARS);
$url_imagem = filter_var($data['url_imagem'], FILTER_SANITIZE_URL);
$conteudo = json_encode($data['blocks']);
$data_criacao = date('Y-m-d H:i:s');
$id_usuario = $_SESSION['id_usuario'] ?? null;



if (!$titulo || !$url_imagem || !$conteudo || !$id_usuario) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Dados obrigatórios ausentes. Certifique-se de estar logado.']);
    exit;
}

$sql = "INSERT INTO posts (titulo, conteudo, url_imagem, data_criacao, id_usuario) VALUES (?, ?, ?, ?, ?)";

try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$titulo, $conteudo, $url_imagem, $data_criacao, $id_usuario]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Post salvo com sucesso!']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar no banco.']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro interno: ' . $e->getMessage()]);
}
?>
