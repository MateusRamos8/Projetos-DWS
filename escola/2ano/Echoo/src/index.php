<?php
    session_start();
    require 'logica_autenticacao.php';
    require 'header.php';
    if(autenticado()){
        $urlGetStarted = "posts.php";
    }else{
        $urlGetStarted = "form_login.php";
    }
?>

<main class="flex flex-col justify-center">
    <div>
        <div class="w-screen h-[80vh] overflow-hidden relative before:block before:absolute before:bg-black before:h-full before:w-full before:top-0 before:left-0 before:z-10 before:opacity-30 ">
        <img src="../images/fundoHome.png" class="absolute -top-36 left-[42%] min-h-full" alt="">
        <div class="relative z-20 max-w-screen-lg mx-auto grid grid-cols-12 h-full items-center">
            <div class="col-span-6">
            <span class="uppercase text-white text-xs font-bold mb-2 block">Sistema WEB</span>
            <h1 class="text-white font-extrabold text-5xl mb-8">Echoo</h1>
            <p class="text-stone-100 text-base">
                Aqui você poderá realizar e visualizar postagens, além de conversar com outros usuários!.
            </p>
            <a href="<?=$urlGetStarted?>" class="inline-block mt-8 text-white uppercase py-4 text-base font-light px-10 border border-white hover:bg-white hover:bg-opacity-10">Comece Agora</a>
            </div>
        </div>
        </div>
        <div class="bg-rose-500 py-20">
        <div class="max-w-screen-lg mx-auto flex justify-between items-center">
            <div class="max-w-xl">
            <h2 class="font-black text-neutral-900 text-3xl mb-4">Ainda é só o começo!</h2>
            <p class="text-base text-neutral-900 font-bold">Essa aplicação foi criada recentemente, e ainda precisa de muitas atualizações! Mas já temos várias funcionalidades disponíveis, aproveite!</p>
            </div>
            <a href="<?=$urlGetStarted?>" class="inline-block text-neutral-900 uppercase py-3 text-base px-10 border border-neutral-900 hover:bg-neutral-900 hover:bg-opacity-10">Comece Agora</a>
        </div>
        </div>
        <div class="py-12 relative overflow-hidden bg-white">
        <div class="grid grid-cols-2 max-w-screen-lg mx-auto">
            <div class="w-full flex flex-col items-end pr-16">
            <h2 class="text-[#64618C] font-bold text-4xl max-w-xs text-right mt-10 mr-28">Crie seus Posts</h2>
            <div class="h-full overflow-hidden relative -mt-10">
                <img src="https://cdn-icons-png.flaticon.com/512/3391/3391272.png" class="h-full w-full object-contain" alt="">
            </div>
            </div>
            <div class="py-20 bg-slate-100 relative before:absolute before:h-full before:w-screen before:bg-neutral-900 before:top-0 before:left-0">
            <div class="relative z-20 pl-12">
                <h2 class="text-rose-500 font-black text-5xl leading-snug mb-10">Publicações</h2>
                <p class="text-white text-sm">
                No Echoo você pode realizar inúmeras publicações, que também poderão ser vitas por qualquer outro usuário. Na página de postanges, é disponibilizado um editor de texto rico para você customizar seu post da forma que desejar.
                </p>
            </div>
            </div>
        </div>
        </div>
        <div class="py-4 relative overflow-hidden bg-white">
        <div class="grid grid-cols-2 max-w-screen-lg mx-auto">
        
            <div class="py-20 bg-slate-100 relative before:absolute before:h-full before:w-screen before:bg-rose-500 before:top-0 before:right-0">
            <div class="relative z-20 pl-12">
                <h2 class="text-neutral-900 font-black text-5xl leading-snug mb-10">Chats</h2>
                <p class="text-neutral-900 font-bold text-sm">
                O Echoo também conta com um sistema de chats, que possibilita que usuários iniciem conversas com aqueles que eles seguem. Além de chats privados, também existem grupos, que podem possuir vários participantes.
                </p>
                
            </div>
            </div>
            <div class="w-full flex flex-col pl-16">
            <h2 class="text-[#64618C] font-bold text-4xl max-w-xs text-left mt-10 ml-14">Converse com outros Usuários</h2>
            <div class="h-full  overflow-hidden relative">
                <img src="https://cdn.icon-icons.com/icons2/1744/PNG/512/3643728-balloon-chat-conversation-speak-word_113413.png" class="h-full w-full object-contain" alt="">
            </div>
            </div>
        </div>
        </div>
        <div class="py-12 relative overflow-hidden bg-white">
        <div class="grid grid-cols-2 max-w-screen-lg mx-auto">
            <div class="w-full flex flex-col items-end pr-16">
            <h2 class="text-[#64618C] font-bold text-3xl max-w-[40rem] text-right mt-10 mb-8 mr-16">Customize Seu Perfil</h2>
            <div class="h-full mt-auto overflow-hidden relative">
                <img src="https://cdn-icons-png.freepik.com/512/6799/6799221.png" class="h-full w-full object-contain" alt="">
            </div>
            </div>
            <div class="py-20 bg-slate-100 relative before:absolute before:h-full before:w-screen before:bg-neutral-900 before:top-0 before:left-0">
            <div class="relative z-20 pl-12">
                <h2 class="text-rose-500 font-black text-5xl leading-snug mb-10">Perfil do Usuário</h2>
                <p class="text-white text-sm">
                Nesta aplicação você também pode visualizar e customizar seu perfil, adicionando configurançoes de privacidade e segurança, além de outro dados de exibição. Além disso, você pode visualizar o perfil de outros usuários, bem como as publicações que eles fizeram.
                </p>
            </div>
            </div>
        </div>
        </div>
    </div>
   
</main>

<?php
    require 'footer.php';

?>