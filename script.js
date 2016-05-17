/*
Írd ki a szöveges beviteli mező mellett, hogy hány karakterből áll az üzenet.
Ha az üzenet hossza elérte a 160 karaktert, akkor a beviteli mező keretét 10px-re vastagítsd meg. 
Egyébként 1px vastag legyen.
A beviteli mező alatt előnézetként jelenítsd meg a beírt szöveget.
*/

function $(selector) {
    return document.querySelector(selector);
}

function $$(selector) {
    return document.querySelectorAll(selector);
}

$('#tweet').addEventListener("keyup", onKeyUp, true);

function onKeyUp(){
    var message = $('#tweet').value;
    var messageLength = message.length;
    if(messageLength >= 160){
        $('#tweet').style.border = '10px solid';
    } else {
        $('#tweet').style.border = '1px solid';
    }
    if(message.indexOf('ELTE') > -1 || message.indexOf('elte') > -1){
        $('#tweet').style.borderColor = 'green';
    } else {
        $('#tweet').style.borderColor = 'black';
    }
    $('#messageLength').innerHTML = 'Üzenet hossza: ' + messageLength;
    generatePreview(message);
}

function generatePreview(string){
    var formatted = string.replace(/(^|\s)(#[a-z\d-]+)/ig, '$1<a href="https://twitter.com/$2">$2</a>');
    formatted = formatted.replace('https://twitter.com/#', 'https://twitter.com/');
    formatted = formatted.replace(/(^|\s)(@[a-z\d-]+)/ig, '$1<a href="https://twitter.com/$2">$2</a>');
    formatted = formatted.replace('https://twitter.com/@', 'https://twitter.com/');
    //formatted = magic(formatted);
    console.log(formatted);
    //$('#messagePreview').appendChild(document.createTextNode(formatted));
    $('#messagePreview').innerHTML = formatted;
}

function magic(input) {
    input = input.replace(/&/g, '&amp;');
    input = input.replace(/</g, '&lt;');
    input = input.replace(/>/g, '&gt;');
    return input;
}

$('#messageLength').innerHTML = 'Üzenet hossza: ' + $('#tweet').value.length;