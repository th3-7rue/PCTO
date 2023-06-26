<?php
include "conn.php";

$marca = $_POST['marca'];
$modello = $_POST['modello'];
// verifica se il modello è già presente in modelli
$query = "SELECT modello FROM `modelli` WHERE modello = '$modello'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    $response = 'Il modello  ' . $modello . '  è già presente';
} else {
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO `modelli`(`marca`, `modello`) VALUES (?, ?)");
    $stmt->bind_param("is", $marca, $modello);
    $stmt->execute();
    $stmt->close();
    $response = 'Il modello è stato aggiunto';
}
echo $response;
