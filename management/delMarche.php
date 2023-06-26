<?php
include "conn.php";

// Check if the 'chk[]' parameter is set and is an array
if (isset($_POST['chk']) && is_array($_POST['chk'])) {
    $marche = $_POST['chk'];

    // Initialize the response array
    $response = array(
        'cannot_delete' => array(),
        'deleted_models' => array(),
        'deleted_brands' => array()
    );

    // Prepare the statements for deletion
    $deleteModelsStmt = $conn->prepare("DELETE FROM `modelli` WHERE marca = ?");
    $deleteBrandsStmt = $conn->prepare("DELETE FROM `marche` WHERE id = ?");

    // Check if the statements were prepared successfully
    if ($deleteModelsStmt && $deleteBrandsStmt) {
        // Loop through each selected brand ID
        foreach ($marche as $id) {
            // Check if the brand is present in the 'autonoleggio' table
            $checkBrandQuery = "SELECT marca FROM `autonoleggio` WHERE marca = ?";
            $checkBrandStmt = $conn->prepare($checkBrandQuery);
            $checkBrandStmt->bind_param("i", $id);
            $checkBrandStmt->execute();
            $checkBrandResult = $checkBrandStmt->get_result();

            // Check if there are any matching records in 'autonoleggio'
            if ($checkBrandResult->num_rows > 0) {
                $brandName = getBrandName($conn, $id);
                $response['cannot_delete'][] = $brandName;
            } else {
                // Check if the brand has models in the 'modelli' table
                $checkModelsQuery = "SELECT marca FROM `modelli` WHERE marca = ?";
                $checkModelsStmt = $conn->prepare($checkModelsQuery);
                $checkModelsStmt->bind_param("i", $id);
                $checkModelsStmt->execute();
                $checkModelsResult = $checkModelsStmt->get_result();

                // Delete models if any exist for the brand
                if ($checkModelsResult->num_rows > 0) {
                    $brandName = getBrandName($conn, $id);
                    $response['deleted_models'][] = $brandName;

                    $deleteModelsStmt->bind_param("i", $id);
                    $deleteModelsStmt->execute();
                }

                // Delete the brand from the 'marche' table
                $brandName = getBrandName($conn, $id);
                $response['deleted_brands'][] = $brandName;

                $deleteBrandsStmt->bind_param("i", $id);
                $deleteBrandsStmt->execute();
            }
        }

        // Close the prepared statements
        $deleteModelsStmt->close();
        $deleteBrandsStmt->close();

        // Encode the response as JSON and echo it
        echo json_encode($response);
    } else {
        // Error preparing the statements
        echo "Error preparing statements.";
    }
} else {
    // Invalid or missing input
    echo "Invalid or missing input.";
}

// Function to retrieve the brand name from the 'marche' table
function getBrandName($conn, $brandId)
{
    $stmt = $conn->prepare("SELECT marca FROM `marche` WHERE id = ?");
    $stmt->bind_param("i", $brandId);
    $stmt->execute();
    $result = $stmt->get_result();
    $brandName = $result->fetch_assoc()['marca'];
    $stmt->close();
    return $brandName;
}
