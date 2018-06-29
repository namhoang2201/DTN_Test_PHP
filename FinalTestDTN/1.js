/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validateForm() {
    var ho = document.forms['form1']['bill_id'].value;
    if (ho == "") {
        alert("Bill ID must not empty !");
        return false;
    }

    var name = document.forms['form1']['bill_name'].value;
    if (name == "") {
        alert("Bill Name must not empty !");
        return false;
    }
    var amount = document.forms['form1']['amount'].value;
    if (amount == "") {
        alert("Amount must not empty !");
        return false;
    } else {
        if (isNaN(amount)) {
            alert("Amount must be a number !");
            return false;
        }
    }
    var category = document.getElementById("category").value;
    if (category == "") {
        alert("Please select a category !");
        return false;
    }
    return true;
}

function reset() {
    document.getElementById("form1").reset();
}


