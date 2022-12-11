function validateCreditCardNumber(cardNumber) {
    if(parseInt(cardNumber) <= 0 || (!/\b\d{4}(| |-)\d{4}\1\d{4}\1\d{4}\b/.test(cardNumber)) || cardNumber.length > 16) {
        return false;
    }
    var carray = new Array();
    for(var i = 0; i < cardNumber.length; i++) {
        carray[carray.length] = cardNumber.charCodeAt(i) - 48;
    }
    carray.reverse(); 
    var sum = 0;
    for(var i = 0; i < carray.length; i++) {
        var tmp = carray[i];
        if((i % 2) != 0) {
            tmp *= 2;
            if(tmp > 9) {
                tmp -= 9;
            }
        }
        sum += tmp;
    }
    return (sum % 10) == 0;
}
function cardType(cardNumber) {
    var o = {
       visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
       mastercard: /^5[1-5][0-9]{14}$/,
    };
    for(var k in o) {
        if(o[k].test(cardNumber)) {
            return k;
        }
    }
    return null;
}

function update(cardNumber) {
    var img = document.getElementById("img");
    var invalid1 = document.getElementById("invalid1");
    if(validateCreditCardNumber(cardNumber)) {
        img.src = "Pics/" + (cardType(cardNumber) || "1") + ".png";
        invalid1.innerText = "";
    }
    else{
        invalid1.innerText="card invalid";
    }
   
}

function CheckCcDate(){
    var exMonth = document.getElementById("");
    var exYear = document.getElementById("");
    var invalid2 = document.getElementById("");
    if (exMonth.selectedIndex === 0){
        invalid2.innerText="Please select the month";
        return false;
    }if (exYear.selectedIndex === 0){
        invalid2.innerText="Please select the year";
        return false;
    }
}