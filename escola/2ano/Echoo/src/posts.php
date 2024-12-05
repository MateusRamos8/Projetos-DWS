<?php
session_start();
require 'logica_autenticacao.php';
require 'conexao.php';

// Consulta para obter os posts
$sql = "SELECT p.id, p.titulo, p.url_imagem, p.data_criacao, u.username AS autor
        FROM posts p
        JOIN usuarios u ON p.id_usuario = u.id
        ORDER BY p.data_criacao DESC";

try {
    $stmt = $conn->query($sql);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<p>Erro ao carregar os posts: " . $e->getMessage() . "</p>";
    exit;
}



require 'header.php';
?>

<main class="p-10">
    <h1 class="text-white text-5xl">Posts</h1>
    
    <div class="flex justify-center">
        <button id="btnOpenModal" type="button" class="text-white bg-rose-700 py-4 px-6 rounded-xl">Criar Post</button>
    </div>

    <section class="flex flex-wrap">
        <?php
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $urlPost = $post['url_imagem'];
                $styleBg = "style=\"background-image: url('" . $urlPost . "');\"";
                ?>
                <div class="post_item border-2 border-white m-4 rounded-xl text-white cursor-pointer" data-id="<?= htmlspecialchars($post['id']) ?>">
                    <div <?=$styleBg?> class="h-40 bg-cover bg-center rounded-t-xl border-b-4 border-b-neutral-300"></div>
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-center"><?= htmlspecialchars($post['titulo']) ?></h2>    
                        <p>Autor: <?= htmlspecialchars($post['autor']) ?></p>
                        <p>Data: <?= htmlspecialchars($post['data_criacao']) ?></p>
                    </div>
                </div>
            <?php }
        } else { ?>
            <p class="text-white">Nenhum post encontrado.</p>
        <?php } ?>

    </section>

    <!-- Modal dinâmico para exibir detalhes do post -->
    <div id="viewPostModal" class="hidden fixed inset-0 w-[100%] h-[100%] bg-[rgba(0,0,0,0.5)] justify-center items-center break-words">
        <div class="bg-white p-5 rounded-md w-[90%] max-w-[800px] max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h2 id="postModalTitle" class="text-xl font-bold"></h2>
                <span class="hover:text-red-600 cursor-pointer" id="btnCloseViewModal">&times;</span>
            </div>
            <img id="postModalImage" class="w-full rounded-md mb-4" src="" alt="">
            <p id="postModalAuthor" class="text-gray-600 text-sm"></p>
            <div id="postModalContent" class="text-black mb-4 prose prose-modal max-w-[740px] w-[740px]"></div>
        </div>
    </div>

    <!-- Modal para criar novo post -->
    <div id="modal" class="hidden fixed inset-0 w-[100%] h-[100%] bg-[rgba(0,0,0,0.5)] justify-center items-center text-black">
        <div class="bg-white p-5 rounded-md w-[90%] max-w-[800px] max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h2 class="m-0">Criar Novo Post</h2>
                <span class="hover:text-red-600 cursor-pointer" id="btnCloseModal">&times;</span>
            </div>
            <form id="postForm" class="flex flex-col items-center">
                <input type="text" name="titulo" id="titulo" placeholder="Insira o título do post aqui." class="bg-transparent border-b-2 p-3 focus:outline-none text-black w-[775px]" maxlength="50" required>
                <input type="url" name="urlImagem" id="urlImagem" placeholder="Insira a URL da imagem de banner aqui." class="bg-transparent border-b-2 p-3 focus:outline-none text-black w-[775px]" maxlength="300" required>
                <div id="editorjs" class="bg-white text-black prose prose-modal max-w-[775px] w-[775px]"></div>
                <button type="button" id="saveBtn" class="text-black">Salvar</button>
            </form>
        </div>
    </div>


    


</main>

<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/simple-image"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@2.7.3/dist/quote.umd.min.js"></script>
<script src="<?=addCacheBuster(file: $editorjsFile)?>"></script>

<?php
require 'footer.php';
?>
