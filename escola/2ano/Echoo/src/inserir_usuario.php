<?php 
session_start();
require "logica_autenticacao.php";




   require 'conexao.php';


   $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
   $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
   $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
   $senha = filter_input(INPUT_POST, "senha");
   $url_imagem = filter_input(INPUT_POST,"url_imagem", FILTER_VALIDATE_URL);


   $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
   $sql = "INSERT INTO usuarios(username, email, senha, url_imagem) VALUES (?, ?, ?, ?)";
   
   try {
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute([$username, $email, $senha_hash, $url_imagem]);
   } catch (Exception $e) {
      $result = false;
      $error = $e->getMessage();
   }

   if($result == true){
      //deu bom
      $_SESSION["result"] = $result;
      $_SESSION["titulo"] = "Sucesso!";
      $_SESSION["msg"] = "Dados gravados com sucesso!";
  }else{
      //deu ruim
      //SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'sla@gmail.com' for key 'email'


      if(stripos($error, "Duplicate entry") != false){
         $error = "Atenção: o email <b>\"$email\"</b> já está registrado" . "<br><br>";

      }

      $_SESSION["result"] = $result;
      $_SESSION["titulo"] = "Falha ao efetuar gravação";
      $_SESSION["msg"] = $error;
  }
  
  redireciona("form_cadastrar.php");
  die();
?>