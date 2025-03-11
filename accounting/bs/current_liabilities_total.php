<?php 
$pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept", "root", "");
$pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$current_year = $_GET['year'];
$currentliabilities = "Current Liabilities";

$sql = "SELECT amount FROM balance_sheet WHERE accounts = :account AND year = :year";

try {
    // Prepare and execute the query
    $stmt = $pdoConnect->prepare($sql);
    $stmt->bindParam(':account', $currentliabilities);
    $stmt->bindParam(':year', $current_year);
    $stmt->execute();

    // Initialize sum variable
    $currentliabiliteissum = 0;

    // Fetch each row and add its number to the sum
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $currentliabiliteissum += $row['amount'];
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Close the connection
$pdo = null;

// Echo the subtotal in HTML format
echo "<tr>";
echo "<th>Subtotal</th>";
echo "<th>₱ " . number_format((float)$currentliabiliteissum, 2) . "</th>";
echo "</tr>";
                        
?>
