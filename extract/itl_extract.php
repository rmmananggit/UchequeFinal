<?php
// Include Composer's autoload for PhpSpreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Database connection settings
$host = 'localhost';
$dbname = 'faculty';
$user = 'root';
$password = '';

try {
    // Connect to the MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_FILES['excelFile'])) {
        $fileTmpPath = $_FILES['excelFile']['tmp_name'];
        $fileName = $_FILES['excelFile']['name'];
        $fileContent = file_get_contents($fileTmpPath);

        // Load the Excel file
        $spreadsheet = IOFactory::load($fileTmpPath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Variables to store extracted values
        $facultyCredit = null;
        $designationLoadReleased = null;
        $designation_itl = null;

        // Loop through the rows and find the required values
        foreach ($data as $row) {
            foreach ($row as $cell) {
                if (is_string($cell) && stripos($cell, 'FACULTY CREDIT') !== false) {
                    $facultyCredit = $row[9] ?? null; // Assuming the value is in the 10th column
                }
                if (is_string($cell) && stripos($cell, 'DESIGNATION, LOAD RELEASED') !== false) {
                    $designationLoadReleased = $row[9] ?? null; // Assuming the value is in the 10th column
                }
                if (is_string($cell) && stripos($cell, 'Designation:') !== false) {
                    $designation_itl = $row[11] ?? null; // Assuming the value is in the 10th column
                }
                
            }
        }

        if ($facultyCredit !== null && $designationLoadReleased !== null) {
            // Insert extracted values and file into the database
            $stmt = $pdo->prepare("
                INSERT INTO faculty_load (faculty_credit, designation_load_released,designation_itl, file, filename) 
                VALUES (:facultyCredit, :designationLoadReleased,:designation_itl, :file, :filename)
            ");
            $stmt->execute([
                ':designation_itl' => $designation_itl,
                ':facultyCredit' => $facultyCredit,
                ':designationLoadReleased' => $designationLoadReleased,
                ':file' => $fileContent,
                ':filename' => $fileName
            ]);

            echo "Data and file successfully inserted into the database.";
        } else {
            echo "Could not find the required data in the Excel file.";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel File</title>
</head>
<body>
    <h1>Upload Excel File</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="excelFile" accept=".xls,.xlsx" required>
        <button type="submit">Upload and Store</button>
    </form>
</body>
</html>
