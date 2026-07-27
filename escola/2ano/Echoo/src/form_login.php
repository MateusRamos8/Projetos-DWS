<?php
    session_start();
    require 'logica_autenticacao.php';
    
    if(autenticado()){
        if(isset($_SESSION["result_login"]) && !$_SESSION["result_login"]){
            $_SESSION["result"] = false;
            $_SESSION["titulo"] = "Operação não permitida!";
            $_SESSION["msg"] = "Você já está logado.";
        }else{
            unset($_SESSION["result_login"]);
        }
       
        redireciona();
        die();
    }

    require 'header.php';

?>

<main class="flex flex-col justify-center items-center gap-5 text-neutral-300">

    <h1 class="text-6xl select-none m-5">Login</h1> 

    <form action="login.php" method="post" class="flex flex-col gap-4 ">
        <div class="flex flex-col">
            <input type="text" name="username" id="username" placeholder="Username" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="200" required>
        </div>
        <div class="flex flex-col">
            <input type="password" name="senha" id="senha" placeholder="Senha" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="100" required>
        </div>

        <div class="flex flex-col gap-2">
            <button type="submit" class="block select-none w-full h-16 rounded-xl border-2 border-white">Entrar</button>
            <p>Não possui cadastro? <a href="form_cadastrar.php">Cadastrar-se</a></p>
        </div>
    </form>




</main>

<?php
    require 'footer.php';
?>