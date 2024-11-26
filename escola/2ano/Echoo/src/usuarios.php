<?php
session_start();
require 'logica_autenticacao.php';
require 'conexao.php';

require 'header.php';

if(isset($_GET["ordem"]) && !empty($_GET["ordem"])){
    $ordem = filter_input(INPUT_GET, "ordem", FILTER_SANITIZE_SPECIAL_CHARS);
  }else{
    $ordem = "username";
  }



  if(isset($_POST["busca"]) && !empty($_POST["busca"])){
    $busca = filter_input(INPUT_POST, "busca", FILTER_SANITIZE_SPECIAL_CHARS);
    $buscaOriginal = $busca;
    $tipoBusca = filter_input(INPUT_POST, "tipoBusca", FILTER_SANITIZE_SPECIAL_CHARS);
    
    if($tipoBusca == "username"){

      $busca = "%" . $busca . "%";

      $sql = "SELECT id, username, email, url_imagem, data_criacao, administrador FROM Usuarios WHERE username like ? ORDER BY $ordem";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute([$busca]);
    }elseif($tipoBusca == "id"){
      $buscaInt = intval($busca);

      $sql = "SELECT id, username, email, url_imagem, data_criacao, administrador FROM Usuarios WHERE id = ? ORDER BY $ordem";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute([$buscaInt]);
    }elseif($tipoBusca == "email"){
      
      $busca = "%" . $busca . "%";

      $sql = "SELECT id, username, email, url_imagem, data_criacao, administrador FROM Usuarios WHERE email like ? ORDER BY $ordem";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute([$busca]);
    }else{

      $buscaInt = intval($busca);

      $busca = "%" . $busca . "%";

      

      $sql = "SELECT id, username, email, url_imagem, data_criacao, administrador FROM Usuarios WHERE email like ? OR username like ? OR id = ? ORDER BY $ordem";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute([$busca, $busca, $buscaInt]);
    }
}else{
  $sql = "SELECT id, username, email, url_imagem, data_criacao, administrador FROM Usuarios ORDER BY $ordem";
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
            Você está buscando por "<mark><?= $buscaOriginal?></mark>", <a href="listagem.php?ordem=<?=$ordem?>">limpar</a>.
        </div>
    </div>
    <hr>
    <?php
    }
    ?>

    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                <?php
                    if($ordem == "username"){

                    
                ?>

                <?php
                    if(administrador()){
                ?>
                <th scope="col" style="width: 10%;" >
                    <a href="?ordem=id">ID</a>
                </th>
                <?php
                    }
                ?>
                <th scope="col" style="width: 20%;" >
                    Imagem
                </th>
                <th scope="col" style="width: 20%;" >
                    Username<i data-feather="chevron-down"></i>
                </th>
                <?php
                    if(administrador()){
                ?>
                <th scope="col" style="width: 20%;" >
                    <a href="?ordem=email">Email</a>
                </th>
                <th scope="col" style="width: 20%;" >
                    Data de Criação
                </th>
                <?php  
                    }
                ?>

                <?php  
                    }elseif($ordem == "id"){

                    
                ?>
                <?php
                    if(administrador()){
                ?>
                <th scope="col" style="width: 10%;" >
                    ID<i data-feather="chevron-down"></i>
                </th>
                <?php  
                    }
                ?>
                <th scope="col" style="width: 20%;" >
                    Imagem
                </th>
                <th scope="col" style="width: 20%;" >
                    <a href="?ordem=username">Username</a>
                </th>

                <?php
                    if(administrador()){
                ?>
                <th scope="col" style="width: 20%;" >
                    <a href="?ordem=email">Email</a>
                </th>
                <th scope="col" style="width: 20%;" >
                    Data de Criação
                </th>
                <?php  
                    }
                ?>

                <?php  
                    }elseif($ordem == "email"){

                    
                        ?>

                        <?php
                        if(administrador()){
                        ?>
                        <th scope="col" style="width: 10%;" >
                            <a href="?ordem=id">ID</a>
                        </th>
                        <?php  
                            }
                        ?>
                        <th scope="col" style="width: 20%;" >
                            Imagem
                        </th>
                        <th scope="col" style="width: 20%;" >
                            <a href="?ordem=username">Username</a>
                        </th>
                        <?php
                            if(administrador()){
                        ?>
                        <th scope="col" style="width: 20%;" >
                            Email<i data-feather="chevron-down"></i>
                        </th>
                        <th scope="col" style="width: 20%;" >
                            Data de Criação
                        </th>
                        <?php  
                            }
                        ?>
        
                        <?php  
                            }
                        ?>
               


                

                <?php
                    if(administrador()){

                ?>
                <th scope="col" style="width: 25%;">Administrador</th>
                <?php
                    }
                ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($row = $stmt->fetch()){
                ?>
                <tr>
                <?php
                    if(administrador()){
                ?>

                <td><?=$row["id"]?></td>

                <?php
                }
                ?>

                <td>
                <?php
                    $urlImagemList = $row["url_imagem"];
                    $bg_user_list = "style=\"background-image: url('$urlImagemList');\""
                ?>
                    <div <?=$bg_user_list?> class="bg-cover bg-no-repeat bg-center w-10 h-10 rounded-full"></div>
                </td>
                <td><?=$row["username"]?></td>



                <?php
                    if(administrador()){

                    
                ?>
                <td><?=$row["email"]?></td>
                <td><?=$row["data_criacao"]?></td>
                <td>
                    <a href="formulario-alterar-pratos.php?id=<?=$row["id"]?>" class="btn btn-sm btn-warning">
                        <span data-feather="edit"></span>
                        Editar
                    </a>
                </td>
                <td>
                    <a href="excluir-pratos.php?id=<?=$row["id"]?>" class="btn btn-sm btn-danger" onclick="if(!confirm('Tem certeza que deseja excluir?')) return false;">
                        <span data-feather="trash-2"></span>
                        Excluir
                    </a>
                </td>
                <?php
                    }
                ?>
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