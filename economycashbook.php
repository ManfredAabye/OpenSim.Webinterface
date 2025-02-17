<?php
$title = "Economy";
include_once 'include/header.php';

// Fehlerberichterstattung aktivieren
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Verbindung zur Datenbank herstellen
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Abfragen der Daten aus der Tabelle "balances"
$balances_query = "SELECT user, balance, status, type FROM balances";
$balances_result = $conn->query($balances_query);
if ($balances_result === false) {
    echo "Fehler beim Abfragen der Daten aus der Tabelle 'balances': " . $conn->error . "<br>";
}

// Abfragen der Daten aus der Tabelle "totalsales"
$totalsales_query = "SELECT user, TotalCount, TotalAmount, time FROM totalsales";
$totalsales_result = $conn->query($totalsales_query);
if ($totalsales_result === false) {
    echo "Fehler beim Abfragen der Daten aus der Tabelle 'totalsales': " . $conn->error . "<br>";
}

// Abfragen der Daten aus der Tabelle "transactions"
$transactions_query = "SELECT sender, receiver, amount, senderBalance, receiverBalance, objectName, regionHandle, time, status, commonName, description FROM transactions";
$transactions_result = $conn->query($transactions_query);
if ($transactions_result === false) {
    echo "Fehler beim Abfragen der Daten aus der Tabelle 'transactions': " . $conn->error . "<br>";
}
?>

<style>
    body { font-family: Arial, sans-serif; color: black; margin: 0; padding: 0; }
    .containercash { display: flex; flex-direction: column; min-height: 100vh; }
    header, footer { flex-shrink: 0; }
    main { flex-grow: 1; display: flex; justify-content: center; align-items: center; padding: 20px; }
    .table-containercash { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 100%; max-width: 100%; }
    h1 { font-size: 24px; margin-bottom: 20px; text-align: center; }
    h2 { font-size: 18px; margin-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px; }
    table, th, td { border: 1px solid #ccc; }
    th, td { padding: 5px; text-align: left; }
    th { background-color: #f2f2f2; }
</style>

<div class="containercash">
    <main>
        <div class="table-containercash">
            <h1>cash book</h1>

            <h2>Balances</h2>
            <table>
                <tr>
                    <th>User</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Type</th>
                </tr>
                <?php if ($balances_result && $balances_result->num_rows > 0): ?>
                    <?php while($row = $balances_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['user']) ?></td>
                            <td><?= htmlspecialchars($row['balance']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td><?= htmlspecialchars($row['type']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No data found</td>
                    </tr>
                <?php endif; ?>
            </table>

            <h2>Total Sales</h2>
            <table>
                <tr>
                    <th>User</th>
                    <th>Total Count</th>
                    <th>Total Amount</th>
                    <th>Time</th>
                </tr>
                <?php if ($totalsales_result && $totalsales_result->num_rows > 0): ?>
                    <?php while($row = $totalsales_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['user']) ?></td>
                            <td><?= htmlspecialchars($row['TotalCount']) ?></td>
                            <td><?= htmlspecialchars($row['TotalAmount']) ?></td>
                            <td><?= htmlspecialchars($row['time']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No data found</td>
                    </tr>
                <?php endif; ?>
            </table>

            <h2>Transactions</h2>
            <table>
                <tr>
                    <th>Sender</th>
                    <th>Receiver</th>
                    <th>Amount</th>
                    <th>Sender Balance</th>
                    <th>Receiver Balance</th>
                    <th>Object Name</th>
                    <th>Region Handle</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Common Name</th>
                    <th>Description</th>
                </tr>
                <?php if ($transactions_result && $transactions_result->num_rows > 0): ?>
                    <?php while($row = $transactions_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['sender']) ?></td>
                            <td><?= htmlspecialchars($row['receiver']) ?></td>
                            <td><?= htmlspecialchars($row['amount']) ?></td>
                            <td><?= htmlspecialchars($row['senderBalance']) ?></td>
                            <td><?= htmlspecialchars($row['receiverBalance']) ?></td>
                            <td><?= htmlspecialchars($row['objectName']) ?></td>
                            <td><?= htmlspecialchars($row['regionHandle']) ?></td>
                            <td><?= htmlspecialchars($row['time']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td><?= htmlspecialchars($row['commonName']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11">No data found</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </main>

    <?php include_once 'include/footer.php'; ?>

</div>
