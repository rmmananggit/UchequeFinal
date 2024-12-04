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

$groupSums = []; // To store sum results by groups of 6

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

            // Initialize variables for grouping
            $groupCounter = 0;
            $rowCounter = 0;
            $currentGroupSum = 0;

            // Read rows from Excel and calculate sums
            foreach ($worksheet->getRowIterator(2) as $row) { // Start from row 2
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $data = [];
                foreach ($cellIterator as $cell) {
                    $data[] = $cell->getValue();
                }

                // Extract values from "Total" and "Remarks" columns
                $total = $data[7] ?? null; // Assuming "Total" is in column 8 (index 7)
                $remarks = $data[11] ?? null; // Assuming "Remarks" is in column 12 (index 11)

                // Use value from "Total" or fallback to "Remarks"
                $value = !empty($total) ? $total : (!empty($remarks) ? $remarks : 0);

                // Convert time strings (e.g., "08:42") to decimal for summing
                if (strpos($value, ':') !== false) {
                    list($hours, $minutes) = explode(':', $value);
                    $value = $hours + ($minutes / 60); // Convert to decimal hours
                }

                // Ensure value is a number, fallback to 0 if not
                $value = is_numeric($value) ? $value : 0;

                $currentGroupSum += (float) $value; // Add to current group sum
                $rowCounter++;

                // Check if we've completed a group of 6 rows
                if ($rowCounter % 6 == 0) {
                    $groupSums[$groupCounter] = $currentGroupSum;
                    $currentGroupSum = 0;
                    $groupCounter++;
                }
            }

            // Add the final group sum if there are leftover rows
            if ($rowCounter % 6 != 0) {
                $groupSums[$groupCounter] = $currentGroupSum;
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
            width: 50%;
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
        <button type="submit">Upload and Process</button>
    </form>

    <?php if (!empty($groupSums)): ?>
        <h2>Group Sums (By 6 Rows)</h2>
        <table>
            <thead>
                <tr>
                    <th>Group</th>
                    <th>Sum</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groupSums as $groupIndex => $sum): ?>
                    <tr>
                        <td><?php echo 'Group ' . ($groupIndex + 1); ?></td>
                        <td><?php echo number_format($sum, 2); ?> (hours)</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
