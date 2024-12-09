<?php
session_start();
require 'logica_autenticacao.php';
require 'conexao.php';

if (!administrador()) {
    
    
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Operação não permitida!";
    $_SESSION["msg"] = "Você não tem permissão para acessar essa página.";
    redireciona('index.php');
    die();
}

require 'header.php';

if (isset($_GET["ordem"]) && !empty($_GET["ordem"])) {
    $ordem = filter_input(INPUT_GET, "ordem", FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $ordem = "u.username";
}



if (isset($_POST["busca"]) && !empty($_POST["busca"])) {
    $busca = filter_input(INPUT_POST, "busca", FILTER_SANITIZE_SPECIAL_CHARS);
    $buscaOriginal = $busca;
    $tipoBusca = filter_input(INPUT_POST, "tipoBusca", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($tipoBusca == "username") {

        $busca = "%" . $busca . "%";

        $sql = "SELECT p.id AS p_id, p.titulo AS p_titulo, p.conteudo AS p_conteudo, p.url_imagem AS p_url_imagem, p.data_criacao AS p_data_criacao, u.id AS u_id, u.username AS u_username, u.url_imagem AS u_url_imagem, u.administrador AS u_administrador FROM posts p JOIN usuarios u ON p.id_usuario = u.id WHERE u.username like ? ORDER BY $ordem";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$busca]);
    } elseif ($tipoBusca == "id") {
        $buscaInt = intval($busca);

        $sql = "SELECT p.id AS p_id, p.titulo AS p_titulo, p.conteudo AS p_conteudo, p.url_imagem AS p_url_imagem, p.data_criacao AS p_data_criacao, u.id AS u_id, u.username AS u_username, u.url_imagem AS u_url_imagem, u.administrador AS u_administrador FROM posts p JOIN usuarios u ON p.id_usuario = u.id WHERE p.id = ? ORDER BY $ordem";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$buscaInt]);
    } elseif ($tipoBusca == "titulo") {

        $busca = "%" . $busca . "%";

        $sql = "SELECT p.id AS p_id, p.titulo AS p_titulo, p.conteudo AS p_conteudo, p.url_imagem AS p_url_imagem, p.data_criacao AS p_data_criacao, u.id AS u_id, u.username AS u_username, u.url_imagem AS u_url_imagem, u.administrador AS u_administrador FROM posts p JOIN usuarios u ON p.id_usuario = u.id WHERE p.titulo like ? ORDER BY $ordem";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$busca]);
    } else {

        $buscaInt = intval($busca);

        $busca = "%" . $busca . "%";



        $sql = "SELECT p.id AS p_id, p.titulo AS p_titulo, p.conteudo AS p_conteudo, p.url_imagem AS p_url_imagem, p.data_criacao AS p_data_criacao, u.id AS u_id, u.username AS u_username, u.url_imagem AS u_url_imagem, u.administrador AS u_administrador FROM posts p JOIN usuarios u ON p.id_usuario = u.id WHERE u.username like ? OR p.titulo like ? OR p.id = ? ORDER BY $ordem";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$busca, $busca, $buscaInt]);
    }
} else {
    $sql = "SELECT p.id AS p_id, p.titulo AS p_titulo, p.conteudo AS p_conteudo, p.url_imagem AS p_url_imagem, p.data_criacao AS p_data_criacao, u.id AS u_id, u.username AS u_username, u.url_imagem AS u_url_imagem, u.administrador AS u_administrador FROM posts p JOIN usuarios u ON p.id_usuario = u.id ORDER BY $ordem";
    $stmt = $conn->query($sql);
}

?>

<main class="text-white flex flex-col p-10">
    <div id="PainelPesquisar">
        <form action="" method="POST" class="flex p-10 items-center justify-center gap-8">
            <div class="flex items-center h-14 gap-4">
                <label for="tipoBusca" class="text-2xl">Tipo da Busca: </label>
                <select name="tipoBusca" id="tipoBusca" class="h-14 select-none bg-transparent border-b-white border-2 rounded-xl p-3 focus:outline-none">
                    <option value="" class="text-black select-none bg-transparent border-b-white border-2 rounded-xl p-3 focus:outline-non">Todos os Campos</option>
                    <option value="id" class="text-black select-none bg-transparent border-b-white border-2 rounded-xl p-3 focus:outline-non">ID</option>
                    <option value="username" class="text-black select-none bg-transparent border-b-white border-2 rounded-xl p-3 focus:outline-non">Username</option>
                    <option value="email" class="text-black select-none bg-transparent border-b-white border-2 rounded-xl p-3 focus:outline-non">Email</option>
                </select>
            </div>
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
                Você está buscando por <mark>"<?= $buscaOriginal ?>"</mark>, <a href="gerenciar_usuarios.php?ordem=<?= $ordem ?>">limpar</a>.
            </div>
        </div>
        <hr>
    <?php
    }
    ?>

    <div>
        <table class="w-full bg-gray-200 text-zinc-700 rounded-lg">
            <thead class="bg-gray-50 border-b-2 border-gray-400">
                <tr>
                    <?php
                    if ($ordem == "u.username") {


                    ?>


                        

                        <th scope="col" class="rounded-lg p-3 text-sm font-semibold tracking-wide text-center w-52">
                            Imagem de Perfil
                        </th>
                        <th scope="col" class="p-3 text-sm font-semibold tracking-wide text-left">
                            Username<i data-feather="chevron-down"></i>
                        </th>

                        <th scope="col" class="p-3 text-sm font-semibold tracking-wide text-center w-20">
                            <a href="?ordem=p.id">ID Post</a>
                        </th>

                        <th scope="col" class="p-3 text-sm font-semibold tracking-wide text-left">
                            <a href="?ordem=p.titulo">Título</a>
                        </th>
                        <th scope="col" class="p-3 text-sm font-semibold tracking-wide text-left w-52">
                            Data de Criação
                        </th>

                    <?php
                    } elseif ($ordem == "p.id") {


                    ?>

                        <th scope="col" class="rounded-lg p-3 text-sm font-semibold tracking-wide text-center w-52">
                            Imagem de Perfil
                        </th>
                        <th scope="col" class="p-3 text-sm font-semibold tracking-wide text-left">
                            <a href="?ordem=u.username">Username</a>
                        </th>
                        <th scope="col" class="p-3 text-sm font-semibold tracking-wide text-center w-20">
                            ID Post<i data-feather="chevron-down"></i>
                        </th>
                        <th scope="col" class="p-3 text-sm font-semibold tracking-wide text-left">
                            <a href="?ordem=p.titulo">Título</a>
                        </th>
                        <th scope="col" class="p-3 text-sm font-semibold tracking-wide text-left w-52">
                            Data de Criação
                        </th>


                    <?php
                    } elseif ($ordem == "p.titulo") {


                    ?>
                        

                        <th scope="col" class="rounded-lg p-3 text-sm font-semibold tracking-wide text-center w-52">
                            Imagem de Perfil
                        </th>
                        <th scope="col" class="p-3 text-sm font-semibold tracking-wide text-left">
                            <a href="?ordem=u.username">Username</a>
                        </th>
                        <th scope="col" class="p-3 text-sm font-semibold tracking-wide text-center w-20">
                            <a href="?ordem=p.id">ID Post</a>
                        </th>

                        <th scope="col" class="p-3 text-sm font-semibold tracking-wide text-left">
                            Título<i data-feather="chevron-down"></i>
                        </th>
                        <th scope="col" class="p-3 text-sm font-semibold tracking-wide text-left w-52">
                            Data de Criação
                        </th>


                    <?php
                    }
                    ?>
                    <th scope="col" class="rounded-lg p-3 text-sm font-semibold tracking-wide text-center">Ferramentas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $stmt->fetch()) {
                ?>
                    <tr class="even:bg-gray-50">


                        



                        <td class="p-3 text-sm text-gray-700 w-40">
                            <?php
                            $urlImagemList = $row["u_url_imagem"];
                            $bg_user_list = "style=\"background-image: url('$urlImagemList');\""
                            ?>
                            <div class="flex justify-center">
                                <div <?= $bg_user_list ?> class="bg-cover bg-no-repeat bg-center w-10 h-10 rounded-full border-[1px] border-black"></div>
                            </div>
                        </td>
                        <td class="p-3 text-sm text-gray-700">
                            <div class="flex gap-2">
                                
                                <?php
                                if($row["u_administrador"] == 1){
                                ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-crown fill-yellow-300 size-5"><path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"/><path d="M5 21h14"/></svg>
                                <?php
                                }elseif($row["u_administrador"] == 9){
                                ?>
                                
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-crown fill-purple-600 size-5"><path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"/><path d="M5 21h14"/></svg>
                                <?php
                                }
                                ?>
                                <span><?= $row["u_username"] ?></span>
                            </div>
                        </td>

                        <td class="p-3 text-sm text-gray-700 w-20 text-center"><?= $row["p_id"] ?></td>



                        <td class="p-3 text-sm text-gray-700"><?= $row["p_titulo"] ?></td>
                        <td class="p-3 text-sm text-gray-700"><?= $row["p_data_criacao"] ?></td>

                        <td class="p-3 text-sm text-gray-700">
                            <div class="flex justify-around items-center">
                                <a href="#" class="flex items-center justify-center gap-1 bg-amber-400 text-neutral-800 py-3 px-4 rounded-lg select-none">
                                Editar
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                </a>
                                
                                <?php
                                if(administradorMax() || $row["u_id"] == $_SESSION["id_usuario"] || $row["u_administrador"] == 0){
                                    ?>
                                    <a href="#" class="flex items-center justify-center gap-1 bg-red-500 text-neutral-200 py-3 px-4 rounded-lg select-none" onclick="if(!confirm('Tem certeza que deseja excluir?')){ return false;}">
                                        Excluir
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2 size-5"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                        
                                    </a>
                                    <?php
                                }else{
                                    ?>
                                    <button class="flex items-center justify-center gap-1 bg-neutral-500 text-neutral-200 py-3 px-4 rounded-lg" disabled>
                                        Excluir
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2 size-5"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                    <?php
                                }
                                ?>
                            </div>
                        </td>
                        
                        
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        

    </div>

   
</main>



<?php
require 'footer.php';
?>