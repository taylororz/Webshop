function validPassword(){

    var password1 = document.getElementById('password1');

    var upper= document.getElementById('upper');
    var lower= document.getElementById('lower');
    var number= document.getElementById('number');
    var length= document.getElementById('length');

    if(password1.value.match(/[0-9]/)){
        number.style.color='green';
    }else{
        number.style.color='red';
    }

    if(password1.value.match(/[A-Z]/)){
        upper.style.color='green';
    }else{
        upper.style.color='red';
    }

    if(password1.value.match(/[a-z]/)){
        lower.style.color='green';
    }else{
        lower.style.color='red';
    }

    if(password1.value.length < 9){
        length.style.color='red';
    }else{
        length.style.color='green';
    }
}



