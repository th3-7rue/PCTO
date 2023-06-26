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
function selezionaTutto2() {
    var btn2 = document.querySelector('.selAll2');
    var chk2 = document.querySelectorAll(".chk2");
    if (btn2.checked) {
        for (var i = 0; i < chk2.length; i++) {
            chk2[i].checked = true;
        }
    } else {
        for (var i = 0; i < chk2.length; i++) {
            chk2[i].checked = false;
        }
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
function checkAll2() {
    var chk2 = document.querySelectorAll(".chk2");
    var btn2 = document.querySelector(".selAll2");
    var count2 = 0;
    for (var i = 0; i < chk2.length; i++) {
        if (chk2[i].checked) {
            count2++;
        }
    }
    if (count2 == chk2.length) {
        btn2.checked = true;
    }
    else {
        btn2.checked = false;
    }
}
function setWidths() {
    // Get the first element
    const thid = document.getElementById('th-id');
    const thch = document.getElementById('th-ch');
    const thid1 = document.getElementById('th-id1');
    const thch1 = document.getElementById('th-ch1');
    const thmarca1 = document.getElementById('th-marca1');
    const thmodello1 = document.getElementById('th-modello1');

    // Get the computed width of element1



    // Set the width of the second element to be the same as element1
    const tdid = document.getElementById('td-id');
    const tdch = document.getElementById('td-ch');
    const tdid1 = document.getElementById('td-id1');
    const tdch1 = document.getElementById('td-ch1');
    const tdmarca1 = document.getElementById('td-marca1');
    const tdmodello1 = document.getElementById('td-modello1');
    const thidWidth = window.getComputedStyle(tdid).width;
    const thchWidth = window.getComputedStyle(tdch).width;
    const thid1Width = window.getComputedStyle(tdid1).width;
    const thch1Width = window.getComputedStyle(tdch1).width;
    const thmarca1Width = window.getComputedStyle(tdmarca1).width;
    const thmodello1Width = window.getComputedStyle(tdmodello1).width;
    thid.style.width = thidWidth;
    thch.style.width = thchWidth;
    thid1.style.width = thid1Width;
    thch1.style.width = thch1Width;
    thmarca1.style.width = thmarca1Width;
    thmodello1.style.width = thmodello1Width;

}


const ricercaMarche = document.getElementById('cercaMarca');
const ricercaModelli = document.getElementById('cercaModello');
function showMarche() {
    const input = ricercaMarche.value;
    $.ajax({
        type: "POST",
        url: "getMarche.php",
        data: { q: input },
        success: function (risposta) {
            $marche = JSON.parse(risposta);
            let output = '';
            for (let i in $marche) {
                var single_marca = $marche[i];
                var output_temp = '';
                output_temp += '<tr>';
                output_temp += '<td id="td-ch"><input form="delMarcheForm" type="checkbox" class="chk" name="chk[]" value="' + single_marca.id + '"></td>';
                output_temp += '<td id="td-id">' + single_marca.id + '</td>';
                output_temp += '<td id="td-marca">' + single_marca.marca + '</td>';
                output_temp += '</tr>';
                output += output_temp;
            }
            document.getElementById('tableMarche').innerHTML = output;
            getMarcheCombo();
            //setWidths();
        },
        error: function () {
            console.log("Error");
        }
    });

}
function showModelli() {
    const input = encodeURIComponent(ricercaModelli.value);

    $.ajax({
        type: "POST",
        url: "getModelli.php",
        data: { q: input },
        success: function (risposta) {
            $modelli = JSON.parse(risposta);
            //console.log($modelli);
            let output = '';
            for (let i in $modelli) {
                var single_modello = $modelli[i];
                var output_temp = "";
                output_temp += '<tr>';
                output_temp += '<td id="td-ch1"><input form="delModelliForm" type="checkbox" class="chk2" name="chk2[]" value="' + single_modello.id + '"></td>';
                output_temp += '<td id="td-id1">' + single_modello.id + '</td>';
                output_temp += '<td id="td-marca1">' + single_modello.marca + '</td>';
                output_temp += '<td id="td-modello1">' + single_modello.modello + '</td>';
                output_temp += '</tr>';
                output += output_temp;
            }
            document.getElementById('tableModelli').innerHTML = output;
            //setWidths();
        },
        error: function () {
            console.log("Error");
        }
    });
}
function getMarcheCombo() {
    $.ajax({
        type: "POST",
        url: "getMarcheCombo.php",
        success: function (risposta) {
            $marche = JSON.parse(risposta);
            let output = '<option class="placeHolder" selected disabled value="">Seleziona la marca</option>';
            for (let i in $marche) {
                var single_marca = $marche[i];
                var output_temp = '';
                output_temp += '<option value="' + single_marca.id + '">' + single_marca.marca + '</option>';
                output += output_temp;
            }
            document.getElementById('marcheCombo').innerHTML = output;
        },
        error: function () {
            console.log("Error");
        }
    });
}
showMarche();
showModelli();

window.addEventListener('resize', setWidths);
ricercaMarche.addEventListener('keyup', showMarche);
ricercaModelli.addEventListener('keyup', showModelli);
$(document).ready(function () {
    $('#marcaForm').submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "addMarca.php",
            data: formData,
            success: function (response) {

                $('#marcaForm')[0].reset();
                alert(response);
                showMarche();

            },
            error: function () {
                console.log("Error");
            }
        });
    });
});
$(document).ready(function () {
    $('#modelloForm').submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "addModello.php",
            data: formData,
            success: function (response) {
                $('#modelloForm')[0].reset();
                alert(response);
                showModelli();
            },
            error: function () {
                console.log("Error");
            }
        });
    });
});
$(document).ready(function () {
    $('#delMarcheForm').submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        //console.log(formData);
        // chiedi conferma
        if (confirm("Sei sicuro di voler eliminare le marche selezionate?\nATTENZIONE: verranno eliminati anche i modelli associati alle marche selezionate")) {

            $.ajax({
                type: "POST",
                url: "delMarche.php",
                data: formData,
                success: function (response) {
                    // parse json
                    response = JSON.parse(response);
                    //console.log(response);

                    var message = "";

                    if (response.cannot_delete.length > 0) {
                        message += "Impossibile eliminare le seguenti marche in quanto sono presenti veicoli in autonoleggio con tali marche:\n";
                        message += response.cannot_delete.join("\n");
                    }

                    if (response.deleted_models.length > 0) {
                        message += "\nI modelli delle seguenti marche sono stati eliminati:\n";
                        message += response.deleted_models.join("\n");
                    }

                    if (response.deleted_brands.length > 0) {
                        message += "\nMarche eliminate:\n";
                        message += response.deleted_brands.join("\n");
                    }

                    if (message === "") {
                        message = "Nessuna marca eliminata.";
                    }

                    alert(message);

                    $('#delMarcheForm')[0].reset();

                    showMarche();
                    showModelli();
                },
                error: function () {
                    console.log("Error");
                }
            });
        }
    });
});
$(document).ready(function () {
    $('#delModelliForm').submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        //console.log(formData);
        if (confirm("Sei sicuro di voler eliminare i modelli selezionati?")) {

            $.ajax({
                type: "POST",
                url: "delModelli.php",
                data: formData,
                success: function (response) {
                    // parse json
                    response = JSON.parse(response);
                    //console.log(response);

                    var message = "";

                    if (response.deleted_models.length > 0) {
                        message += "Modelli eliminati:\n";
                        message += response.deleted_models.join("\n");
                    }

                    if (message === "") {
                        message = "Nessun modello eliminato.";
                    }

                    alert(message);

                    $('#delModelliForm')[0].reset();

                    showModelli();
                },
                error: function () {
                    console.log("Error");
                }
            });
        }
    });
});
