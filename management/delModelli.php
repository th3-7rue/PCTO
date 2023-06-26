<?php
include "conn.php";
// Check if the 'chk2[]' parameter is set and is an array
if (isset($_POST['chk2']) && is_array($_POST['chk2'])) {
    $modelli = $_POST['chk2'];
    // Initialize the response array
    $response = array(
        'cannot_delete' => array(),
        'deleted_models' => array()
    );
    // Prepare the statements for deletion
    $deleteModelsStmt = $conn->prepare("DELETE FROM `modelli` WHERE id = ?");
    // Check if the statements were prepared successfully
    if ($deleteModelsStmt) {
        // Loop through each selected model ID
        foreach ($modelli as $id) {
            // Check if the model is present in the 'autonoleggio' table
            $checkModelQuery = "SELECT modello FROM `autonoleggio` WHERE modello = ?";
            $checkModelStmt = $conn->prepare($checkModelQuery);
            $checkModelStmt->bind_param("i", $id);
            $checkModelStmt->execute();
            $checkModelResult = $checkModelStmt->get_result();
            // Check if there are any matching records in 'autonoleggio'
            if ($checkModelResult->num_rows > 0) {
                $modelName = getModelName($conn, $id);
                $response['cannot_delete'][] = $modelName;
            } else {
                // Delete the model from the 'modelli' table
                $modelName = getModelName($conn, $id);
                $response['deleted_models'][] = $modelName;
                $deleteModelsStmt->bind_param("i", $id);
                $deleteModelsStmt->execute();
            }
        }
        // Close the prepared statements
        $deleteModelsStmt->close();
    }
    // Close the database connection
    $conn->close();
    // Return the response
    echo json_encode($response);
}
function getModelName($conn, $id)
{
    $query = "SELECT modello FROM `modelli` WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['modello'];
}
