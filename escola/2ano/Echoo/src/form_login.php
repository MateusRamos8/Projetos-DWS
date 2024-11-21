<?php
    session_start();
    require 'logica_autenticacao.php';
    
    if(autenticado()){
        redireciona();
        die();
    }

    require 'header.php';

?>

<main class="flex flex-col justify-center items-center gap-5 text-neutral-300">

    <h1 class="text-6xl select-none m-5">Login</h1> 

    <form action="login.php" method="post" class="flex flex-col gap-4 ">
        <div class="flex flex-col">
            <input type="text" name="username" id="username" placeholder="Username" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" required>
        </div>
        <div class="flex flex-col">
            <input type="password" name="senha" id="senha" placeholder="Senha" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" required>
        </div>


        <div class="flex flex-col gap-2">
            <button type="submit" class="block select-none w-full h-16 rounded-xl border-2 border-white">Entrar</button>
            <p>Não possui cadastro? <a href="form_cadastrar.php">Cadastrar-se</a></p>
        </div>
    </form>


    <?php

if(isset($_SESSION["result_login"])){

    if($_SESSION["result_login"] == true){
        ?>
        <div class="w-96 p-5 text-green-900 font-bold bg-green-200 border-4 border-green-700 rounded-md">
            <h4>Autenticado com Sucesso!!!</h4>
        </div>
        <?php
    }else{
        $erro = $_SESSION["erro"];
        unset($_SESSION["erro"]);
        ?> 
        <div class="w-96 p-5 text-red-900 font-bold bg-red-200 border-4 border-red-700 rounded-md">
            <h4>Falha ao efetuar autentificação.</h4>
            <p><?=$erro?></p>
        </div>
        <?php
        unset($_SESSION["erro"]);
    }

    unset($_SESSION["result_login"]);
}
?>

</main>

<?php
    require 'footer.php';
?>