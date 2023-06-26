<?php
include "conn.php";
$ricerca = $_POST['ricerca'];

if (!empty($ricerca)) {
    $ricerca = "%" . $ricerca . "%";
    $inventario = "SELECT a.id, a.targa, c.marca, m.modello, a.posti, m.anno
        FROM autonoleggio AS a
        INNER JOIN modelli AS m ON a.modello = m.id
        INNER JOIN marche AS c ON a.marca = c.id
        WHERE a.targa LIKE ?
           OR m.modello LIKE ?
           OR c.marca LIKE ?
           OR a.posti LIKE ?
           OR m.anno LIKE ?";
    $stmt = $conn->prepare($inventario);
    $stmt->bind_param("sssss", $ricerca, $ricerca, $ricerca, $ricerca, $ricerca);
} else {
    $inventario = "SELECT a.id, a.targa, c.marca, m.modello, a.posti, m.anno
        FROM autonoleggio AS a
        INNER JOIN modelli AS m ON a.modello = m.id
        INNER JOIN marche AS c ON a.marca = c.id";
    $stmt = $conn->prepare($inventario);
}

$stmt->execute();
$result = $stmt->get_result();


$json = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $temp  = [
            'id' => $row['id'],
            'targa' => $row['targa'],
            'marca' => $row['marca'],
            'modello' => $row['modello'],
            'posti' => $row['posti'],
            'anno' => $row['anno']
        ];

        $json[] = $temp;
    }
}
$cleanArray = array();
foreach ($json as $element) {
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



$stmt->close();
$conn->close();
