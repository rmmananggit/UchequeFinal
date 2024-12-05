<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Database configuration
$host = 'localhost';
$dbname = 'faculty';
$username = 'root';
$password = '';

// Connect to MySQL
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

$previewData = []; // Array to store preview data

// Check if a file was uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excelFile'])) {
    // Save uploaded file to a temporary location
    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['excelFile']['name']);
    $filePath = $uploadDir . $fileName;

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create upload directory if it doesn't exist
    }

    if (move_uploaded_file($_FILES['excelFile']['tmp_name'], $filePath)) {
        try {
            // Load the uploaded Excel file
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            // Prepare SQL query
            $sql = "INSERT INTO excel_data (column1, total, remarks) VALUES (:column1, :total, :remarks)";
            $stmt = $pdo->prepare($sql);

            // Read rows from Excel and prepare for display
            foreach ($worksheet->getRowIterator(2) as $row) { // Start from row 2 if row 1 has headers
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue();
                }

                // Assign Excel columns to variables
                $column1 = $data[0] ?? null;
                $total = $data[7] ?? null;
                $remarksColumn = $data[11] ?? null; // Assuming remarks are in the 4th column

                // If "REMARKS" has a value, display "8:00", otherwise keep the original value
                $remarks = !empty($remarksColumn) ? '8:00' : null;

                // Add data to preview array
                $previewData[] = [
                    'column1' => $column1,
                    'total' => $total,
                    'remarks' => $remarks,
                ];

                // Optional: Insert data into the database
                $stmt->execute([
                    ':column1' => $column1,
                    ':total' => $total,
                    ':remarks' => $remarks,
                ]);
            }

            echo "File processed successfully!";
        } catch (Exception $e) {
            echo "Error processing the Excel file: " . $e->getMessage();
        }
    } else {
        echo "Failed to upload the file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel File</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Upload Excel File</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="excelFile" accept=".xls,.xlsx" required>
        <button type="submit">Upload and Preview</button>
    </form>

    <?php if (!empty($previewData)): ?>
        <h2>Preview of Uploaded Data</h2>
        <table>
            <thead>
                <tr>
                    <th>Column 1</th>
                    <th>Total</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($previewData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['column1']); ?></td>
                        <td><?php echo htmlspecialchars($row['total']); ?></td>
                        <td><?php echo htmlspecialchars($row['remarks']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
