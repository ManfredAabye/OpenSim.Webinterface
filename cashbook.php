<?php
$title = "Economy";
include_once 'include/header.php';
//include_once 'config.php'; // Hier ist BANKER_UUID definiert

// Verbindung zur Datenbank herstellen
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Benutzerliste aus userinfo-Tabelle holen
$userinfo_query = "SELECT user, avatar FROM userinfo";
$userinfo_result = $conn->query($userinfo_query);
$user_names = [];
if ($userinfo_result) {
    while ($row = $userinfo_result->fetch_assoc()) {
        $user_names[$row['user']] = $row['avatar'];
    }
}

// Funktion zum Ersetzen der UUID durch den echten Namen
function getUserName($uuid, $user_names) {
    return ($uuid === BANKER_UUID) ? "Banker" : ($user_names[$uuid] ?? $uuid);
}

// Daten aus der Tabelle "balances" abfragen
$balances_query = "SELECT user, balance, status, type FROM balances";
$balances_result = $conn->query($balances_query);

// Daten aus der Tabelle "totalsales" abfragen
$totalsales_query = "SELECT user, TotalCount, TotalAmount, time FROM totalsales";
$totalsales_result = $conn->query($totalsales_query);

// Daten aus der Tabelle "transactions" abfragen
$transactions_query = "SELECT sender, receiver, amount, senderBalance, receiverBalance, objectName, regionHandle, time, status, commonName, description FROM transactions";
$transactions_result = $conn->query($transactions_query);
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
    #searchInput { width: 15%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; }
</style>

<div class="containercash">
    <main>
        <div class="table-containercash">
            <h1>Cash Book</h1>

            <input type="text" id="searchInput" onkeyup="filterUsers()" placeholder="Search...">

            <h2>Balances</h2>
            <table>
                <tr>
                    <th>User</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Type</th>
                </tr>
                <?php if ($balances_result && $balances_result->num_rows > 0): ?>
                    <?php while ($row = $balances_result->fetch_assoc()): ?>
                        <tr class="grid-item">
                            <td><?= htmlspecialchars(getUserName($row['user'], $user_names)) ?></td>
                            <td><?= htmlspecialchars($row['balance']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td><?= htmlspecialchars($row['type']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4">No data found</td></tr>
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
                    <?php while ($row = $totalsales_result->fetch_assoc()): ?>
                        <tr class="grid-item">
                            <td><?= htmlspecialchars(getUserName($row['user'], $user_names)) ?></td>
                            <td><?= htmlspecialchars($row['TotalCount']) ?></td>
                            <td><?= htmlspecialchars($row['TotalAmount']) ?></td>
                            <td><?= htmlspecialchars($row['time']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4">No data found</td></tr>
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
                    <?php while ($row = $transactions_result->fetch_assoc()): ?>
                        <tr class="grid-item">
                            <td><?= htmlspecialchars(getUserName($row['sender'], $user_names)) ?></td>
                            <td><?= htmlspecialchars(getUserName($row['receiver'], $user_names)) ?></td>
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
                    <tr><td colspan="11">No data found</td></tr>
                <?php endif; ?>
            </table>
        </div>
    </main>

    <?php include_once 'include/footer.php'; ?>
</div>

<script>
function filterUsers() {
    const input = document.getElementById('searchInput').value.toUpperCase();
    document.querySelectorAll('.grid-item').forEach(item => {
        item.style.display = item.textContent.toUpperCase().includes(input) ? "" : "none";
    });
}
</script>
<?php include_once 'include/footer.php'; ?>