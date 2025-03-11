<?php 
$pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept", "root", "");
$pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$current_year = $_GET['year'];

try {
    $currentliabilities = "Current Liabilities";
    $sql = "SELECT amount FROM balance_sheet WHERE accounts = :account AND year = :year";

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
     

try {
    $longtermliabilities = "Long-Term Liabilities";
    $sql = "SELECT amount FROM balance_sheet WHERE accounts = :account AND year = :year";
    
    // Prepare and execute the query
    $stmt = $pdoConnect->prepare($sql);
    $stmt->bindParam(":account", $longtermliabilities);
    $stmt->bindParam(":year", $current_year);
    $stmt->execute();

    // Initialize sum variable
    $longtermliabilitiessum = 0;

    // Fetch each row and add its number to the sum
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $longtermliabilitiessum += $row['amount'];
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$totalliabilitiessum = $currentliabiliteissum + $longtermliabilitiessum;

// Close the connection
$pdo = null;

// Echo the subtotal in HTML format
echo "<tr>";
echo "<th>Subtotal</th>";
echo "<th>₱ " . number_format((float)$totalliabilitiessum, 2) . "</th>";
echo "</tr>";
                        
?>