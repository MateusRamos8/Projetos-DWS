let menuVisible = false;
document.getElementById("menu-btn").addEventListener("click", ()=>{
  let menu = document.getElementById("menu");
  
  if(!menuVisible){
    menu.style.transform = "translateX(0%)";
    //s_fix_scrl.style.display = "block";
    menuVisible = true;
  } else{
    menu.style.transform = "translateX(-150%)";
    //s_fix_scrl.style.display = "none";
    menuVisible = false;
  }
})

