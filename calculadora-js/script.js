let res = document.getElementById('res');
let conta = document.getElementById('conta');

/*
Números devem ser adicionados no res e na conta sempre que clicados.
Ao clicar um número:
    -Deve se verificar se ja existe um operador no res, para que ele suma
    -Deve se verificar se a um sinal de = na conta, indicando que ela ja foi concluida
     sendo necessario assim reiniciar a conta e o resultado.

Ao clicar numa operação normal:
    -Deve se apagar o número do res, indicando que operação será feita.
    -Deve se verificar se no res ja existe uma operação normal solicitando um número, para que assim
     não tenha mais de uma operação junta.
    -Deve se verificar se ja existe um sinal de igual na conta, se sim colocar o valor de res na conta
     e a operação clicada no res.

Ao clicar no igual:
    -Deve ser resolvida a expressão na conta.
    -Deve ser colocado o operador = no final da conta.
    -Deve ser colocado o resultado da expressão no res.

Ao clicar no CE:
    -Deve ser limpado os campos res e conta.
    -O valor de res deve ser 0.

Ao clicar o DELETE:
    -Caso haja um número, será apagado.
    -Caso haja uma operação, ela será apagada.
    -As operações ou números devem ser atualizadas de acordo com os apagamentos.
    -Caso tudo seja apagado, deverá aparecer 0.
*/

function addnum(button){
    let num_add = button.value;
    let rih = res.innerHTML;
    let cih = conta.innerHTML;
    
    if (rih.includes("+") || rih.includes("-") || rih.includes("*") || rih.includes("/") || rih.includes("%") || rih.includes("=") ){
        res.innerHTML = num_add;
    }else{
        if(rih == 0){
            res.innerHTML = num_add;
        }else{
            res.innerHTML += num_add;
        }
    }
    if (cih.includes("=")){
        conta.innerHTML = num_add;
        res.innerHTML = num_add;
    }else{
        conta.innerHTML += num_add;
    }
}
function addop(button){
    let op = button.value;
    let rih = res.innerHTML;
    let cih = conta.innerHTML;

    if (cih.includes("=")){
        conta.innerHTML = `${res.innerHTML} <strong>${op}</strong> `;
        res.innerHTML = op;
    }else if (!(rih.includes("+") || rih.includes("-") || rih.includes("*") || rih.includes("/") || rih.includes("%"))){
        res.innerHTML = op;
        conta.innerHTML += ` <strong>${op}</strong> `;
    }
    
}
    
function clean(){
    res.innerHTML = 0
    conta.innerHTML = null
}
function calc_res(){
    res.innerHTML = eval(conta.innerText);
    if(conta.innerHTML.endsWith(".")){
        conta.innerHTML += 0
    }
    conta.innerHTML += ' <strong>=</strong> '
}
function del(){
    let rih = res.innerHTML;
    let cih = conta.innerHTML;

    /*
    let lastop, lastop_num;

    lastop_num = conta.innerText.lastIndexOf("+");
    lastop = "+";

    if(conta.innerText.lastIndexOf("-") > lastop_num){
        lastop_num = conta.innerText.lastIndexOf('-');
        lastop = "-"
    }
    if(conta.innerText.lastIndexOf("*") > lastop_num){
        lastop_num = conta.innerText.lastIndexOf('*');
        lastop = "*"
    }
    if(conta.innerText.lastIndexOf("/") > lastop_num){
        lastop_num = conta.innerText.lastIndexOf('/');
        lastop = "/"
    }
    if(conta.innerText.lastIndexOf("%") > lastop_num){
        lastop_num = conta.innerText.lastIndexOf('%');
        lastop = "%"
    }
    */
    

    if(rih.includes("+") || rih.includes("-") || rih.includes("*") || rih.includes("/") || rih.includes("%") || rih.includes("=")){
        res.innerHTML = res.innerHTML.slice(0, -1);
        conta.innerHTML = conta.innerText.slice(0, -2);

        
    }else{
        res.innerHTML = res.innerHTML.slice(0, -1);
        conta.innerHTML = conta.innerHTML.slice(0, -1);
    }
    
}