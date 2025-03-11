<?php
// Include database connection
include_once("connection/connection.php");
$pdo = connection();

// Fetch data from the database
$sql = "SELECT * FROM ordertb";
$stmt = $pdo->query($sql);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// HTML content for the table
$tableHTML = '<table class="table" id="orderTable">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

// Loop through fetched items and append table rows
foreach ($items as $row) {
    $tableHTML .= '<tr>
                    <td>' . $row['category'] . '</td>
                    <td>' . $row['product_name'] . '</td>
                    <td>' . $row['description'] . '</td>
                    <td>' . $row['quantity'] . '</td>
                    <td>
                        <!-- Delete button form -->
                        <form method="POST" action="deleteorder.php" class="delete-form">
                            <input type="hidden" name="product_id" value="' . $row['product_Id'] . '">
                            <button type="button" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>';
}

// Close the table HTML
$tableHTML .= '</tbody>
            </table>';

// Return the HTML content
echo $tableHTML;
?>
