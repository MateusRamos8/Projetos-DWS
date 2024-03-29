/*aaaaaaaa*/

let menuVisible = false;
let histVisible = false;
let body = document.getElementsByTagName("body")[0];
let menu = document.getElementById("menu");
let hist = document.getElementById("hist");

document.getElementById("menu-btn").addEventListener("click", ()=>{
  if(!menuVisible){
    menu.style.transform = "translateX(0%)";
    menuVisible = true;
  } else{
    menu.style.transform = "translateX(-150%)";
    menuVisible = false;
  }
})
document.getElementById("hist-btn").addEventListener("click", ()=>{
  if(!histVisible){
    hist.style.transform = "translateY(0%)";
    histVisible = true;
  } else{
    hist.style.transform = "translateY(150%)";
    histVisible = false;
  }
})
window.matchMedia("(min-width: 556px)").addEventListener("change",(e) =>{
  if (e.matches) {
    hist.style.transform = "translateY(150%)";
    hist.style.display = "none"
    histVisible = false;
  }
});




