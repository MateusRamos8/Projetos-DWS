let menuVisible = false;
let histVisible = false;
const body = document.getElementsByTagName("body")[0];
const menu = document.getElementById("menu");
const menu_btn = document.getElementById("menu-btn");
const hist = document.getElementById("hist");
const hist_btn = document.getElementById("hist-btn");
const overlay = document.getElementById("overlay");



menu_btn.addEventListener("click", ()=>{
  if(!menuVisible){
    menu.style.transform = "translateX(0%)";
    overlay.classList.add('active');
    hist_btn.style.zIndex = "0";
    menuVisible = true;
  } else{
    menu.style.transform = "translateX(-150%)";
    overlay.classList.remove('active');
    hist_btn.style.zIndex = "5";
    menuVisible = false;
  }
})
hist_btn.addEventListener("click", ()=>{
  if(!histVisible){
    hist.style.transform = "translateY(0%)";
    overlay.classList.add('active');
    menu_btn.style.zIndex = "0";
    histVisible = true;
  } else{
    hist.style.transform = "translateY(150%)";
    overlay.classList.remove('active');
    menu_btn.style.zIndex = "5";
    histVisible = false;
  }
})

overlay.addEventListener("click", ()=>{
  overlay.classList.remove('active');
  hist.style.transform = "translateY(150%)";
  histVisible = false;
  menu.style.transform = "translateX(-150%)";
  menuVisible = false;
})

window.matchMedia("(min-width: 556px)").addEventListener("change",(e) =>{
  if (e.matches) {
    hist.style.transform = "translateY(150%)";
    hist.style.display = "none"
    histVisible = false;
  }
});



const resElem = document.getElementById("result");
const conElem = document.getElementById("conta");

let numeros = [];
let operacoes = [];
let op_svg = [];
let res = null;
let con = "";
let i = 0;

let op_click = false;
let op_action = false;
let equal_click = false;

document.querySelectorAll('.digit').forEach((button) => {
  button.addEventListener("click", () => {
    

    if((resElem.innerText == "0" && button.value != ".") || op_click){
      resElem.innerText = button.value;
    }else{
      resElem.innerText += button.value;
    }

    if(numeros[i] == undefined){
      numeros[i] = button.value;
    }else{
      numeros[i] += button.value;
    }

    
    equal_click = false;
    op_click = false;
  });
});

document.querySelectorAll('.op').forEach((button) => {
  button.addEventListener("click", () => {
    
    if(!op_click){

      operacoes[i] = button.value;
      if(button.innerHTML.indexOf("svg") != -1){
        op_svg[i] = button.innerHTML.replace("width=\"24\" height=\"24\"", "width=\"14\" height=\"12\"");
      }else{
        op_svg[i] = button.innerHTML;
      }
      
      
      if(i==0){
        conElem.innerHTML = numeros[i] + op_svg[i];
      }else{
        
        if(res == null){
          res = eval(numeros[i-1] + operacoes[i-1] + numeros[i]);
        }else{
          if(equal_click){
            conElem.innerHTML = res + op_svg[i];
          }else{
            res = eval(res + operacoes[i-1] + numeros[i]);
          }
          
        }
        conElem.innerHTML = res + op_svg[i];
        resElem.innerText = res;
      }
      
      

      
      
      i++;
      op_click = true;
    }
    
  });
});

document.getElementById("equal").addEventListener("click", ()=>{
  
  if(!op_click){
    let btn = document.getElementById("equal").innerHTML.replace("width=\"24\" height=\"24\"", "width=\"14\" height=\"12\"");

    if(i==0){
        conElem.innerHTML = numeros[i] + btn;
    }else{
      if(res == null){
        conElem.innerHTML = numeros[i-1] + op_svg[i-1] + numeros[i] + btn;
        res = eval(numeros[i-1] + operacoes[i-1] + numeros[i]);
      }else{
        conElem.innerHTML = res + op_svg[i-1] + numeros[i] + btn;
        res = eval(res + operacoes[i-1] + numeros[i]);
      }
    }
    
    resElem.innerText = res;
    equal_click = true;
  }
});

document.getElementById('cancelEntry').addEventListener("click", ()=>{
  resElem.innerText = 0;
  numeros[i] = 0;
});

document.getElementById('clean').addEventListener("click", ()=>{
  resElem.innerText = 0;
  conElem.innerHTML = "";
  res = null;
  numeros = [];
  operacoes = [];
  i = 0;
  op_click = false;
  op_action = false;
  equal_click = false;
});






