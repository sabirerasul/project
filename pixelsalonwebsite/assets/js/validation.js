function isValidNumber(number) {
    var mob = /^[1-9]{1}[0-9]{9}$/;
    if (mob.test(number) == false) {
        return false;
    }else{

        return true;
    }
}

function isValidName(name){
    if(/^[A-Za-z\s]+$/.test(name)){
        return true
    }else{
        return false;
    }
}

function isValidEmail(email){
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
        return true;
    }else{
        return false;
    }
}

function addError(label, tag, error=''){
    label.css("color", "red");
    tag.css("border-color", "red");
    tag.css("border", "1px solid red");
    tag.focus();
    tag.next('.showErr').html(error);
}

function removeError(label, tag){
    label.css("color", "#6e707e");
    tag.css("border-color", "#d1d3e2");
 
    tag.next('.showErr').html("");
}