<?php
include "conn.php";
$marca = $_POST['marca'];
$query = "SELECT * FROM modelli where marca = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $marca);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $response[] = array(
        'id' => $row['id'],
        'modello' => $row['modello']
    );
}
// correggi la codifica dei caratteri
$cleanArray = array();
foreach ($response as $element) {
    $cleanElement = mb_convert_encoding($element, 'UTF-8', 'UTF-8');
    $cleanArray[] = $cleanElement;
}
$response = $cleanArray;

echo json_encode($response);
