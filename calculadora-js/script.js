let res = document.getElementById('res');
let conta = document.getElementById('conta');
function addnum(input){
    let num_add = Number(input.value);
    
    res.innerHTML += num_add;
    conta.innerHTML += num_add
}
function addop(input){
    let op = input.value;

    res.innerHTML = op;
    conta.innerHTML += ` ${op} `;
}
function adddec(input){
    res.innerHTML += '.'
    conta.innerHTML += '.'
}
function clean(){
    res.innerHTML = null
    conta.innerHTML = null
}
function calc_res(){
    res.innerHTML = eval(conta.innerText);
    conta.innerHTML += ' ='

}