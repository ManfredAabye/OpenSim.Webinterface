<?php
session_start();

$title = "Datenbank Tabellen";
include 'include/header.php'; // Header-Dateien und Konfigurationen einbinden.

// Database connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login-Validierung
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];

    // Überprüfung, ob das Passwort in der Liste enthalten ist
    if (in_array($password, $registration_passwords_datatable)) {
        $_SESSION['loggedin'] = true;
    } else {
        $error = "Ungültige Anmeldeinformationen.";
    }
}

// Prüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true):
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Anmeldung erforderlich</title>
    <style>
        /* Zusätzliche Stile für die Login-Karte */
        .card {
            background-color: rgba(255, 255, 255, 0.9); /* Leicht transparentes Weiß */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin: 20px auto; /* Zentrierung */
        }
        .card h2 {
            margin-bottom: 20px;
            color: var(--primary-color); /* Verwende die primäre Farbe aus dem Header */
        }
        .card input {
            width: 80%;
            padding: 10px;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .card button {
            width: 100%;
            padding: 10px;
            background-color:rgb(95, 45, 189);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .card button:hover {
            background-color:rgb(17, 3, 138);
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Anmeldung</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="text" id="firstname" name="firstname" placeholder="Vorname" required>
            <input type="text" id="lastname" name="lastname" placeholder="Nachname" required>
            <input type="password" id="password" name="password" placeholder="Passwort" required>
            <button type="submit" name="login">Anmelden</button>
        </form>
    </div>
</body>
</html>
<?php
    exit;
endif;

// Alle Tabellennamen aus der Datenbank holen
$sql = "SHOW TABLES";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$tables = [];
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

$stmt->close();

// Benutzer wählt die Tabelle aus
$selected_table = isset($_POST['table']) ? $_POST['table'] : $tables[0];

// Spaltennamen aus der ausgewählten Tabelle holen
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$selected_table' AND TABLE_SCHEMA = '" . DB_NAME . "'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$columns = [];
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['COLUMN_NAME'];
}

$stmt->close();

// Daten aus der ausgewählten Tabelle lesen
$data_sql = "SELECT * FROM $selected_table";
$data_stmt = $conn->prepare($data_sql);
$data_stmt->execute();
$data_result = $data_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>Datenbank Tabellen</title>
    <style>
        /* Zusätzliche Stile für die Tabellenansicht */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Leicht transparentes Weiß */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: var(--primary-color); /* Verwende die primäre Farbe aus dem Header */
        }
        #table {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        #customers {
            width: 100%;
            border-collapse: collapse;
        }
        #customers th, #customers td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        #customers th {
            background-color:rgb(56, 33, 173);
            color: white;
        }
        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #customers tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tabellenauswahl und Anzeige</h1>
        <form method="post">
            <select name="table" id="table" onchange="this.form.submit()">
                <?php foreach ($tables as $table): ?>
                <option value="<?php echo htmlspecialchars($table); ?>" <?php if ($table == $selected_table) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($table); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </form><br>

        <table id="customers">
            <tr>
                <?php foreach ($columns as $column): ?>
                <th><?php echo htmlspecialchars($column); ?></th>
                <?php endforeach; ?>
            </tr>
            <?php while ($row = $data_result->fetch_assoc()): ?>
            <tr>
                <?php foreach ($columns as $column): ?>
                <td><?php echo htmlspecialchars($row[$column]); ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

<?php
$data_stmt->close();
$conn->close();
?>