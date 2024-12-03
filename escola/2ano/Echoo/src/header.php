<?php
function addCacheBuster($file) {
    $randomNumber = rand(1000, 9999); // Gera um número aleatório
    return $file . '?v=' . $randomNumber;
}



// Exemplo de uso:
$cssFile = addCacheBuster('./output.css');
$jsFile = addCacheBuster('script.js');
?>

<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <link rel="shortcut icon" href="../images/logo-dark-recorte5.png" type="image/x-icon">
    
    <link href="<?=addCacheBuster($cssFile)?>" rel="stylesheet"> 

    <!-- Parte da CDN -->
    <!-- <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
        extend: {
        backgroundImage:{
            logoDark:"url('../images/logo-dark-recorte4.png')" ,
            logoLight:"url('../images/logo-light-recorte4.png')",
        },
        typography: {
            modal:{
            css:{
                h1: { fontSize: '2.5rem', fontWeight: 'bold', margin: '1rem 0' },
                h2: { fontSize: '2.25rem', fontWeight: 'bold', margin: '1rem 0' },
                h3: { fontSize: '2rem', fontWeight: 'bold', margin: '1rem 0' },
                h4: { fontSize: '1.75rem', fontWeight: 'bold', margin: '1rem 0' },
                h5: { fontSize: '1.5rem', fontWeight: 'bold', margin: '1rem 0' },
                h6: { fontSize: '1.25rem', fontWeight: 'bold', margin: '1rem 0' },
            }
            }
        }
        },
    },
    plugins: [
    require('@tailwindcss/typography'),
     ],
    }
    
  </script> -->
  <!---->

    <title>Echoo</title>
    <?php
        if(isset($_SESSION["url_imagem"])){
            $url_img = $_SESSION["url_imagem"];
            $bg_user = "url('$url_img')";
            ?>
            <style>
                .bg_user{
                    background-image: <?=$bg_user?>;
                }
            </style>
            <?php
            
        }
    ?>
</head>
<body class="p-0 bg-neutral-900 overflow-x-hidden [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-neutral-800 [&::-webkit-scrollbar-thumb]:bg-rose-900 [&::-webkit-scrollbar-track]:rounded-full [&::-webkit-scrollbar-thumb]:rounded-full">
    <div id="overlay" class="bg-[rgba(0,0,0,0.6)] invisible absolute inset-0 w-screen h-screen z-10 opacity-0 transition-all duration-500 ease-in-out pointer-events-none"></div>
    <header class="w-screen h-20 bg-zinc-950 flex justify-between items-center py-4 px-6 border-b-2 border-solid border-b-rose-900 select-none">
        <div class="flex items-center gap-2">
            <button class="p-1 border-2 border-zinc-700 rounded-lg" id="nav_bar_btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="stroke-zinc-300 size-7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>
            <div class="flex items-center gap-1">
                <div class="bg-logoDark bg-cover bg-no-repeat bg-center w-16 h-16"></div>
                <span class="text-white cursor-default">Echoo</span>
            </div>
        </div>
        <div class="flex gap-2">
        <?php
            if(autenticado()){
                ?>
                    <a href="visualizar_perfil.php?id=<?=$_SESSION["id_usuario"]?>" class="flex items-center gap-1 no-underline text-neutral-300 px-4 py-2 rounded-md drop-shadow-2xl cursor-pointer border-2 border-zinc-950 hover:border-rose-900 hover:bg-zinc-800 transition-all duration-200 ease-in box-border">
                    <div class="bg_user bg-cover bg-no-repeat bg-center w-10 h-10 rounded-full"></div>
                        <span><?=$_SESSION["username"]?></span>
                    </a>
                    <a href="sair.php" class="flex items-center gap-1 no-underline text-neutral-300 px-4 py-2 rounded-md drop-shadow-2xl cursor-pointer border-2 border-zinc-950 hover:border-rose-900 hover:bg-zinc-800 transition-all duration-200 ease-in box-border">
                        <span>Sair</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                        </svg>
                    </a>   
                <?php
            }else{
                ?>
                    <a href="form_login.php" class="flex items-center gap-1 no-underline text-neutral-300 px-4 py-2 rounded-md drop-shadow-2xl cursor-pointer border-2 border-zinc-950 hover:border-rose-900 hover:bg-zinc-800 transition-all duration-200 ease-in box-border">
                        <span>Login</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                        </svg>
                    </a>   
                <?php
            }
        
        ?>
        </div>
    </header>
    <nav class="flex flex-col gap-1 p-2 rounded-r-lg h-screen w-80 bg-zinc-900 z-20 absolute inset-0 -translate-x-80 transition-all duration-500 ease-in-out border-r-2 border-r-zinc-700 " id="nav_bar">
        <div class="flex justify-between mb-2 p-2">
            <div class="bg-logoDark bg-cover bg-no-repeat bg-center w-16 h-16"></div>
            <div class="flex items-center justify-center size-16">
                <button class="flex justify-center items-center p-1  rounded-lg " id="nav_bar_close_btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="stroke-zinc-300 size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="px-2">
            <a href="index.php" class="flex items-center gap-2 cursor-pointer no-underline text-neutral-300 rounded-md hover:bg-zinc-700 px-3 py-2 transition-all duration-200 ease-in">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="stroke-zinc-500 size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span>Home</span>
            </a>
            <a href="posts.php" class="flex items-center gap-2 cursor-pointer no-underline text-neutral-300 rounded-md hover:bg-zinc-700 px-3 py-2 transition-all duration-200 ease-in">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-zinc-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                </svg>
                <span>Posts</span>
            </a>
            <?php 
                if(administrador()){
            ?>
            <a href="gerenciar_usuarios.php" class="flex items-center gap-2 cursor-pointer no-underline text-neutral-300 rounded-md hover:bg-zinc-700 px-3 py-2 transition-all duration-200 ease-in">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-zinc-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                <span>Gerenciar Usuários</span>
            </a>
            <a href="gerenciar_posts.php" class="flex items-center gap-2 cursor-pointer no-underline text-neutral-300 rounded-md hover:bg-zinc-700 px-3 py-2 transition-all duration-200 ease-in">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folders size-6 stroke-zinc-500"><path d="M20 17a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3.9a2 2 0 0 1-1.69-.9l-.81-1.2a2 2 0 0 0-1.67-.9H8a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2Z"/><path d="M2 8v11a2 2 0 0 0 2 2h14"/></svg>
                <span>Gerenciar Posts</span>
            </a>
            <?php
                }
            ?>

            <a href="pesquisar_usuarios.php" class="flex items-center gap-2 cursor-pointer no-underline text-neutral-300 rounded-md hover:bg-zinc-700 px-3 py-2 transition-all duration-200 ease-in">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-zinc-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <span>Pesquisar Usuários</span>
            </a>
            <a href="" class="flex items-center gap-2 cursor-pointer no-underline text-neutral-300 rounded-md hover:bg-zinc-700 px-3 py-2 transition-all duration-200 ease-in">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-zinc-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                </svg>
                <span>Chats</span>
            </a>
            <a href="" class="flex items-center gap-2 cursor-pointer no-underline text-neutral-300 rounded-md hover:bg-zinc-700 px-3 py-2 transition-all duration-200 ease-in">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-zinc-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Criar</span>
            </a>
            
        </div>
    </nav>