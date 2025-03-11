<?php
$pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept", "root", "");
$pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $current_year = $_GET['year'];
                $currentasset = "Current Assets";
                $pdoQuery = "SELECT * FROM balance_sheet WHERE accounts = :account AND year = :year";
                $pdoResult = $pdoConnect->prepare($pdoQuery);
                $pdoResult->bindParam(':account', $currentasset);
                $pdoResult->bindParam(':year', $current_year);
                $pdoExec = $pdoResult->execute();
                while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                    echo "<td>$sub_account</td>";
                    echo "<td>₱ " . number_format((float)$amount, 2) . "</td>";
                    echo "</tr>";
                }
    
                ?>