<?php
$pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept", "root", "");
$pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch data based on the date received from the client
if (isset($_GET['date']) && !empty($_GET['date'])) {
    $date = $_GET['date'];
    $pdoLedgerQuery = "SELECT * FROM general_ledger WHERE date = :date";
    $pdoResult = $pdoConnect->prepare($pdoLedgerQuery);
    $pdoResult->bindParam(':date', $date);
} else {
    $pdoLedgerQuery = "SELECT * FROM general_ledger";
    $pdoResult = $pdoConnect->prepare($pdoLedgerQuery);
}

$pdoExec = $pdoResult->execute();
while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "<tr>";
    echo "<td>$date</td>";
    echo "<td>$time</td>";
    echo "<td>$account</td>";
    echo "<td>$description</td>";
    echo "<td>₱ " . number_format((float)$debit, 2) . "</td>";
    echo "<td>₱ " . number_format((float)$credit, 2) . "</td>";
    echo "<td>₱ " . number_format((float)$balance, 2) . "</td>";
    echo "</tr>";
}
?>
