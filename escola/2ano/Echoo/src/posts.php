<?php
session_start();

require 'logica_autenticacao.php';



require 'header.php';
?>

<main>
    <div id="editorjs" class="bg-white text-black"></div>
    <button id="saveBtn" class="text-white">Salvar</button>
</main>


<script scr="./editor.js"></script>
<?php
require 'footer.php';
?>