<?php
session_start();


// Verifica se há variáveis de sessão configuradas
if (!empty($_SESSION)) {
    echo "<pre>";
    print_r($_SESSION); // Exibe todas as variáveis da sessão
    echo "</pre>";
} else {
    echo "Não há variáveis de sessão configuradas.";
}