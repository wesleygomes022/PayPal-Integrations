/*let array = ['a', 2, 3, 'b', 'c', 5, 8, 'd', 'g', 6, 7];
let acc = 0;
for(i = 0; i < array.length; i++){
    if(typeof(array[i]) == "number"){
        acc += array[i];
    }
}

console.log('acc', acc);*/

let isUservalid = (bool) => {return bool};

let auto = "Sua conta é " + (isUservalid(false) ? "1234" : "Não disponível!" );
console.log(auto);