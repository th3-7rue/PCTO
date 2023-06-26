<?php
include "conn.php";
$ricerca = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';

if (!empty($ricerca)) {
    $inventario = "SELECT modelli.id AS id1, modelli.marca, modelli.modello AS modello1, marche.marca AS marca1
                    FROM modelli
                    INNER JOIN marche ON modelli.marca = marche.id
                    WHERE modelli.modello LIKE '%$ricerca%'
                    OR marche.marca LIKE '%$ricerca%'
                    OR modelli.id LIKE '%$ricerca%'";
} else {
    $inventario = "SELECT modelli.id AS id1, modelli.marca, modelli.modello AS modello1, marche.marca AS marca1
                    FROM modelli
                    INNER JOIN marche ON modelli.marca = marche.id";
}

$result = $conn->query($inventario);


$modelli = array();

while ($row = $result->fetch_assoc()) {
    $temp = [
        'id' => $row['id1'],
        'marca' => $row['marca1'],
        'modello' => $row['modello1'],
    ];
    $modelli[] = $temp;
}

// Debugging: Output the generated query and the fetched data
/*
echo "Generated Query: $inventario<br>";
echo "Fetched Data: ";
print_r($modelli);
echo "<br>";
*/
// works fine
$cleanArray = array();
foreach ($modelli as $element) {
    $cleanElement = mb_convert_encoding($element, 'UTF-8', 'UTF-8');
    $cleanArray[] = $cleanElement;
}
$str = json_encode($cleanArray, true);
if ($str === false) {
    $jsonError = json_last_error();
    switch ($jsonError) {
        case JSON_ERROR_NONE:
            echo "Nessun errore JSON rilevato.";
            break;
        case JSON_ERROR_DEPTH:
            echo "Errore JSON: superato il limite di profondità massima.";
            break;
        case JSON_ERROR_STATE_MISMATCH:
            echo "Errore JSON: mismatch dei modi o underflow.";
            break;
        case JSON_ERROR_CTRL_CHAR:
            echo "Errore JSON: carattere di controllo imprevisto trovato.";
            break;
        case JSON_ERROR_SYNTAX:
            echo "Errore JSON: errore di sintassi.";
            break;
        case JSON_ERROR_UTF8:
            echo "Errore JSON: carattere UTF-8 malformato, codifica errata.";
            break;
        case JSON_ERROR_RECURSION:
            echo "Errore JSON: un valore fa riferimento a sé stesso ricorsivamente.";
            break;
        case JSON_ERROR_INF_OR_NAN:
            echo "Errore JSON: uno o più valori INF o NAN sono stati forniti.";
            break;
        case JSON_ERROR_UNSUPPORTED_TYPE:
            echo "Errore JSON: tipo di dati non supportato.";
            break;
        case JSON_ERROR_INVALID_PROPERTY_NAME:
            echo "Errore JSON: nome della proprietà non valido.";
            break;
        case JSON_ERROR_UTF16:
            echo "Errore JSON: carattere UTF-16 malformato.";
            break;
        default:
            echo "Errore JSON: errore sconosciuto.";
            break;
    }
} else {
    // La codifica JSON è avvenuta correttamente
    echo $str;
}
