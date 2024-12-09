
<?php
        if(isset($_SESSION["result"])){
            if(isset($_SESSION["result_nulo"]) && $_SESSION["result_nulo"]){
                ?>
                <div class="bg-white border border-slate-300 max-w-[25vw] shadow-lg rounded-md p-4 flex justify-center fixed bottom-10 right-10 z-30 break-all break-words box-border">
                        <div class="flex gap-4">
                            <section class="flex flex-col items-center justify-between gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 stroke-neutral-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                                </svg>

                                <div class="w-2 h-full bg-neutral-400 rounded-lg"> </div>
                            </section>
                            <section class="h-full flex flex-col items-start justify-end gap-2 pb-3">
                                <h1 class="text-base font-semibold text-zinc-800 antialiased"><?=$_SESSION["titulo"]?></h1>
                                <p class="text-sm font-medium text-zinc-400 antialiased"><?=$_SESSION["msg"]?></p>
                            </section>
                            <section class="size-12 flex flex-col items-center justify-start">
                                <svg width="100%" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="cursor-pointer size-6">
                                    <path
                                        d="M4.06585 3.00507C3.77296 2.71218 3.29809 2.71218 3.00519 3.00507C2.7123 3.29796 2.7123 3.77284 3.00519 4.06573L4.06585 3.00507ZM10.0763 11.1368C10.3692 11.4297 10.844 11.4297 11.1369 11.1368C11.4298 10.8439 11.4298 10.369 11.1369 10.0761L10.0763 11.1368ZM3.00519 4.06573L10.0763 11.1368L11.1369 10.0761L4.06585 3.00507L3.00519 4.06573Z"
                                        fill="#989fac" />
                                    <path
                                        d="M11.1369 4.06573C11.4298 3.77284 11.4298 3.29796 11.1369 3.00507C10.844 2.71218 10.3691 2.71218 10.0762 3.00507L11.1369 4.06573ZM3.00517 10.0761C2.71228 10.369 2.71228 10.8439 3.00517 11.1368C3.29806 11.4297 3.77294 11.4297 4.06583 11.1368L3.00517 10.0761ZM10.0762 3.00507L3.00517 10.0761L4.06583 11.1368L11.1369 4.06573L10.0762 3.00507Z"
                                        fill="#989fac" />
                                </svg>
                            </section>
                        </div>
                    </div>
                <?php
                unset($_SESSION["result_nulo"]);
            }elseif($_SESSION["result"]){
                ?>
                    <div class="bg-white border border-slate-300 max-w-[25vw] shadow-lg rounded-md p-4 flex justify-center fixed bottom-10 right-10 z-30 break-all break-words box-border">
                        <div class="flex gap-4">
                            <section class="flex flex-col items-center justify-between gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 stroke-green-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                                </svg>

                                <div class="w-2 h-full bg-green-300 rounded-lg"> </div>
                            </section>
                            <section class="h-full flex flex-col items-start justify-end gap-2 pb-3">
                                <h1 class="text-base font-semibold text-zinc-800 antialiased"><?=$_SESSION["titulo"]?></h1>
                                <p class="text-sm font-medium text-zinc-400 antialiased"><?=$_SESSION["msg"]?></p>
                            </section>
                            <section class="size-12 flex flex-col items-center justify-start">
                                <svg width="100%" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="cursor-pointer size-6">
                                    <path
                                        d="M4.06585 3.00507C3.77296 2.71218 3.29809 2.71218 3.00519 3.00507C2.7123 3.29796 2.7123 3.77284 3.00519 4.06573L4.06585 3.00507ZM10.0763 11.1368C10.3692 11.4297 10.844 11.4297 11.1369 11.1368C11.4298 10.8439 11.4298 10.369 11.1369 10.0761L10.0763 11.1368ZM3.00519 4.06573L10.0763 11.1368L11.1369 10.0761L4.06585 3.00507L3.00519 4.06573Z"
                                        fill="#989fac" />
                                    <path
                                        d="M11.1369 4.06573C11.4298 3.77284 11.4298 3.29796 11.1369 3.00507C10.844 2.71218 10.3691 2.71218 10.0762 3.00507L11.1369 4.06573ZM3.00517 10.0761C2.71228 10.369 2.71228 10.8439 3.00517 11.1368C3.29806 11.4297 3.77294 11.4297 4.06583 11.1368L3.00517 10.0761ZM10.0762 3.00507L3.00517 10.0761L4.06583 11.1368L11.1369 4.06573L10.0762 3.00507Z"
                                        fill="#989fac" />
                                </svg>
                            </section>
                        </div>
                    </div>
                <?php
            }else{
                ?>
                <div class="bg-white border border-slate-300 max-w-[25vw] shadow-lg rounded-md p-4 flex justify-center fixed bottom-10 right-10 z-30 break-all break-words box-border">
                    <div class="flex gap-4">
                        <section class="flex flex-col items-center justify-between gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 stroke-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                            </svg>

                            <div class="w-2 h-full bg-red-500 rounded-lg"> </div>
                        </section>
                        <section class="h-full flex flex-col items-start justify-end gap-2 pb-3">
                            <h1 class="text-base font-semibold text-zinc-800 antialiased"><?=$_SESSION["titulo"]?></h1>
                            <p class="text-sm font-medium text-zinc-400 antialiased"><?=$_SESSION["msg"]?></p>
                        </section>
                        <section class="size-8 flex flex-col items-center justify-start">
                            <svg width="100%" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="cursor-pointer size-6">
                                <path
                                    d="M4.06585 3.00507C3.77296 2.71218 3.29809 2.71218 3.00519 3.00507C2.7123 3.29796 2.7123 3.77284 3.00519 4.06573L4.06585 3.00507ZM10.0763 11.1368C10.3692 11.4297 10.844 11.4297 11.1369 11.1368C11.4298 10.8439 11.4298 10.369 11.1369 10.0761L10.0763 11.1368ZM3.00519 4.06573L10.0763 11.1368L11.1369 10.0761L4.06585 3.00507L3.00519 4.06573Z"
                                    fill="#989fac" />
                                <path
                                    d="M11.1369 4.06573C11.4298 3.77284 11.4298 3.29796 11.1369 3.00507C10.844 2.71218 10.3691 2.71218 10.0762 3.00507L11.1369 4.06573ZM3.00517 10.0761C2.71228 10.369 2.71228 10.8439 3.00517 11.1368C3.29806 11.4297 3.77294 11.4297 4.06583 11.1368L3.00517 10.0761ZM10.0762 3.00507L3.00517 10.0761L4.06583 11.1368L11.1369 4.06573L10.0762 3.00507Z"
                                    fill="#989fac" />
                            </svg>
                        </section>
                    </div>
                </div>
                <?php
            }
            unset($_SESSION["result"]);
            unset($_SESSION["titulo"]);
            unset($_SESSION["msg"]);
        }
    ?> 

    <script src="<?=addCacheBuster($jsFile)?>"></script>
</body>
</html>