<?php
session_start();
require 'logica_autenticacao.php';
require 'conexao.php';

require 'header.php';

if(isset($_GET["ordem"]) && !empty($_GET["ordem"])){
    $ordem = filter_input(INPUT_GET, "ordem", FILTER_SANITIZE_SPECIAL_CHARS);
  }else{
    $ordem = "nome";
  }



  if(isset($_POST["busca"]) && !empty($_POST["busca"])){
    $busca = filter_input(INPUT_POST, "busca", FILTER_SANITIZE_SPECIAL_CHARS);
    $buscaOriginal = $busca;
    $tipoBusca = filter_input(INPUT_POST, "tipoBusca", FILTER_SANITIZE_SPECIAL_CHARS);
    
    if($tipoBusca == "username"){

      $busca = "%" . $busca . "%";

      $sql = "SELECT id, username, email, url_imagem, administrador FROM pratos WHERE username like ? ORDER BY $ordem";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute([$busca]);
    }elseif($tipoBusca == "id"){
      $buscaInt = intval($busca);

      $sql = "SELECT id, username, email, url_imagem, administrador FROM pratos WHERE id = ? ORDER BY $ordem";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute([$buscaInt]);
    }elseif($tipoBusca == "email"){
      
      $busca = "%" . $busca . "%";

      $sql = "SELECT id, username, email, url_imagem, administrador FROM pratos WHERE email like ? ORDER BY $ordem";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute([$busca]);
    }else{

      $buscaInt = intval($busca);

      $busca = "%" . $busca . "%";

      

      $sql = "SELECT id, username, email, url_imagem, administrador FROM pratos WHERE email like ? OR username like ? OR id = ? ORDER BY $ordem";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute([$busca, $busca, $buscaInt]);
    }
}else{
  $sql = "SELECT id, username, url_imagem, descricao, administrador FROM pratos ORDER BY $ordem";
  $stmt = $conn->query($sql);

}

?>

<main class="text-white flex flex-col">
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
                <input type="text" id="search" name="search" class="select-none bg-transparent w-[35vw] h-14 border-b-white border-2 rounded-xl p-3 focus:outline-none" maxlength="200" required placeholder="Dados da Busca">
            </div>
            <div>
                <button type="submit" class="block select-none w-50 h-14 rounded-xl border-2 border-white px-4">Pesquisar</button>
            </div>
        </form>
    </div>
    <?php
    if(isset($_POST["busca"]) && !empty($_POST["busca"])){
    ?>

    <div class="flex justify-center items-center">
        <div class="text-zinc-500" role="alert">
            Você está buscando por "<mark class="fst-italic"><?= $buscaOriginal?></mark>", <a href="listagem.php?ordem=<?=$ordem?>">limpar</a>.
        </div>
    </div>
    <hr>
    <?php
    }
    ?>

    <div>
        
    </div>
</main>



<?php
require 'footer.php';
?>