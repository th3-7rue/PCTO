<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "app.php";
include "conn.php";

?>

<body>
    <div class='container'>
        <h1>Autonoleggio</h1>
    </div>
    <div class='container'>
        <h2>Inventario</h2>
        <input id='ricerca' type='text' id='ricerca' placeholder='Cerca' class='input'>
        <table>
            <tr>
                <th id='th1' class='center'><input type='checkbox' class='selAll' onclick='selezionaTutto()'></th>
                <th id='th2'>Targa</th>
                <th id='th3'>Marca</th>
                <th id='th4'>Modello</th>
                <th id='th5'>Posti</th>
                <th>Anno</th>
            </tr>
        </table>
        <div class='tbody'>
            <table id='autonoleggio'>
            </table>
        </div>
        <form onsubmit='askConfirm()' action='autonoleggio.php' method='post' id='eliminabtn'>
            <input type='submit' value='Elimina' class='btn'>
        </form>
    </div>
    <div class="container">
        <h2>Aggiungi Veicolo</h2>
        <form id="aggiungi">
            <input type="hidden" id="scelta" value="1">
            <label for="targa">Targa:</label>
            <input maxlength="7" placeholder="Digita la targa" type="text" id="targa" name="targa" required id="targa"><br>
            <label for="selectMarca">Marca:</label>
            <select name="marca" id="selectMarca" form="aggiungi" required>
            </select>
            <label for="selectModel">Modello:</label>
            <select name="modello" id="selectModel" form="aggiungi" required>
                <option class="placeHolder" disabled selected value>Seleziona prima la marca</option>
            </select>
            <label for="nPosti">Numero posti:</label>
            <input name="nPosti" placeholder="Digita il numero di posti" min="1" max="999" type="number" id="nPosti" required id="nPosti"><br>
            <input type="submit" value="Aggiungi Veicolo" class="btn">
        </form>
    </div>
    <script src="scripts.js"></script>

</body>