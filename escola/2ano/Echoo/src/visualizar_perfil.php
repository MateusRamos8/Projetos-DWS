<?php
session_start();
require "logica_autenticacao.php";
require "conexao.php";

if(!autenticado()){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Operação não permitida!";
    $_SESSION["msg"] = "Você não tem permissão para acessar essa página.";
    redireciona("index.php");
    die();
}
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);



$sql = "SELECT p.id, p.titulo, p.url_imagem, p.data_criacao
        FROM posts p 
        WHERE p.id_usuario = ?
        ORDER BY p.data_criacao DESC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = $e->getMessage();
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Erro ao carregar os posts.";
    $_SESSION["msg"] = $error;
    redireciona("index.php");
    die();
}

$sql = "SELECT id, nome, bio, qtd_posts, seguidores, seguindo, username, url_imagem, email, administrador FROM usuarios WHERE id = ? ";


try{
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$id]);
    $user = $stmt->fetch();
}catch(Exception $e){
    
    $error = $e->getMessage();
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Erro ao carregar o usuário.";
    $_SESSION["msg"] = $error;
    redireciona("index.php");
    die();
}

if($stmt->rowCount() <= 0){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Erro ao carregar o usuário.";
    $_SESSION["msg"] = "usuário inexistente";
    redireciona("index.php");
    die();
}


require "header.php";
?>

<main class="text-white flex justify-center p-10">
    <div class="flex flex-col w-[800px]">
        <div class="flex gap-10 justify-center text-lg">
            <?php
                $urlUser = $user['url_imagem'];
                $styleUserBg = "style=\"background-image: url('" . $urlUser . "');\""
            ?>
            <div <?=$styleUserBg?> class="bg-cover bg-no-repeat bg-center rounded-full size-52"></div>
            <div class="flex flex-col gap-4 w-[600px]">
                <div class="flex items-center justify-between">
                    <a href=""><h2 class="text-2xl"><?=$user["username"]?></h2></a>
                    <div class="flex gap-4 items-center">
                        <?php
                        if($_SESSION["id_usuario"] == $id){
                            ?>
                            <a href="" class="flex items-center justify-center gap-2 bg-rose-900 text-neutral-200 py-2 px-4 rounded-lg select-none">
                                <span>Editar Perfil</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bolt size-5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><circle cx="12" cy="12" r="4"/></svg></a>
                            <?php
                        }else{
                            ?>
                            <?php
                                if(autenticado()){
                                    ?>
                                    <a href="" class="flex items-center justify-center gap-1 bg-rose-900 text-neutral-200 py-2 px-4 rounded-lg select-none">Seguindo</a>
                                    <?php
                                }else{
                                    ?>
                                    <a href="" class="flex items-center justify-center gap-1 bg-rose-900 text-neutral-200 py-2 px-4 rounded-lg select-none">Seguir</a>
                                    <?php
                                }
                            ?>
                        
                            <a href="" class="flex items-center justify-center gap-1 bg-rose-900 text-neutral-200 py-2 px-4 rounded-lg select-none">Enviar Mensagem</a>
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="flex gap-4">
                    <a href=""><strong><?=$user["qtd_posts"]?></strong> publicações</a>
                    <a href=""><strong><?=$user["seguidores"]?></strong> seguidores</a>
                    <a href=""><strong><?=$user["seguindo"]?></strong> seguindo</a>
                </div>
                <div class="flex flex-col gap-4">
                    <h3 class="font-bold text-xl"><?=$user["nome"]?></h3>
                    <p><?=$user["bio"]?></p>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center gap-1 mt-5 border-t-[1px] border-white py-2 select-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-grid-3x3 size-4"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M3 15h18"/><path d="M9 3v18"/><path d="M15 3v18"/></svg>
            Publicações
        </div>
        <div>
            <section class="flex flex-wrap justify-center">
                <?php
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        $urlPost = $post['url_imagem'];
                        $stylePostBg = "style=\"background-image: url('" . $urlPost . "');\""
                        ?>
                        <div class="post_item border-2 border-white m-4 rounded-xl text-white cursor-pointer" data-id="<?= htmlspecialchars($post['id']) ?>">
                            <div <?=$stylePostBg?> class="h-40 bg-cover bg-center rounded-t-[9.8px] border-b-4 border-b-neutral-300"></div>
                            <div class="p-4">
                                <h2 class="text-xl font-bold text-center"><?= htmlspecialchars($post['titulo']) ?></h2>
                                <p>Data: <?= htmlspecialchars($post['data_criacao']) ?></p>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <p class="text-white">Nenhum post encontrado.</p>
                <?php } ?>
            </section>
            <!-- Modal dinâmico para exibir detalhes do post -->
            <div id="viewPostModal" class="hidden fixed inset-0 w-[100%] h-[100%] bg-[rgba(0,0,0,0.5)] justify-center items-center break-words text-neutral-800">
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
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@2"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/simple-image"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@2.7.3/dist/quote.umd.min.js"></script>
<script>
    const btnOpenModal = document.getElementById('btnOpenModal');
    // Modal de visualização do post
    const viewPostModal = document.getElementById('viewPostModal');
    const btnCloseViewModal = document.getElementById('btnCloseViewModal');
    const postModalTitle = document.getElementById('postModalTitle');
    const postModalImage = document.getElementById('postModalImage');
    const postModalContent = document.getElementById('postModalContent');
    const postModalAuthor = document.getElementById('postModalAuthor');

    document.querySelectorAll('.post_item').forEach(post => {
    post.addEventListener('click', () => {
        const postId = post.dataset.id;

        // Requisição para buscar os detalhes do post
        fetch(`get_post.php?id=${postId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const { titulo, url_imagem, conteudo, username, data_criacao } = data.data;

                    console.log(conteudo);

                    // Preenche o modal com os dados recebidos
                    postModalTitle.textContent = titulo;
                    postModalImage.src = url_imagem;
                    postModalAuthor.textContent = `Autor: ${username} | Data: ${data_criacao}`;
                    postModalContent.innerHTML = conteudo.map(block => {
                        switch (block.type) {
                            case 'paragraph':
                                return `<p>${block.data.text}</p>`;
                            case 'header':
                                return `<h${block.data.level}>${block.data.text}</h${block.data.level}>`;
                            case 'list':
                                // Corrigindo a exibição dos itens da lista
                                if (Array.isArray(block.data.items)) {
                                    if(block.data.style == 'checklist'){
                                        const items = block.data.items
                                        .map(item => {
                                            const checkedClass = item.meta.checked ? 'cdx-list__checkbox--checked' : ''; // Verifica se está marcado
                                            return `
                                                <li class="cdx-list__item">
                                                    <div class="cdx-list__checkbox ${checkedClass}">
                                                        <span class="cdx-list__checkbox-check">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M7 12L10.4884 15.8372C10.5677 15.9245 10.705 15.9245 10.7844 15.8372L17 9"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="cdx-list__item-content" contenteditable="true" data-empty="false">${item.content}</div>
                                                </li>`;
                                        })
                                        .join('');
                                    return `<ul class="cdx-list cdx-list-checklist">${items}</ul>`;
                                    }
                                    const items = block.data.items
                                        .map(item => `<li>${item.content}</li>`) // Processa os itens da lista
                                        .join('');
                                    return block.data.style == 'ordered'
                                        ? `<ol>${items}</ol>` // Lista ordenada
                                        : `<ul>${items}</ul>`; // Lista não ordenada
                                }
                                return ''; // Retorna vazio caso não haja itens
                            case 'image':
                                return `<figure><img src="${block.data.url}" alt="${block.data.caption}"><figcaption class="break-words">${block.data.caption}</figcaption></figure>`;
                            case 'embed':
                                return `<div class="ce-block" data-id="_DN67PpwVa"><div class="ce-block__content"><div class="cdx-block embed-tool"><preloader class="embed-tool__preloader"><div class="embed-tool__url">${block.data.source}</div></preloader><iframe style="${block.data.width}" height="${block.data.height}" frameborder="0" allowfullscreen="" src="${block.data.embed}" class="embed-tool__content"></iframe><div class="break-words">${block.data.caption}</div></div></div></div>`;
                            case 'quote':
                                return `<blockquote class="cdx-block cdx-quote"><div class="cdx-input cdx-quote__text border-none h-auto max-w-full break-words" contenteditable="false" data-empty="false">"${block.data.text}"</div><div class="cdx-input cdx-quote__caption border-none break-words" contenteditable="false" data-empty="false">Autor: ${block.data.caption}</div></blockquote>`
                            default:
                                return '';
                        }
                    }).join('');
                    viewPostModal.classList.remove('hidden');
                    viewPostModal.classList.add('flex');
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Erro ao buscar o post:', error));
    });
});


btnCloseViewModal.addEventListener('click', () => {
    viewPostModal.classList.add('hidden');
    viewPostModal.classList.remove('flex');
});
window.addEventListener('click', (e) => {
    if(e.target === viewPostModal){
        viewPostModal.classList.remove('flex');
        viewPostModal.classList.add('hidden');
    }
});


</script>

<?php
require "footer.php";
?>