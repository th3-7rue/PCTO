<?php
include "conn.php";
$query = "SELECT * FROM marche";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $response[] = array(
        'id' => $row['id'],
        'marca' => $row['marca']
    );
}
echo json_encode($response);
