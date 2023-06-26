<?php
include "conn.php";
$marca = $_POST['marca'];
// verifica se la marca è già presente in marche
$query = "SELECT marca FROM `marche` WHERE marca = '$marca'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $risposta = "La marca " . $marca . " è già presente";
} else {
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO `marche`(`marca`) VALUES (?)");
    $stmt->bind_param("s", $marca);
    $stmt->execute();
    $risposta = "La marca è stata aggiunta";
}
echo $risposta;
