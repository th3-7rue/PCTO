<?php
include "conn.php";
$ricerca = $_REQUEST['q'];
if (
    !empty($ricerca)
) {
    $inventario = "SELECT *
                    FROM marche
                    WHERE marca LIKE '%$ricerca%'";
} else {
    $inventario = "SELECT *
                    FROM marche";
}
$result = $conn->query($inventario);
$marche = array();
while ($row = $result->fetch_assoc()) {
    $temp = [
        'id' => $row['id'],
        'marca' => $row['marca']
    ];
    $marche[] = $temp;
}
echo json_encode($marche);
