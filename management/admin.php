<?php
include "conn.php";
include "app.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
}
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
}
?>

<body>
    <div class="container">
        <h1>Admin</h1>
    </div>
    <div class="container">
        <h2>Aggiungi marca</h2>
        <form id="marcaForm">
            <input required type="text" name="marca" placeholder="Marca">
            <input type="submit" value="Aggiungi" class="btn">
        </form>
    </div>
    <div class="container">
        <h2>Aggiungi modello</h2>
        <form id="modelloForm">
            <select id="marcheCombo" name="marca" required>

            </select>
            <input required type="text" name="modello" id="modello" placeholder="Modello">
            <input type="submit" value="Aggiungi" class="btn">
        </form>

    </div>
    <div class="container">
        <h2>Rimuovi marca</h2>
        <input id="cercaMarca" type='text' name='ricerca' placeholder='Cerca' class='input'>
        <table>
            <tr>
                <th id="th-ch"><input onchange='selezionaTutto()' type='checkbox' class='selAll'></th>
                <th id="th-id">Id</th>
                <th>Marca</th>
            </tr>
        </table>
        <div class="tbody">
            <table id="tableMarche">

            </table>
        </div>
        <form id='delMarcheForm'>
            <input type='submit' value='Elimina' class='btn'>
        </form>
    </div>
    <div class="container">
        <h2>Rimuovi modello</h2>
        <input id="cercaModello" type='text' name='ricercamodello' placeholder='Cerca' class='input'>
        <div class="thead">
            <table>
                <tr>
                    <th id="th-ch1"><input onchange='selezionaTutto2()' type='checkbox' class='selAll2'></th>
                    <th id="th-id1">Id</th>
                    <th id="th-marca1">Marca</th>
                    <th id="th-modello1">Modello</th>
                </tr>
            </table>
        </div>
        <div class="tbody">
            <table id='tableModelli'>

            </table>
        </div>
        <form id='delModelliForm'>
            <input type='submit' value='Elimina' class='btn'>
        </form>
    </div>

    <div class="container">
        <form id="marcaForm"> <button name="logout" type="submit" class="btn">Logout</button>
        </form>
    </div>
    <script src="scripts.js"></script>
</body>