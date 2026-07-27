let nav_barVisible = false;
const body = document.getElementsByTagName("body")[0];
const nav_bar = document.getElementById("nav_bar");
const nav_bar_btn = document.getElementById("nav_bar_btn");
const nav_bar_close_btn = document.getElementById("nav_bar_close_btn");
const overlay = document.getElementById("overlay");

const overlayActive = (condition) =>{
    if(condition){
        overlay.classList.remove('opacity-0', 'invisible', 'pointer-events-none');
    }else{
        overlay.classList.add('opacity-0', 'invisible', 'pointer-events-none');
    }
}

nav_bar_btn.addEventListener("click", ()=>{
  if(!nav_barVisible){
    nav_bar.classList.remove('-translate-x-80');
    //nav_bar.style.transform = "translateX(0%)";
    overlayActive(true);
    //overlay.classList.add('active');
    nav_barVisible = true;
  } else{
    nav_bar.classList.add('-translate-x-80');
    //nav_bar.style.transform = "translateX(-150%)";
    overlayActive(false);
    //overlay.classList.remove('active');
    nav_barVisible = false;
  }
});
overlay.addEventListener("click", ()=>{
  overlayActive(false);
  //overlay.classList.remove('active');
  nav_bar.classList.add('-translate-x-80');
  nav_barVisible = false;
});

nav_bar_close_btn.addEventListener("click", ()=>{
  overlayActive(false);
  //overlay.classList.remove('active');

  if(nav_barVisible){
    nav_bar.classList.add('-translate-x-80');
    nav_barVisible = false;
  }
});



