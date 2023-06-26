<?php
include "conn.php";
$targa = $_POST['targa'];
$targa = strtoupper($targa);
$marca = $_POST['marca'];
$modello = $_POST['modello'];
$nPosti = $_POST['nPosti'];
$inserisci = "INSERT INTO autonoleggio (targa, marca, modello, posti) VALUES (?, ?, ?, ?)";
$stmt = $GLOBALS['conn']->prepare($inserisci);
$stmt->bind_param("siis", $targa, $marca, $modello, $nPosti);
$stmt->execute();
$stmt->close();
$response = "ok";
echo $response;
