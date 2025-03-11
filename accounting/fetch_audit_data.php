<?php
$pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept", "root", "");
$pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch data based on the date received from the client
if (isset($_GET['date']) && !empty($_GET['date'])) {
    $date = $_GET['date'];
    $pdoAuditQuery = "SELECT * FROM audit_trail WHERE date = :date";
    $pdoResult = $pdoConnect->prepare($pdoAuditQuery);
    $pdoResult->bindParam(':date', $date);
} else {
    $pdoAuditQuery = "SELECT * FROM audit_trail";
    $pdoResult = $pdoConnect->prepare($pdoAuditQuery);
}

$pdoExec = $pdoResult->execute();
while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "<tr>";
    echo "<td>$date</td>";
    echo "<td>$time</td>";
    echo "<td>$transaction_type</td>";
    echo "<td>$account</td>";
    echo "<td>$description</td>";
    if ($flow == "Increase") {
        echo "<td>₱ " . number_format((float)$amount, 2) . "</td>";
    } else {
        echo "<td>( ₱ " . number_format((float)$amount, 2) . " )</td>";
    }
    echo "</tr>";
}
?>
