const ricerca = document.getElementById("ricerca");
const tableAutonoleggio = document.getElementById("autonoleggio");
function selezionaTutto() {
    var btn = document.querySelector('.selAll');
    var chk = document.querySelectorAll(".chk");
    if (btn.checked) {
        for (var i = 0; i < chk.length; i++) {
            chk[i].checked = true;
        }
    } else {
        for (var i = 0; i < chk.length; i++) {
            chk[i].checked = false;
        }
    }

}
function askConfirm() {
    if (!confirm("Sei sicuro di voler eliminare i record selezionati?")) {
        event.preventDefault();
    }
}

/* check selectAll if all checkbox are checked */
function checkAll() {
    var chk = document.querySelectorAll(".chk");
    var btn = document.querySelector(".selAll");
    var count = 0;
    for (var i = 0; i < chk.length; i++) {
        if (chk[i].checked) {
            count++;
        }
    }
    if (count == chk.length) {
        btn.checked = true;
    } else {
        btn.checked = false;
    }
}
showAutonoleggio();
function setWidths() {
    // Get the first element
    const th1 = document.getElementById('th1');
    const th2 = document.getElementById('th2');
    const th3 = document.getElementById('th3');
    const th4 = document.getElementById('th4');
    const th5 = document.getElementById('th5');


    // Get the computed width of element1



    // Set the width of the second element to be the same as element1
    const td1 = document.getElementById('td1');
    const td2 = document.getElementById('td2');
    const td3 = document.getElementById('td3');
    const td4 = document.getElementById('td4');
    const td5 = document.getElementById('td5');

    const th1Width = window.getComputedStyle(td1).width;
    const th2Width = window.getComputedStyle(td2).width;
    const th3Width = window.getComputedStyle(td3).width;
    const th4Width = window.getComputedStyle(td4).width;
    const th5Width = window.getComputedStyle(td5).width;

    th1.style.width = th1Width;
    th2.style.width = th2Width;
    th3.style.width = th3Width;
    th4.style.width = th4Width;
    th5.style.width = th5Width;

}

window.addEventListener('resize', setWidths);
ricerca.addEventListener("keyup", showAutonoleggio);
function showAutonoleggio() {
    const str = ricerca.value;
    $.ajax({
        type: 'POST',
        url: 'getVeicoli.php',
        data: { ricerca: str },
        success: function (response) {

            $json = JSON.parse(response);
            var text = "";
            for ($i = 0; $i < $json.length; $i++) {
                var single_json = $json[$i];
                var text_temp = "";
                text_temp += "<tr>";
                text_temp += "<td id='td1' class='center'><input onchange='checkAll()' class='chk' name='elimina[]' form='eliminabtn' type='checkbox' value='" + single_json.id + "'></td>";
                text_temp += "<td id='td2'>" + single_json.targa + "</td>";
                text_temp += "<td id='td3'>" + single_json.marca + "</td>";
                text_temp += "<td id='td4'>" + single_json.modello + "</td>";
                text_temp += "<td id='td5'>" + single_json.posti + "</td>";
                text_temp += "<td>" + single_json.anno + "</td>";
                text_temp += "</tr>";
                text += text_temp;
            }

            tableAutonoleggio.innerHTML = text;
            setWidths();
        },
        error: function () {
            console.log("error");
        }
    });

}
$("#selectMarca").change(function () {
    // cambia colore del testo
    $("#selectMarca").css("color", "#fff");
    getModelliCombo();
});
$("#selectModel").change(function () {
    // cambia colore del testo
    $("#selectModel").css("color", "#fff");
});

getMarcheCombo();
function getMarcheCombo() {
    $.ajax({
        type: "POST",
        url: "getMarche.php",
        success: function (risposta) {
            $marche = JSON.parse(risposta);
            let output = '<option class="placeHolder" selected disabled value="">Seleziona la marca</option>';
            for (let i in $marche) {
                var single_marca = $marche[i];
                var output_temp = '';
                output_temp += '<option value="' + single_marca.id + '">' + single_marca.marca + '</option>';
                output += output_temp;
            }
            document.getElementById('selectMarca').innerHTML = output;
        },
        error: function () {
            console.log("Error");
        }
    });
}
function getModelliCombo() {
    var marca = document.getElementById('selectMarca').value;
    $.ajax({
        type: "POST",
        url: "getModelli.php",
        data: { marca: marca },
        success: function (risposta) {
            $modelli = JSON.parse(risposta);
            let output = '<option class="placeHolder" selected disabled value="">Seleziona il modello</option>';
            for (let i in $modelli) {
                var single_modello = $modelli[i];
                var output_temp = '';
                output_temp += '<option value="' + single_modello.id + '">' + single_modello.modello + '</option>';
                output += output_temp;
            }
            document.getElementById('selectModel').innerHTML = output;
        },
        error: function () {
            console.log("Error");
        }
    });
}
$("#aggiungi").submit(function (event) {
    event.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "addVeicolo.php",
        data: formData,
        success: function (response) {
            if (response == "ok") {
                alert("Veicolo aggiunto correttamente");
                location.reload();
            } else {
                alert("Errore nell'aggiunta del veicolo");
            }
        },
        error: function () {
            console.log("Error");
        }
    });
});