'use strict'

window.onload = function() {
    document.addEventListener("click", function (event) {
        clickHandler(event.target);
    });
    document.addEventListener("change", function (event) {
        changeHandler(event.target);
    });
    document.addEventListener("keyup", function (event) {
        keyupHandler(event.target);
    });
    document.addEventListener("input", function (event) {
        inputHandler(event.target);
    });
    document.getElementById("file-form").reset();
    document.getElementById("script-form").reset();
}

function clickHandler(obj) {
    if (obj.id == "to-csv" || obj.id == "to-xls") {
        if (document.getElementById('subdomen').value == '') {
            alert("Поддомен не выбран!");
            return;
        }
        if (document.getElementById('file-select').files.length == 0) {
            alert("Загрузите файл заполненного шаблона!");
            return;
        }
        if (obj.id == "to-xls") {
            document.getElementById('mode').value = 'xls';
        } else {
            document.getElementById("domen").value = document.getElementById("subdomen").value;
        }
        document.getElementById("file-send").click();
    }
    if (obj.id == "to-script") {
        let ip = document.getElementById('ip-adres').value;
        if (ip == '') {
            alert("Введите IP адрес вашего сервера домена!");
            return;
        }
        let ou = 'OU='+document.getElementById('ou0').value+', DC=nis, DC=edu, DC=kz';
        if (document.getElementById('ou1').value != '') {
            ou = 'OU='+document.getElementById('ou1').value+', '+ou;
        };
        if (document.getElementById('ou2').value != '') {
            ou = 'OU='+document.getElementById('ou2').value+', '+ou;
        };
        if (document.getElementById('ou3').value != '') {
            ou = 'OU='+document.getElementById('ou3').value+', '+ou;
        };
        document.getElementById('pne').value = document.getElementById('pne').checked ? '$True' : '$False';
        document.getElementById('cpl').value = document.getElementById('cpl').checked ? '$True' : '$False';
        document.getElementById('en').value = document.getElementById('en').checked ? '$False' : '$True';
        document.getElementById('ccp').value = document.getElementById('ccp').checked ? '$True' : '$False';
        document.getElementById('ip').value = ip;
        document.getElementById('ou').value = ou;
        document.getElementById("script-send").click();
    }
}

function changeHandler(obj) {
    if (obj.id == 'subdomen') {
        document.getElementById('ou0').value = obj.value.slice(1, obj.value.indexOf('.'));
        document.getElementById('example').textContent = "Пример: OU=7, OU=Students, OU=Users, OU="+obj.value.slice(1, obj.value.indexOf('.'));
    }
    if (obj.id == 'pne') {
        if (obj.checked) document.getElementById('cpl').checked = false;
    }
    if (obj.id == 'ccp') {
        if (obj.checked) document.getElementById('cpl').checked = false;
    }
    if (obj.id == 'cpl') {
        if (obj.checked) document.getElementById('pne').checked = false;
        if (obj.checked) document.getElementById('ccp').checked = false;
    }
    if (obj.id == "file-select") {
        document.getElementById("span-file").innerText = document.getElementById("file-select").files[0].name;
        document.getElementById("label-file").classList.add("has-file");
        document.getElementById("i-file").classList.add("fa-check");
        document.getElementById("i-file").classList.remove("fa-upload");
    }
}

function keyupHandler(obj) {
    if (obj.id == "fio") {
        var fio = document.getElementById("fio").value;
        var params = 'mode=local&fio='+fio;
        ajax(function(data){
            document.getElementById("res").value = data;
        },params);
    }
}

function inputHandler(obj) {
    if (obj.id == 'fio') {
        if (/[^А-Яа-яЁёӘәІіҢңҒғҮүҰұҚқӨөҺһ\s\-]/.test(obj.value)) {
            let Selection = obj.selectionStart-1;
            obj.value=obj.value.replace(/[^А-Яа-яЁёӘәІіҢңҒғҮүҰұҚқӨөҺһ\s\-]/g,'');
            obj.setSelectionRange(Selection, Selection);
        }
    }
    if (obj.id == 'ip-adres') {
        if (/[^0-9\.]/g.test(obj.value)) {
            let Selection = obj.selectionStart-1;
            obj.value=obj.value.replace(/[^0-9\.]/g,'');
            obj.setSelectionRange(Selection, Selection);
        }
    }
}

function ajax(callback, params)
{
    var queryString = 'transliteration.php';
    var f = callback||function(data){};
    var request = new XMLHttpRequest();
    request.onreadystatechange = function()
    {
            if (request.readyState == 4 && request.status == 200)
            {
                f(request.responseText);
            }
    }
    request.open('POST', queryString);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(params);
}