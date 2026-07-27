<?php
session_start();
require_once "logica_autenticacao.php";
require_once 'conexao.php';
if(!autenticado()){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Operação não permitida!";
    $_SESSION["msg"] = "Você não tem permissão para acessar essa página.";
    redireciona("index.php");
    die();
}

try{
    $sql = "
    SELECT 
    c.id,
    CASE 
        WHEN c.is_group = 1 THEN c.url_imagem_icon
        ELSE u.url_imagem
    END AS url_imagem_icon,
    CASE 
        WHEN c.is_group = 1 THEN c.nome
        ELSE u.username
    END AS chat_name,
    c.is_group,
    c.last_message,
    MAX(m.data_criacao) AS last_message_time,
    COUNT(m.id) - COUNT(mrs.id_usuario) AS unread_count
FROM 
    chats c
LEFT JOIN 
    chat_users cu ON cu.id_chat = c.id
 JOIN 
    usuarios u ON u.id = cu.id_usuario AND u.id != ?
LEFT JOIN 
    messages m ON m.id_chat = c.id
LEFT JOIN 
    message_read_status mrs ON mrs.id_mensagem = m.id AND mrs.id_usuario = ?
WHERE 
    c.id IN (
        SELECT id_chat 
        FROM chat_users 
        WHERE id_usuario = ?
    )
GROUP BY 
    c.id, c.url_imagem_icon, c.nome, c.is_group, c.last_message, u.url_imagem, u.username
ORDER BY 
    last_message_time DESC;




    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([ $_SESSION["id_usuario"], $_SESSION["id_usuario"], $_SESSION["id_usuario"]]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Erro no Sistema";
    $_SESSION["msg"] = $e->getMessage();

    redireciona("index.php");
    die();
}

