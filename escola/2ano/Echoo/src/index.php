<?php
    session_start();
    require 'logica_autenticacao.php';
    require 'header.php';
?>

<main class="flex justify-center p-16">
    <?php

    if(isset($_SESSION["result"]) && !$_SESSION["result"]){

        ?>
        <div class="w-96 p-5 text-red-900 font-bold bg-red-200 border-4 border-red-700 rounded-md">
            <h4><?=$_SESSION["msg_erro"]?></h4>
        </div>
        <?php

        unset($_SESSION["msg_erro"]);
        unset($_SESSION["result"]);
    }
    ?>
</main>

<?php
    require 'footer.php';

?>