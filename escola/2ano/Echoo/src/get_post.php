<?php
require '../vendor/autoload.php';
require 'conexao.php';
require 'logica_autenticacao.php';

if(!autenticado()){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Operação não permitida!";
    $_SESSION["msg"] = "Você não tem permissão para acessar essa página.";
    redireciona("index.php");
    die();
}


header('Content-Type: application/json');
use Durlecode\EJSParser\Parser;


// Verifica se o ID foi enviado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400); // Código HTTP de erro
    echo json_encode(['success' => false, 'message' => 'ID do post não fornecido.']);
    
    exit;
}


$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

try {
    $sql = "SELECT p.titulo, p.url_imagem, p.conteudo, p.data_criacao, u.username 
            FROM posts p 
            JOIN usuarios u ON p.id_usuario = u.id 
            WHERE p.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        if (!empty($post['conteudo'])) {
            $post['conteudo'] = Parser::parse($post['conteudo'])->toHtml();
        } else {
            $post['conteudo'] = ''; // Ou uma mensagem padrão
        }
        echo json_encode(['success' => true, 'data' => $post]);
    } else {
        http_response_code(404); 
        echo json_encode(['success' => false, 'message' => 'Post não encontrado.']);
        
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro ao buscar o post: ' . $e->getMessage()]);
    
}