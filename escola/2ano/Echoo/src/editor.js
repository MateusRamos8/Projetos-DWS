 // Configuração do Editor.js
 const editor = new EditorJS({
    holder: 'editorjs',

    tools: { 
        header: {
          class: Header, 
          inlineToolbar: ['link'],
          defaultLever: 1,
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
    const titulo = document.getElementById('titulo').value.trim(); // Remove espaços extras
    const urlImagem = document.getElementById('urlImagem').value.trim(); // Remove espaços extras

    // Verifica se os campos obrigatórios foram preenchidos
    if (!titulo || !urlImagem) {
        alert('Por favor, preencha todos os campos obrigatórios!');
        return;
    }

    // Salva o conteúdo do editor
    editor.save().then((outputData) => {

        const postData = {
            titulo: titulo,
            url_imagem: urlImagem,
            blocks: outputData, // Conteúdo do editor
        };

        console.log(postData);

        // Realiza a requisição para o servidor
        
        fetch('inserir_post.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(postData), // Converte os dados para JSON
        })
            .then(response => {
                console.log('Resposta do servidor:', response); // Loga a resposta bruta
                if (!response.ok) {
                    console.error('Erro na requisição:', response.status, response.statusText);
                    return response.text(); // Retorna o erro como texto
                }
                return response.json(); // Tenta converter para JSON
            })
            .then(data => {
                console.log('Dados recebidos do servidor:', data); // Loga os dados recebidos

                if (typeof data === 'string') {
                    console.error('Resposta HTML recebida (provavelmente erro):', data);
                } else {
                    if (data.success) {
                        alert(data.message); // Exibe mensagem de sucesso
                        window.location.reload(); // Recarrega a página
                    } else {
                        alert(data.message); // Exibe mensagem de erro
                    }
                }
            })
            .catch(error => {
                console.error('Erro na requisição:', error); // Captura erros de rede ou execução
            });
    }).catch(error => {
        console.error('Erro ao salvar dados do editor:', error); // Captura erros do editor
    });
});

document.querySelectorAll('.post_item').forEach(post => {
    post.addEventListener('click', () => {
        const postId = post.dataset.id;

        // Requisição para buscar os detalhes do post
        fetch(`get_post.php?id=${postId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar o post');
                }
                return response.json(); // Obtemos o JSON da resposta
            })
            .then(data => {
                if (data.success) {
                    const { titulo, url_imagem, username, data_criacao, conteudo } = data.data;

                    // Preenche os elementos do modal
                    postModalTitle.textContent = titulo;
                    postModalImage.src = url_imagem;
                    postModalAuthor.textContent = `Autor: ${username} | Data: ${data_criacao}`;
                    postModalContent.innerHTML = conteudo;

                    // Exibe o modal
                    viewPostModal.classList.remove('hidden');
                    viewPostModal.classList.add('flex');
                } else {
                    alert(data.message || 'Erro ao carregar o post.');
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