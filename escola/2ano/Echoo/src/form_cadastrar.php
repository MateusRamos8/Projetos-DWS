<?php
    session_start();
    require 'logica_autenticacao.php';

    require 'header.php';
?>
<script>
    function verifica_senhas() {
        var senha = document.getElementById("senha");
        var confsenha = document.getElementById("confirmar_senha");

        if (senha.value && confsenha.value) {
            if (senha.value != confsenha.value) {
                //senha.classList.add("is-invalid");
                //confsenha.classList.add("is-invalid");
                confsenha.value = null;
            } else {
                //senha.classList.remove("is-invalid");
                //confsenha.classList.remove("is-invalid");
            }
        }
    }
</script>

<main class="flex flex-col justify-center items-center gap-5 text-neutral-300">

    <h1 class="text-6xl select-none m-5">Cadastro</h1> 

    <form action="inserir_usuario.php" method="post" class="flex flex-col gap-4">
        <div class="flex flex-col">
            <input type="text" name="username" id="username" placeholder="Username" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="200" required>
        </div>
        <div class="flex flex-col">
            <input type="text" name="nome" id="nome" placeholder="Nome" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="200" required>
        </div>
        <div class="flex flex-col">
            <input type="url" name="url_imagem" id="url_imagem" placeholder="URL da Imagem de Perfil" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="300" required>
        </div>
        <div class="flex flex-col">
            <input type="email" name="email" id="email" placeholder="E-mail" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="200" required>
        </div>
        <div class="flex flex-col">
            <input type="password" name="senha" id="senha" placeholder="Senha" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="100" required>
        </div>
        <div class="flex flex-col">
            <input type="password" name="confirmar_senha" id="confirmar_senha" placeholder="Confirmar Senha" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" onblur="verifica_senhas();" maxlength="100" required>
        </div>


        <div class="flex flex-col gap-2">
            <button type="submit" class="block select-none w-full h-16 rounded-xl border-2 border-white">Cadastrar</button>
            <p>Já possui cadastro? <a href="form_login.php">Entrar</a></p>
        </div>
    </form>


<?php

if(isset($_SESSION["result"])){

    if($_SESSION["result"] == true){
        ?>
        <div class="w-96 p-5 text-green-900 font-bold bg-green-200 border-4 border-green-700 rounded-md">
            <h4><?=$_SESSION["msg_sucesso"]?></h4>
        </div>
        <?php
        unset($_SESSION["msg_sucesso"]);
    }else{
        ?>
        <div class="w-96 p-5 text-red-900 font-bold bg-red-200 border-4 border-red-700 rounded-md">
            <h4><?=$_SESSION["msg_erro"]?></h4>
            <p><?=$_SESSION["erro"]?></p>
        </div>
        <?php
        unset($_SESSION["msg_erro"]);
        unset($_SESSION["erro"]);
    }

    unset($_SESSION["result"]);
}
?>
</main>

<?php

    require 'footer.php';
?>