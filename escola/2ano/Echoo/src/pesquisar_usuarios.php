<?php
session_start();
require "logica_autenticacao.php";
require "conexao.php";

if(!autenticado()){
    redireciona("index.php");
    die();
}

require "header.php";
if (isset($_GET["ordem"]) && !empty($_GET["ordem"])) {
    $ordem = filter_input(INPUT_GET, "ordem", FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $ordem = "username";
}



if (isset($_POST["busca"]) && !empty($_POST["busca"])) {
    $busca = filter_input(INPUT_POST, "busca", FILTER_SANITIZE_SPECIAL_CHARS);
    $buscaOriginal = $busca;

    $busca = "%" . $busca . "%";

    $sql = "SELECT id, username, url_imagem,
                CASE 
                    WHEN s.id_seguido IS NOT NULL THEN 'Seguindo'
                    ELSE 'Seguir'
                END AS status_seguir
            FROM usuarios u
            LEFT JOIN seguidores s
            ON u.id = s.id_seguido AND s.id_seguidor = ?
            WHERE username LIKE ? AND u.id != ? ORDER BY $ordem";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$_SESSION["id_usuario"], $busca, $_SESSION["id_usuario"]]);
}else {
    $sql = "SELECT id, username, url_imagem,
                CASE 
                    WHEN s.id_seguido IS NOT NULL THEN 'Seguindo'
                    ELSE 'Seguir'
                END AS status_seguir
            FROM usuarios u
            LEFT JOIN seguidores s
            ON u.id = s.id_seguido AND s.id_seguidor = ?
            WHERE u.id != ? ORDER BY $ordem";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$_SESSION["id_usuario"], $_SESSION["id_usuario"]]);
}

?>

<main class="text-white flex flex-col p-10">
    <div id="PainelPesquisar">
        <form action="" method="POST" class="flex p-10 items-center justify-center gap-8">
            <div>
                <input type="text" id="busca" name="busca" class="select-none bg-transparent w-[35vw] h-14 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="200" required placeholder="Dados da Busca">
            </div>
            <div>
                <button type="submit" class="block select-none w-50 h-14 rounded-xl border-2 border-white px-4">Pesquisar</button>
            </div>
        </form>
    </div>
    <?php
    if (isset($_POST["busca"]) && !empty($_POST["busca"])) {
    ?>

        <div class="flex justify-center items-center mb-5">
            <div class="text-zinc-300" role="alert">
                Você está buscando por <mark>"<?= $buscaOriginal ?>"</mark>, <a href="pesquisar_usuarios.php?ordem=<?= $ordem ?>">limpar</a>.
            </div>
        </div>
        
    <?php
    }
    ?>

    <div class="flex flex-wrap gap-4 justify-center">
        <?php
            while($row = $stmt->fetch()){
                ?>
                <div class="flex justify-between items-center bg-white text-neutral-700 p-5 w-80 rounded-lg">
                    <div class="flex items-center gap-1">
                        <?php
                            $urlImagemList = $row["url_imagem"];
                            $bg_user_list = "style=\"background-image: url('$urlImagemList');\""
                        ?>
                        <div <?= $bg_user_list ?> class="bg-cover bg-no-repeat bg-center w-10 h-10 rounded-full border-[1px] border-black"></div>
                        <div><?=$row['username']?></div>
                    </div>
                    <div>
                        <?php
                            if($row['status_seguir'] == 'Seguindo'){
                                ?>
                                <a href="" class="flex items-center justify-center gap-1 bg-indigo-500 hover:bg-red-500 text-neutral-200 py-3 px-4 rounded-lg select-none group transition-all duration-300 ease-in-out">
                                    Seguindo
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round group-hover:hidden group-hover:opacity-0 transition-all duration-300 ease-in-out"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-x hidden opacity-0 group-hover:inline-block group-hover:opacity-100 transition-all duration-300 ease-in-out"><path d="M2 21a8 8 0 0 1 11.873-7"/><circle cx="10" cy="8" r="5"/><path d="m17 17 5 5"/><path d="m22 17-5 5"/></svg>
                                 </a>
                                 <?php
                            }else{
                            ?>
                                    <a href="seguir.php?id=<?=$row['id']?>" class="flex items-center justify-center gap-1 bg-indigo-500 text-neutral-200 py-3 px-4 rounded-lg select-none">
                                        Seguir
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-plus"><path d="M2 21a8 8 0 0 1 13.292-6"/><circle cx="10" cy="8" r="5"/><path d="M19 16v6"/><path d="M22 19h-6"/></svg>
                                    
                                     </a>
                                <?php
                            }
                        ?>
                        
                    </div>
                    
                </div>
                <?php
            }
        ?>
    </div>

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