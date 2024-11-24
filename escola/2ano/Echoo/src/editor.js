 // Configuração do Editor.js
 const editor = new EditorJS({
    holder: 'editorjs',

    tools: { 
        header: {
          class: Header, 
          inlineToolbar: ['link'],
          defaultLever: 1,
        }, 
        list: {
            class: EditorjsList,
            inlineToolbar: true,
            config: {
              defaultStyle: 'unordered',
              maxLevel: 1,
            },
       },
       image: SimpleImage,
       embed: {
        class: Embed,
        config: {
          services: {
            youtube: true,
            coub: true
          }
        }
      },
      quote: {
        class: Quote,
        inlineToolbar: true,
        shortcut: 'CMD+SHIFT+O',
        config: {
          quotePlaceholder: 'Enter a quote',
          captionPlaceholder: 'Quote\'s author',
        },
      },

       
      
}});

// Modal handlers
const modal = document.getElementById('modal');
const btnOpenModal = document.getElementById('btnOpenModal');
const btnCloseModal = document.getElementById('btnCloseModal');
// Modal de visualização do post
const viewPostModal = document.getElementById('viewPostModal');
const btnCloseViewModal = document.getElementById('btnCloseViewModal');
const postModalTitle = document.getElementById('postModalTitle');
const postModalImage = document.getElementById('postModalImage');
const postModalContent = document.getElementById('postModalContent');
const postModalAuthor = document.getElementById('postModalAuthor');

function renderListItems(items, style) {
    const baseClass = `cdx-list cdx-list-${style}`;
    const childrenClass = `${baseClass}__item-children`;

    return items
        .map(item => {
            const hasChildren = Array.isArray(item.items) && item.items.length > 0;
            const checkedClass = style === 'checklist' && item.meta?.checked ? 'cdx-list__checkbox--checked' : '';

            return `
                <li class="cdx-list__item">
                    ${style === 'checklist' ? `
                        <div class="cdx-list__checkbox ${checkedClass}">
                            <span class="cdx-list__checkbox-check">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M7 12L10.4884 15.8372C10.5677 15.9245 10.705 15.9245 10.7844 15.8372L17 9"></path>
                                </svg>
                            </span>
                        </div>` : ''
                    }
                    <div class="cdx-list__item-content" contenteditable="true" data-empty="false">${item.content}</div>
                    ${hasChildren ? `<ul class="${childrenClass}">${renderListItems(item.items, style)}</ul>` : ''}
                </li>
            `;
        })
        .join('');
}

// Função para renderizar a lista principal
function renderList(block) {
    const { style, items } = block.data;

    if (!Array.isArray(items)) return '';

    const baseClass = `cdx-list cdx-list-${style}`;
    const renderedItems = renderListItems(items, style);

    return style === 'ordered'
        ? `<ol class="${baseClass}">${renderedItems}</ol>` // Lista ordenada
        : `<ul class="${baseClass}">${renderedItems}</ul>`; // Lista não ordenada ou checklist
}

btnOpenModal.addEventListener('click', () => {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
});

btnCloseModal.addEventListener('click', () => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
});

// Salvar post
document.getElementById('saveBtn').addEventListener('click', () => {
    const titulo = document.getElementById('titulo').value;
    const urlImagem = document.getElementById('urlImagem').value;

    editor.save().then((outputData) => {
        const postData = {
            titulo: titulo,
            url_imagem: urlImagem,
            blocks: outputData.blocks,
        };

        fetch('inserir_post.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(postData)
        })
        .then(response => {
            // Verifique o status da resposta e o conteúdo
            if (!response.ok) {
                console.error('Erro na requisição:', response.status, response.statusText);
                return response.text(); // Retorne como texto para debug
            }
            return response.json();
        })
        .then(data => {
            if (typeof data === 'string') {
                // Se a resposta for um erro HTML, mostre-o
                console.error('Resposta HTML recebida:', data);
            } else {
                if (data.success) {
                    alert(data.message);  // Exibe mensagem de sucesso
                    window.location.reload(); // Recarrega a página
                } else {
                    alert(data.message);  // Exibe mensagem de erro
                }
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
          
    });
});

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

// Fechar modal ao clicar fora ou no botão de fechar
btnCloseViewModal.addEventListener('click', () => {
    viewPostModal.classList.add('hidden');
    viewPostModal.classList.remove('flex');
});

// Fechar modal ao clicar fora
window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }else{
        if(e.target === viewPostModal){
        viewPostModal.classList.remove('flex');
        viewPostModal.classList.add('hidden');
    }
}});