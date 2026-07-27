<?php
function autenticado(){
    if(isset($_SESSION["email"])){
        return true;
    } else {
        return false;
    }
}

function administrador(){
    if(isset($_SESSION["administrador"])){
        if($_SESSION["administrador"] == 1 || administradorMax()){
            return true;
        }
    }
}

function administradorMax(){
    if(isset($_SESSION["administrador"])){
        if($_SESSION["administrador"] == 9){
            return true;
        }
    }
}

function formatDateTime($datetime) {
    // Converte o datetime em timestamp
    $timestamp = strtotime($datetime);
    // Retorna a data formatada
    return date('d/m/Y - H:i', $timestamp);
}

function formatDateNormal($date) {
    // Converte a data para um objeto DateTime
    $dateTime = new DateTime($date);

    // Formata a data no formato desejado
    return $dateTime->format('d/m/Y');
}

function nome_usuario(){
    return $_SESSION["nome"];
}

function email_usuario(){
    return $_SESSION["email"];
}

function id_usuario(){
    return $_SESSION["id_usuario"];
}

function redireciona($pagina = null){
    if(empty($pagina)){
        $pagina = "index.php";
    }
    header("Location: " . $pagina);
}

?>