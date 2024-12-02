<?php
session_start();
require "conexao.php";
require "logica_autenticacao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$adm = filter_input(INPUT_GET, "ad", FILTER_VALIDATE_INT);



if(!autenticado()){
    redireciona("index.php");
    $_SESSION["result"] = false;
    $_SESSION["msg_erro"] = "Operação de edição não permitida.";
    die();
}elseif($_SESSION["id_usuario"] != $id && !administrador()){
    redireciona("index.php");
    $_SESSION["result"] = false;
    $_SESSION["msg_erro"] = "Operação não permitida.";
    $_SESSION["erro"] = "Você está tentando editar um usuário que não é seu.";
    die();
}elseif(administrador() && $_SESSION["id_usuario"] != $id && $adm != 0 && !administradorMax()){
    redireciona("gerenciar_usuarios.php");
    $_SESSION["result"] = false;
    $_SESSION["msg_erro"] = "Operação não permitida";
    $_SESSION["erro"] = "Você está tentando editar um administrador que não é você.";
    die();
}

if(!isset($_GET["id"]) || !isset($_GET["ad"])){
    if(administrador()){
        $_SESSION["result"] = false;
        $_SESSION["msg_erro"] = "Falha na edição.";
        $_SESSION["erro"] = "Parâmetros não suficientes para realizar a edição.";
        redireciona("gerenciar_usuarios.php");
    }else{
        $_SESSION["result"] = false;
        $_SESSION["msg_erro"] = "Falha na edição.";
        $_SESSION["erro"] = "Parâmetros não suficientes para realizar a edição.";
        redireciona("index.php");
    }
}

$sql = "SELECT id, username, url_imagem, email, administrador FROM usuarios WHERE id = ? AND administrador = ?";


try{
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$id, $adm]);
    $rowUser = $stmt->fetch();
}catch(Exception $e){
    
    $error = $e->getMessage();
    $_SESSION["result"] = false;
    $_SESSION["erro"] = $error;
    if(administrador()){
        redireciona("gerenciar_usuarios.php");
    }else{
        redireciona("index.php");
    }
}




require "header.php";
?>

<main class="flex flex-col items-center text-white">
    <h1 class="text-6xl select-none m-10">Formulário de Edição de Usuário</h1> 

    <form action="editar_usuarios.php" method="POST" class="flex flex-col gap-4">
        <div class="flex flex-col">
            <input type="number" name="id" id="id" placeholder="Id" class="select-none bg-[rgba(255,255,255,0.34)] w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="200" value="<?=$rowUser['id']?>" required readonly>
        </div>
        <div class="flex flex-col">
            <input type="text" name="username" id="username" placeholder="Username" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="200" value="<?=$rowUser['username']?>" required>
        </div>
        <div class="flex flex-col">
            <input type="url" name="url_imagem" id="url_imagem" placeholder="URL da Imagem de Perfil" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="300" value="<?=$rowUser['url_imagem']?>" required>
        </div>
        <div class="flex flex-col">
            <input type="email" name="email" id="email" placeholder="E-mail" class="select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="200" required value="<?=$rowUser['email']?>">
        </div>
        <div class="flex flex-col">
            <input type="number" name="ad" id="ad" placeholder="ad" class="hidden select-none bg-transparent w-80 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="200" value="<?=$rowUser['administrador']?>" required readonly>
        </div>


        <div class="flex flex-col gap-2">
            <button type="submit" class="block select-none w-full h-16 rounded-xl border-2 border-white">Editar</button>
        </div>
    </form>

    <div class="p-8 flex justify-center items-center">
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
    </div>
</main>

<?php
require "footer.php";
?>