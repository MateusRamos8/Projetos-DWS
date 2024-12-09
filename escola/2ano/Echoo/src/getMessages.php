<?php
session_start();
require 'logica_autenticacao.php';
require 'conexao.php'; // Ajuste para o nome correto do arquivo de conexão

if(!autenticado()){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Operação não permitida!";
    $_SESSION["msg"] = "Você não tem permissão para acessar essa página.";
    redireciona("index.php");
    die();
}

$idChat = $_POST['id_chat'];
$idUsuario = $_SESSION['id_usuario'];

// Consulta para buscar as mensagens do chat
$sql = "
    SELECT 
        m.id, 
        m.id_sender, 
        m.message, 
        m.data_criacao, 
        u.username, 
        u.url_imagem 
    FROM 
        messages m
    JOIN 
        usuarios u ON u.id = m.id_sender
    WHERE 
        m.id_chat = ?
    ORDER BY 
        m.data_criacao ASC
";
$stmt = $conn->prepare($sql);
$stmt->execute([$idChat]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Marca todas as mensagens como lidas para o usuário logado
$sqlUpdate = "
    INSERT IGNORE INTO message_read_status (id_mensagem, id_usuario)
    SELECT m.id, ? 
    FROM messages m
    LEFT JOIN message_read_status mrs 
    ON m.id = mrs.id_mensagem AND mrs.id_usuario = ?
    WHERE m.id_chat = ? AND mrs.id_usuario IS NULL;

";
$stmtUpdate = $conn->prepare($sqlUpdate);
$stmtUpdate->execute([$idUsuario, $idUsuario, $idChat]);

echo json_encode($messages);
?>
