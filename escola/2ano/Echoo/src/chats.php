<?php
session_start();
require "conexao.php";
require "logica_autenticacao.php";

if(!autenticado()){
    $_SESSION["result"] = false;
    $_SESSION["titulo"] = "Operação não permitida!";
    $_SESSION["msg"] = "Você não tem permissão para acessar essa página.";
    redireciona("index.php");
    die();
}

$overflow = false;
require "header.php";

?>

<main>
    <!-- component -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="w-1/4 h-screen bg-neutral-800">
            <!-- Sidebar Header -->
            <header class="p-4 flex justify-between items-center bg-rose-900 text-white">
                <div class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                    <h1 class="text-2xl font-semibold select-none">Chats</h1>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" id="chat_create_bar_btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus stroke-white">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                    </button>
                    <button type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical">
                            <circle cx="12" cy="12" r="1" />
                            <circle cx="12" cy="5" r="1" />
                            <circle cx="12" cy="19" r="1" />
                        </svg>
                    </button>
                </div>
                
            </header>
            

            <!--Barra Lateral - Criação de Chats-->
            <aside class="z-10 flex flex-col gap-1 p-2 h-[calc(100vh-5rem)] w-1/4 bg-neutral-800 absolute top-20 -translate-x-[100%] transition-all duration-500 ease-in-out" id="chat_create_bar">
                    <header class="flex flex-col mb-2 gap-2">
                        <div class="flex items-center mb-2 text-white gap-4 p-2">
                            <div class="flex items-center justify-center size-6">
                                <button class="flex justify-center items-center rounded-lg" id="chat_create_bar_close_btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left stroke-white size-6"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                                </button>
                            </div>
                            <h3 class="pt-1">Criar Chat</h3>
                        </div>
                        
                        <div class="flex items-center px-4 py-2 gap-4 bg-neutral-700 w-full rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 stroke-neutral-200">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <input class="w-full bg-transparent focus:outline-none text-neutral-200" type="text" name="buscaSeguindo" id="buscaSeguindo" placeholder="Pesquise por um usuário...">
                        </div>

                        <button type="button" id="chat_create_bar_group_btn" class="flex items-center text-left justify-start cursor-pointer hover:bg-neutral-700 p-2 rounded-md">
                                <div class="flex justify-center items-center w-12 h-12 rounded-full mr-3 bg-rose-800">   
                                    <svg viewBox="0 0 135 90" preserveAspectRatio="xMidYMid meet" class="stroke-white fill-white size-7" fill="none"><title>group-two</title><path d="M63.282 19.2856C63.282 29.957 54.8569 38.5713 44.3419 38.5713C33.827 38.5713 25.339 29.957 25.339 19.2856C25.339 8.6143 33.827 0 44.3419 0C54.8569 0 63.282 8.6143 63.282 19.2856ZM111.35 22.1427C111.35 31.9446 103.612 39.857 93.954 39.857C84.296 39.857 76.5 31.9446 76.5 22.1427C76.5 12.3409 84.296 4.4285 93.954 4.4285C103.612 4.4285 111.35 12.3409 111.35 22.1427ZM44.3402 51.428C29.5812 51.428 0 58.95 0 73.928V85.714C0 89.25 2.8504 90 6.3343 90H82.346C85.83 90 88.68 89.25 88.68 85.714V73.928C88.68 58.95 59.0991 51.428 44.3402 51.428ZM87.804 52.853C88.707 52.871 89.485 52.886 90 52.886C104.759 52.886 135 58.95 135 73.929V83.571C135 87.107 132.15 90 128.666 90H95.854C96.551 88.007 96.995 85.821 96.995 83.571L96.75 73.071C96.75 63.51 91.136 59.858 85.162 55.971C83.772 55.067 82.363 54.15 81 53.143C80.981 53.123 80.962 53.098 80.941 53.07C80.893 53.007 80.835 52.931 80.747 52.886C82.343 52.747 85.485 52.808 87.804 52.853Z" fill="white"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <h2 class="text-white text-lg font-semibold">Novo Grupo</h2>
                                </div>
                        </button>
                    </header>

                    
                    <div class="px-2 flex flex-col gap-2 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-neutral-800 [&::-webkit-scrollbar-thumb]:bg-rose-900 [&::-webkit-scrollbar-track]:rounded-full [&::-webkit-scrollbar-thumb]:rounded-full">

                    <?php
                        $sql = "SELECT u.id AS id, u.username AS username, u.bio AS bio, u.url_imagem AS url_imagem FROM usuarios u JOIN seguidores s ON u.id = s.id_seguido WHERE s.id_seguidor = ?";

                        try{
                            $stmt = $conn->prepare($sql);
                            $result = $stmt->execute([$_SESSION["id_usuario"]]);
                            $rowSeguido = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if($rowSeguido){
                                ?>
                                <div class="flex items-center p-4 border-t border-neutral-600">
                                    <h4 class="source-code-pro text-rose-200 font-bold text-xl indent-2">Seguindo</h4>
                                </div>
                                <?php
                                foreach($rowSeguido as $seguido){
                                    $seguidoUrlImagem = $seguido["url_imagem"];
                                    $styleIconSeguido = "style=\"background-image: url('$seguidoUrlImagem');\"";
                                
                                ?>
                                <button type="button" data-id="<?=$seguido["id"]?>" class="criarChatPrivado flex items-center text-left cursor-pointer hover:bg-neutral-700 p-2 rounded-md">
                                    <div <?=$styleIconSeguido?> class="bg-cover bg-center bg-no-repeat w-12 h-12 bg-gray-300 rounded-full mr-3"></div>
                                    <div class="flex-1">
                                        <h2 class="text-white text-lg font-semibold"><?=$seguido["username"]?></h2>
                                        <p class="text-zinc-400"><?=$seguido["bio"]?></p>
                                    </div>
                                </button>
                                <?php
                                }
                            }else{
                                ?>
                                <p class="text-white p-4">Você ainda não seguiu ninguém.</p>
                                <?php
                            }

                        }catch(Exception $e){
                            $_SESSION["result"] = false;
                            $_SESSION["msg_erro"] = "Erro ao selecionar seguindo.";
                            $_SESSION["erro"] = $e->getMessage();
                        }
                    ?>
                        
                        

                        <!-- <div class="flex items-center cursor-pointer hover:bg-neutral-700 p-2 rounded-md ">
                            <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
                                <img src="https://placehold.co/200x/ffa8e4/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar" class="w-12 h-12 rounded-full">
                            </div>
                            <div class="flex-1">
                                <h2 class="text-white text-lg font-semibold">Alice</h2>
                                <p class="text-zinc-400">Bio</p>
                            </div>
                        </div>

                        <div class="flex items-center cursor-pointer hover:bg-neutral-700 p-2 rounded-md ">
                            <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
                                <img src="https://placehold.co/200x/ffa8e4/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar" class="w-12 h-12 rounded-full">
                            </div>
                            <div class="flex-1">
                                <h2 class="text-white text-lg font-semibold">Alice</h2>
                                <p class="text-zinc-400">Bio</p>
                            </div>
                        </div>  -->
                    </div>
            </aside>

            <!--Barra Lateral - Criação de Chats - GRUPOS-->
            <aside class="z-10 flex flex-col justify-between gap-1 p-2 h-[calc(100vh-5rem)] w-1/4 bg-neutral-800 absolute top-20 -translate-x-[100%] transition-all duration-500 ease-in-out overflow-hidden break-all" id="chat_create_bar_group">
                    <div class="flex flex-col gap-1 ">
                        <header class="flex flex-col mb-2 gap-2">
                            <div class="flex items-center mb-2 text-white gap-4 p-2">
                                <div class="flex items-center justify-center size-6">
                                    <button class="flex justify-center items-center rounded-lg" id="chat_create_bar_group_close_btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left stroke-white size-6"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                                    </button>
                                </div>
                                <h3 class="pt-1">Adicionar Pessoas ao grupo</h3>
                            </div>
                        
                            <div class="flex flex-wrap px-4 py-2 gap-4 w-full" id="UsersAdded">
                            </div>
                            <div class="flex items-center px-4 py-2 gap-4 bg-neutral-700 w-full rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 stroke-neutral-200">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                                <input class="w-full bg-transparent focus:outline-none text-neutral-200" type="text" name="buscaSeguindoGroup" id="buscaSeguindoGroup" placeholder="Pesquise por um Chat...">
                            </div>
                        
                        </header>
                        
                        
                        <div class="px-2 flex flex-col gap-2 h-[65vh] overflow-y-scroll [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-neutral-800 [&::-webkit-scrollbar-thumb]:bg-rose-900 [&::-webkit-scrollbar-track]:rounded-full [&::-webkit-scrollbar-thumb]:rounded-full">
                        <?php
                            $sql = "SELECT u.id AS id,u.username AS username, u.bio AS bio, u.url_imagem AS url_imagem FROM usuarios u JOIN seguidores s ON u.id = s.id_seguido WHERE s.id_seguidor = ?";
                            try{
                                $stmt = $conn->prepare($sql);
                                $result = $stmt->execute([$_SESSION["id_usuario"]]);
                                $rowSeguido = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                if($rowSeguido){
                                    ?>
                                    <div class="flex items-center p-4 border-t border-neutral-600">
                                        <h4 class="source-code-pro text-rose-200 font-bold text-xl indent-2">Seguindo</h4>
                                    </div>
                                    <?php
                                    foreach($rowSeguido as $seguido){
                                        $seguidoUrlImagem = $seguido["url_imagem"];
                                        $styleIconSeguido = "style=\"background-image: url('$seguidoUrlImagem');\"";
                        
                                    ?>
                                    <button type="button" id="buttonAddUserGroup_<?=$seguido["id"]?>" class="flex items-center cursor-pointer text-left hover:bg-neutral-700 p-2 rounded-md" value="<?=$seguido["id"]?>" data-id="<?=$seguido["id"]?>" data-username="<?=$seguido["username"]?>" data-url_imagem="<?=$seguido["url_imagem"]?>" data-bio="<?=$seguido["bio"]?>" onclick="addUserGroup(this)">
                                        <div <?=$styleIconSeguido?> class="bg-cover bg-center bg-no-repeat w-12 h-12 bg-gray-300 rounded-full mr-3"></div>
                                        <div class="flex-1">
                                            <h2 class="text-white text-lg font-semibold"><?=$seguido["username"]?></h2>
                                            <p class="text-zinc-400"><?=$seguido["bio"]?></p>
                                        </div>
                                    </button>
                                    <?php
                                    }
                                }else{
                                    ?>
                                    <p class="text-white p-4">Você ainda não seguiu ninguém.</p>
                                    <?php
                                }
                            }catch(Exception $e){
                                $_SESSION["result"] = false;
                                $_SESSION["msg_erro"] = "Erro ao selecionar seguindo.";
                                $_SESSION["erro"] = $e->getMessage();
                            }
                        ?>
                            <!-- <button type="button" class="flex items-center cursor-pointer text-left hover:bg-neutral-700 p-2 rounded-md" onclick="addUserGroup(this)" value="ID">
                                <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
                                    <img src="https://placehold.co/200x/ffa8e4/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar" class="w-12 h-12 rounded-full">
                                </div>
                                <div class="flex-1">
                                    <h2 class="text-white text-lg font-semibold">Alice</h2>
                                    <p class="text-zinc-400">Bio</p>
                                </div>
                            </button> -->
                        </div>
                    </div>

                    <div class="flex justify-center items-center w-full p-2 mb-5">
                            <button class="hidden items-center justify-center w-12 h-12 bg-rose-500 rounded-full" id="chat_create_bar_group_settings_btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right stroke-white"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </button>
                    </div> 
            </aside>

            <!--Barra Lateral - Criação de Chats - NOVO GRUPO-->
            <aside class="z-10 flex flex-col items-center gap-12 p-2 h-[calc(100vh-5rem)] w-1/4 bg-neutral-800 absolute top-20 -translate-x-[100%] transition-all duration-500 ease-in-out overflow-hidden break-all" id="chat_create_bar_group_settings">
                    <header class="flex flex-col mb-2 gap-2 w-full">
                        <div class="flex items-center mb-2 text-white gap-4 p-2">
                            <div class="flex items-center justify-center size-6">
                                <button class="flex justify-center items-center rounded-lg" id="chat_create_bar_group_settings_close_btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left stroke-white size-6"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                                </button>
                            </div>
                            <h3 class="pt-1">Novo Grupo</h3>
                        </div>
                    </header> 
                    <!--Imagem do Grupo -->
                    <div class="bg-gray-300 flex justify-center items-center rounded-full size-60">
                        <svg viewBox="0 0 135 90" preserveAspectRatio="xMidYMid meet" class="stroke-white fill-white size-40" fill="none"><title>group-two</title><path d="M63.282 19.2856C63.282 29.957 54.8569 38.5713 44.3419 38.5713C33.827 38.5713 25.339 29.957 25.339 19.2856C25.339 8.6143 33.827 0 44.3419 0C54.8569 0 63.282 8.6143 63.282 19.2856ZM111.35 22.1427C111.35 31.9446 103.612 39.857 93.954 39.857C84.296 39.857 76.5 31.9446 76.5 22.1427C76.5 12.3409 84.296 4.4285 93.954 4.4285C103.612 4.4285 111.35 12.3409 111.35 22.1427ZM44.3402 51.428C29.5812 51.428 0 58.95 0 73.928V85.714C0 89.25 2.8504 90 6.3343 90H82.346C85.83 90 88.68 89.25 88.68 85.714V73.928C88.68 58.95 59.0991 51.428 44.3402 51.428ZM87.804 52.853C88.707 52.871 89.485 52.886 90 52.886C104.759 52.886 135 58.95 135 73.929V83.571C135 87.107 132.15 90 128.666 90H95.854C96.551 88.007 96.995 85.821 96.995 83.571L96.75 73.071C96.75 63.51 91.136 59.858 85.162 55.971C83.772 55.067 82.363 54.15 81 53.143C80.981 53.123 80.962 53.098 80.941 53.07C80.893 53.007 80.835 52.931 80.747 52.886C82.343 52.747 85.485 52.808 87.804 52.853Z" fill="white"></path></svg>
                        
                    </div>  

                     <!--Nome do Grupo & chatUrlImagem? -->
                    
                    <div class="w-full flex flex-col gap-4">
                        <div class="w-full flex justify-center">
                            <input type="text" name="nomeGrupo" id="nomeGrupo" placeholder="Nome do Grupo" class="bg-transparent focus:outline-none border-b border-b-neutral-400 text-neutral-200 w-full px-4 py-2 mx-10" maxlength="100" required>
                        </div>
                        <div class="w-full flex justify-center">
                            <input type="url" name="url_imagem_icon_grupo" id="url_imagem_icon_grupo" placeholder="URL da imagem do Grupo" class="bg-transparent focus:outline-none border-b border-b-neutral-400 text-neutral-200 w-full px-4 py-2 mx-10" maxlength="400" required>
                        </div>
                    </div>
                

                    <!-- Permissões do Grupo -->
                    <div class="flex justify-center items-center w-full text-neutral-200 text-xl">
                        <button type="button" class="w-full flex justify-between items-center mx-5" id="group_permissions_btn">
                            <span>Permissões do Grupo</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right stroke-white"><path d="m9 18 6-6-6-6"/></svg>
                        </button>
                    </div>   
                    
                    <!-- Botão Criar Grupo -->
                    <div class="flex justify-center items-center w-[90%] p-2 absolute bottom-0 mb-[18vh]">
                        <button class="flex items-center justify-center w-12 h-12 bg-rose-500 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check stroke-white"><path d="M20 6 9 17l-5-5"/></svg>
                        </button>
                    </div> 
            </aside>

            <!--Barra Lateral - Permissões do Novo Grupo-->
            <aside class="z-10 flex flex-col items-center gap-12 p-2 h-[calc(100vh-5rem)] w-1/4 bg-neutral-800 absolute top-20 -translate-x-[100%] transition-all duration-500 ease-in-out overflow-hidden break-all" id="group_permissions">
                    <header class="flex flex-col mb-2 gap-2 w-full">
                        <div class="flex items-center mb-2 text-white gap-4 p-2">
                            <div class="flex items-center justify-center size-6">
                                <button class="flex justify-center items-center rounded-lg" id="group_permissions_close_btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left stroke-white size-6"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                                </button>
                            </div>
                            <h3 class="pt-1">Permissões do Grupo</h3>
                        </div>
                    </header> 
                    
            </aside>
            
            <!-- Pesquisar/Criar Chats -->
            <div class="flex items-center px-5 py-4 m-5 gap-4 bg-neutral-700 max-w-full rounded-xl select-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 stroke-neutral-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input class="w-full bg-transparent focus:outline-none text-neutral-200" type="text" name="buscaChats" id="buscaChats" placeholder="Pesquise por um Chat...">
            </div>

            <!-- Chat List -->
            <div id="chatList" class="overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-neutral-800 [&::-webkit-scrollbar-thumb]:bg-rose-900 [&::-webkit-scrollbar-track]:rounded-full [&::-webkit-scrollbar-thumb]:rounded-full p-3 mb-9 pb-40 h-screen">

           


                
                    

            


                <!-- <button type="button" class="flex items-center justify-between w-full text-left mb-4 cursor-pointer hover:bg-neutral-700 px-2 py-4 rounded-md group">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
                            <img src="https://placehold.co/200x/ffa8e4/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar" class="w-12 h-12 rounded-full">
                        </div>
                        <div class="flex-1">
                            <h2 class="text-white text-lg font-semibold">Alice</h2>
                            <p class="text-zinc-400">Hoorayy!!</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center mr-6 text-sm text-neutral-50 gap-2">
                        <span class="text-zinc-400"> 23:02:23</span>
                        <div class="flex items-center justify-center">
                            <span class="flex items-center justify-center text-[0.7rem] bg-rose-400 rounded-full size-6 translate-x-2 group-hover:-translate-x-2 transition-all duration-500">1</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down stroke-zinc-400 translate-x-12 -z-10 group-hover:z-0 group-hover:-translate-x-0 transition-[transform_0.5s]" ><path d="m6 9 6 6 6-6"/></svg>
                        </div>
                    </div>
                </button>
                
                <div class="flex items-center mb-4 cursor-pointer hover:bg-neutral-700 p-2 rounded-md">
                    <div class="w-12 h-12 bg-gray-300 rounded-full mr-3">
                        <img src="https://placehold.co/200x/ad922e/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar" class="w-12 h-12 rounded-full">
                    </div>
                    <div class="flex-1">
                        <h2 class="text-white text-lg font-semibold">Martin</h2>
                        <p class="text-zinc-400">That pizza place was amazing! We should go again sometime. 🍕</p>
                    </div>
                </div>  -->




            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="flex-1">
            <!-- Chat Header -->
            <header class="bg-neutral-800 p-4 text-gray-200 flex items-center justify-between gap-4">
                <button id="openDadosChat" class="flex gap-2 items-center w-[100%]">
                    <div id="chatIconImage" class="bg-cover bg-center bg-no-repeat size-16 rounded-full block mr-2"></div>
                    <div class="flex flex-col text-left">
                        <h1 id="chatTitle" class="text-2xl font-semibold select-none"> </h1>
                        <p class="text-sm text-neutral-400 select-none"> </p>
                    </div>
                </button>
                <div class="flex items-center gap-5">
                    <button id="searchMessageBtn" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                    <button id="chatOptionsBtn" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical">
                            <circle cx="12" cy="12" r="1" />
                            <circle cx="12" cy="5" r="1" />
                            <circle cx="12" cy="19" r="1" />
                        </svg>
                    </button>
                </div>

            </header>

            <!-- Chat Messages -->
            <div id="messagesContainer" class="h-screen overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-neutral-800 [&::-webkit-scrollbar-thumb]:bg-rose-900 [&::-webkit-scrollbar-track]:rounded-full [&::-webkit-scrollbar-thumb]:rounded-full p-4 pb-64">
                <!-- Incoming Message -->
                

                
            </div>

            <!-- Chat Input
            IMG <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-images"><path d="M18 22H4a2 2 0 0 1-2-2V6"/><path d="m22 13-1.296-1.296a2.41 2.41 0 0 0-3.408 0L11 18"/><circle cx="12" cy="8" r="2"/><rect width="16" height="16" x="6" y="2" rx="2"/></svg>
            MIC <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mic"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" x2="12" y1="19" y2="22"/></svg>
            SEND <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send-horizontal"><path d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z"/><path d="M6 12h16"/></svg> 
            -->
            <footer class="bg-neutral-700 p-4 absolute bottom-0 w-3/4">
                <form id="messageForm" class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus stroke-white">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    <div class="w-full text-white rounded-md bg-zinc-600">
                        <input type="text" id="messageInput" name="messageInput" placeholder="Digite uma Mensagem..." class="w-full bg-transparent p-2 focus:outline-none focus:border-none" autocomplete="off">
                    </div>
                    <button id="btnEnviarMensagem" type="submit" class="bg-rose-500 text-white px-4 py-2 rounded-md ml-2">Enviar</button>
                </form>
            </footer>
        </div>
    </div>
    <script>
        let lastMessageId = 0;
        
        let chat_create_barVisible = false;
        const chat_create_bar = document.getElementById("chat_create_bar");
        const chat_create_bar_btn = document.getElementById("chat_create_bar_btn");
        const chat_create_bar_close_btn = document.getElementById("chat_create_bar_close_btn");
        let chat_create_bar_groupVisible = false;
        const chat_create_bar_group = document.getElementById("chat_create_bar_group");
        const chat_create_bar_group_btn = document.getElementById("chat_create_bar_group_btn");
        const chat_create_bar_group_close_btn = document.getElementById("chat_create_bar_group_close_btn");
        let chat_create_bar_group_settingsVisible = false;
        const chat_create_bar_group_settings = document.getElementById("chat_create_bar_group_settings");
        const chat_create_bar_group_settings_btn = document.getElementById("chat_create_bar_group_settings_btn");
        const chat_create_bar_group_settings_close_btn = document.getElementById("chat_create_bar_group_settings_close_btn");
        let group_permissionsVisible = false;
        const group_permissions = document.getElementById("group_permissions");
        const group_permissions_btn = document.getElementById("group_permissions_btn");
        const group_permissions_close_btn = document.getElementById("group_permissions_close_btn");



        

        
        chat_create_bar_btn.addEventListener("click", ()=>{
        if(!chat_create_barVisible){
            chat_create_bar.classList.remove('-translate-x-[100%]');
            chat_create_barVisible = true;
        } else{
            chat_create_bar.classList.add('-translate-x-[100%]');
            chat_create_barVisible = false;
        }
        });

        chat_create_bar_close_btn.addEventListener("click", ()=>{
            chat_create_bar.classList.add('-translate-x-[100%]');
            chat_create_barVisible = false;
        });



        chat_create_bar_group_btn.addEventListener("click", ()=>{
        if(!chat_create_bar_groupVisible){
            chat_create_bar_group.classList.remove('-translate-x-[100%]');
            chat_create_bar_groupVisible = true;
        } else{
            chat_create_bar_group.classList.add('-translate-x-[100%]');
            chat_create_bar_groupVisible = false;
        }
        });

        chat_create_bar_group_close_btn.addEventListener("click", ()=>{
            chat_create_bar_group.classList.add('-translate-x-[100%]');
            chat_create_bar_groupVisible = false;
        });



        chat_create_bar_group_settings_btn.addEventListener("click", ()=>{
        if(!chat_create_bar_group_settingsVisible){
            chat_create_bar_group_settings.classList.remove('-translate-x-[100%]');
            chat_create_bar_group_settingsVisible = true;
        } else{
            chat_create_bar_group_settings.classList.add('-translate-x-[100%]');
            chat_create_bar_group_settingsVisible = false;
        }
        });

        chat_create_bar_group_settings_close_btn.addEventListener("click", ()=>{
            chat_create_bar_group_settings.classList.add('-translate-x-[100%]');
            chat_create_bar_group_settingsVisible = false;
        });



        group_permissions_btn.addEventListener("click", ()=>{
        if(!group_permissionsVisible){
            group_permissions.classList.remove('-translate-x-[100%]');
            group_permissionsVisible = true;
        } else{
            group_permissions.classList.add('-translate-x-[100%]');
            group_permissionsVisible = false;
        }
        });

        group_permissions_close_btn.addEventListener("click", ()=>{
            group_permissions.classList.add('-translate-x-[100%]');
            group_permissionsVisible = false;
        });


        async function createPrivateChat(userId) {
            const response = await fetch('create_chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    is_group: false,
                    users: [userId]
                })
            });

            const result = await response.json();
            if (result.success) {
                alert(result.message);
                window.location.reload();
            } else {
                alert("Erro ao criar chat privado: " + result.message);
            }
        }

        const criarChatPrivadoBtns = document.querySelectorAll('.criarChatPrivado');
        
        criarChatPrivadoBtns.forEach(button =>{
            button.addEventListener('click', event =>{
                createPrivateChat(button.dataset.id);
            })
        });



        let selectedUsers = [];
        let create_group_btnVisible = false;
        //chat_create_bar_group_settings_btn

        function showCreateGroupBtn(show){
            if(show){
                if(create_group_btnVisible){
                    return;
                }else{
                    chat_create_bar_group_settings_btn.classList.remove('hidden');
                    chat_create_bar_group_settings_btn.classList.add('flex');
                    create_group_btnVisible = true;
                }
                
            }else{
                if(selectedUsers.length == 0){
                    chat_create_bar_group_settings_btn.classList.remove('flex');
                    chat_create_bar_group_settings_btn.classList.add('hidden');
                    create_group_btnVisible = false;
                }else{
                    return;
                }
                
            }
        }

        function toggleUserSelection(button) {
            const userId = button.dataset.id;
            if (!selectedUsers.includes(userId)) {
                selectedUsers.push(userId);
            } else {
                selectedUsers = selectedUsers.filter(id => id !== userId);
            }
        }

        function addUserGroup(button){
            const UsersAdded = document.getElementById("UsersAdded");
            button.classList.add("hidden");
            UsersAdded.innerHTML += `<div class="flex items-center gap-2 text-neutral-200">
                                        <div style="background-image: url('${button.dataset.url_imagem}')" class="bg-cover bg-center bg-no-repeat size-7 min-w-7 bg-gray-300 rounded-full"></div>
                                        <span>${button.dataset.username}</span>
                                        <button data-button_add="${button.id}" data-id="${button.dataset.id}" type="button" class="flex items-center justify-center rounded-full hover:bg-white size-5 min-w-5" onclick="removeUserGroup(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x stroke-neutral-400 size-4"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                        </button>
                                    </div>`;

            toggleUserSelection(button);
            showCreateGroupBtn(true);
        }

        function removeUserGroup(button){
            const button_add = document.getElementById(button.dataset.button_add);
            button_add.classList.remove("hidden");
            button.parentElement.remove();
            toggleUserSelection(button);
            showCreateGroupBtn(false);
        }

        async function createGroup() {
            const groupName = document.getElementById("nomeGrupo").value;
            const url_imagem_icon = document.getElementById("url_imagem_icon_grupo").value;

            const response = await fetch('create_chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    is_group: true,
                    groupName,
                    url_imagem_icon,
                    users: selectedUsers
                })
            });

            const result = await response.json();
            if (result.success) {
                alert("Grupo criado com sucesso!");
                window.location.reload();
            } else {
                alert("Erro ao criar grupo: " + result.message);
            }
        }





        


        function formatDate(timestamp) {
            if(timestamp == null){
                return '';
            }

            const date = new Date(timestamp); // Converte o timestamp para um objeto Date
            const now = new Date(); // Data atual

            const isToday = date.toDateString() === now.toDateString(); // Verifica se é hoje
            const isSameYear = date.getFullYear() === now.getFullYear(); // Verifica se é o mesmo ano

            if (isToday) {
                // Formato: horas:minutos (24h)
                return `${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;
            } else if (isSameYear) {
                // Formato: dia/mês
                return `${String(date.getDate()).padStart(2, '0')}/${String(date.getMonth() + 1).padStart(2, '0')}`;
            } else {
                // Formato: dia/mês/ano
                return `${String(date.getDate()).padStart(2, '0')}/${String(date.getMonth() + 1).padStart(2, '0')}/${date.getFullYear()}`;
            }
        }

        let currentChatOrder = []; // Armazena a ordem atual dos chats exibidos

        function updateChats() {
            fetch('getChats.php')
                .then(response => response.json())
                .then(chats => {
                    const chatListContainer = document.getElementById('chatList');

                    // Obtém a nova ordem dos chats
                    const newChatOrder = chats.map(chat => chat.id);

                    // Verifica se a ordem mudou
                    const hasOrderChanged = JSON.stringify(newChatOrder) !== JSON.stringify(currentChatOrder);

                    if (hasOrderChanged) {
                        // Atualiza a lista completamente (pode piscar, mas é necessário)
                        chatListContainer.innerHTML = '';
                        chats.forEach(chat => {
                            const unreadCount = chat.unread_count > 0 
                            ? `<span class="chat_unreadCount_list flex items-center justify-center text-[0.7rem] bg-rose-400 rounded-full size-6 translate-x-2 group-hover:-translate-x-2 transition-all duration-500">${chat.unread_count}</span> `
                            : '';

                            const chatHTML = `<button data-id="${chat.id}" data-is_group="${chat.is_group}" data-nome_chat="${chat.chat_name}" data-url_imagem_icon="${chat.url_imagem_icon || '../images/defaultUser.jpg'}" type="button" class="openChat flex items-center justify-between w-full text-left mb-4 cursor-pointer hover:bg-neutral-700 px-2 py-4 rounded-md group select-none focus:outline-none">
                                        <div class="flex items-center">
                                            <div style="background-image: url('${chat.url_imagem_icon || '../images/defaultUser.jpg'}')" class="bg_chat_list bg-cover bg-center bg-no-repeat w-12 h-12 bg-gray-300 rounded-full mr-3"></div>
                                            <div class="flex-1">
                                                <h2 class="chat_name_list text-white text-lg font-semibold">${chat.chat_name}</h2>
                                                <p class="chat_last_message_list text-zinc-400">${chat.last_message || ''}</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center justify-center mr-6 text-sm text-neutral-50 gap-2">
                                            <span class="chat_last_message_time_list text-zinc-400">${formatDate(chat.last_message_time)}</span>
                                            <div class="chat_info_container_list flex items-center justify-center">
                                                ${unreadCount}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down stroke-zinc-400 translate-x-12 -z-10 group-hover:z-0 group-hover:-translate-x-0 transition-[transform_0.5s]" ><path d="m6 9 6 6 6-6"/></svg>
                                            </div>
                                        </div>
                                    </button>`;
                            chatListContainer.insertAdjacentHTML('beforeend', chatHTML);
                        });

                        // Atualiza a ordem atual
                        currentChatOrder = newChatOrder;

                        // Reassocia os eventos aos chats
                        attachChatOpenEvents();
                    } else {
                        // Apenas atualiza os conteúdos dos chats
                        chats.forEach(chat => {
                            const button = chatListContainer.querySelector(`.openChat[data-id="${chat.id}"]`);
                            if (button) {
                                button.querySelector('h2.chat_name_list').innerText = chat.chat_name;
                                button.querySelector('p.chat_last_message_list').innerText = chat.last_message || '';
                                button.querySelector('span.chat_last_message_time_list').innerText = formatDate(chat.last_message_time);

                                const unreadCountContainer = button.querySelector('.chat_unreadCount_list');
                                
                                
                                if (chat.unread_count > 0) {
                                    if (!unreadCountContainer) {
                                         // Adiciona contagem de mensagens não lidas
                                         const unreadHTML = `<span class="chat_unreadCount_list flex items-center justify-center text-[0.7rem] bg-rose-400 rounded-full size-6 translate-x-2 group-hover:-translate-x-2 transition-all duration-500">${chat.unread_count}</span>`;
                                         button.querySelector('div.chat_info_container_list').insertAdjacentHTML('afterbegin', unreadHTML);
                                     } else {
                                         // Atualiza contagem de mensagens não lidas
                                         unreadCountContainer.innerText = chat.unread_count;
                                     }
                                 } else if (unreadCountContainer) {
                                     // Remove contagem de mensagens não lidas se não houver
                                     unreadCountContainer.remove();
                                 }
                            }
                        });
                    }
                })
                .catch(error => console.error('Erro ao atualizar chats:', error));
        }

        function attachChatOpenEvents(){
            const openChatBtns = document.querySelectorAll('.openChat');

            openChatBtns.forEach(button =>{
                button.addEventListener('click', event =>{
                    const chatTitle = document.getElementById('chatTitle');
                    const chatIconImage = document.getElementById('chatIconImage');
                    const messagesContainer = document.getElementById('messagesContainer');

                    messagesContainer.dataset.id = button.dataset.id;
                    
                    chatTitle.innerHTML = button.dataset.nome_chat;

                    
                    chatIconImage.style.backgroundImage = `url('${button.dataset.url_imagem_icon}')`;
                    

                    abrirChat(button.dataset.id);
                    
                })
            });
        }

        // Atualiza os chats a cada 3 segundos
        setInterval(updateChats, 100);






        let lastMessages = []; // Armazena as mensagens da última atualização

        let intervalId = null;
        // Abre o chat para o ID fornecido
        function abrirChat(idChat) {
            const containerMensagens = document.getElementById('messagesContainer');

            // Carrega mensagens inicialmente
            carregarMensagens(idChat, containerMensagens);


            if (intervalId !== null) {
                clearInterval(intervalId);
                console.log("Intervalo anterior encerrado!");
            }

            // Configura um novo intervalo para o chat atual
            intervalId = setInterval(() => {
                // Sua lógica para atualizar o container de mensagens
                carregarMensagens(idChat, containerMensagens);
            }, 100);
        }

        

        // Faz requisição AJAX para buscar mensagens do backend
        function carregarMensagens(idChat, container) {
            fetch('getMessages.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ id_chat: idChat }),
            })
            .then(response => response.json())
            .then(mensagens => {
                if (JSON.stringify(mensagens) !== JSON.stringify(lastMessages)) {
                    lastMessages = mensagens; // Atualiza as mensagens salvas
                    renderizarMensagens(container, mensagens); // Renderiza as novas mensagens
                }
            });
        }

        

        // Renderiza as mensagens no container fornecido
        function renderizarMensagens(container, mensagens) {
            if (!container) {
                console.error('Container de mensagens não encontrado!');
                return;
            }
            container.innerHTML = ' '; // Limpa o container de mensagens

            const idUsuarioLogado = <?=$_SESSION["id_usuario"]?>; // ID do usuário logado
            
            mensagens.forEach((mensagem, index) => {
                
                const mensagemDiv = document.createElement('div');
                mensagemDiv.innerHTML = '';
                mensagemDiv.classList.add('mensagem', 'flex', 'mb-4', 'gap-2');
                

                // Define se a mensagem pertence ao usuário logado
                const mostrarImagem = index === 0 || mensagens[index - 1].id_sender !== mensagem.id_sender;

                
                if (mensagem.id_sender === idUsuarioLogado) {
                    mensagemDiv.classList.add('mensagem-usuario', 'justify-end'); // Mensagens do usuário logado (direita)

                    // Adiciona o texto da mensagem
                    mensagemDiv.innerHTML += `<div class="flex max-w-96 bg-rose-500 text-white rounded-lg p-3 gap-3 rounded-se-none">
                                            <p">${mensagem.message}</p>
                                          </div>`


                    // Determina se deve mostrar a imagem de perfil
                    if(mostrarImagem){
                        mensagemDiv.innerHTML += `<div style="background-image: url('${mensagem.url_imagem || '../images/defaultUser.jpg'}');" class="bg-cover bg-center bg-no-repeat size-10 rounded-full flex items-center justify-center mr-2"></div>`;
                    }else{
                        mensagemDiv.classList.add('pr-14');
                    }

                    
                }else{
                    mensagemDiv.classList.add('mensagem-outro'); // Mensagens de outros usuários (esquerda)
                    
                    
                    // Determina se deve mostrar a imagem de perfil
                    if(mostrarImagem){
                        mensagemDiv.innerHTML += `<div style="background-image: url('${mensagem.url_imagem || '../images/defaultUser.jpg'}');" class="bg-cover bg-center bg-no-repeat size-10 rounded-full flex items-center justify-center mr-2"></div>`;
                    }else{
                        mensagemDiv.classList.add('pl-14');
                    }

                    // Adiciona o texto da mensagem
                    mensagemDiv.innerHTML += `<div class="flex max-w-96 bg-neutral-200 rounded-lg p-3 gap-3 rounded-se-none">
                                                <p class="text-gray-700">${mensagem.message}</p>
                                            </div>`
                }
                
                
                


                
                
                // Adiciona a mensagem ao container
                container.appendChild(mensagemDiv);
            });

            // Rola automaticamente para a mensagem mais recente
            container.scrollTop = container.scrollHeight;
        }


        document.getElementById("btnEnviarMensagem").addEventListener('click', button =>{
            const messagesContainer = document.getElementById('messagesContainer');
            let idChat = messagesContainer.dataset.id
            enviarMensagem(idChat);
        })
        
        function enviarMensagem(idChat) {
            const inputMensagem = document.querySelector('#messageInput'); // Seleciona o input da mensagem
            const mensagem = inputMensagem.value.trim(); // Obtém o texto da mensagem, removendo espaços extras

            if (!mensagem) {
                alert('Digite uma mensagem antes de enviar!');
                return;
            }

            // Faz a requisição para enviar a mensagem
            fetch('sendMessage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    id_chat: idChat,
                    mensagem: mensagem,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        console.log('Mensagem enviada com sucesso!');
                        inputMensagem.value = ''; // Limpa o input após o envio
                        carregarMensagens(idChat); // Atualiza as mensagens no chat
                    } else {
                        alert('Erro ao enviar mensagem: ' + data.error);
                    }
                })
                .catch((error) => {
                    console.error('Erro ao enviar mensagem:', error);
                });
        }



        document.getElementById("messageForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const message = document.getElementById("messageInput").value;
            fetch("sendMessage.php", {
                method: "POST",
                body: JSON.stringify({
                    id_chat: 111,
                    id_sender: <?= $_SESSION["id_usuario"] ?>,
                    message
                }),
                headers: {
                    "Content-Type": "application/json"
                },
            }).then(() => {
                document.getElementById("messageInput").value = "";
            });
        });
    </script>
</main>

<?php
require "footer.php";

?>