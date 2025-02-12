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
<html>
<head>
    <title>Anmeldung erforderlich</title>
</head>
<body>
    <h2>Anmeldung</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="firstname">Vorname:</label>
        <input type="text" id="firstname" name="firstname" required><br>
        <label for="lastname">Nachname:</label>
        <input type="text" id="lastname" name="lastname" required><br>
        <label for="password">Passwort:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit" name="login">Anmelden</button>
    </form>
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
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  color: black;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}
#table {
  font-family: Arial, Helvetica, sans-serif;
  color: black;
  border-collapse: collapse;
  width: 15%;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: black;
}
</style>
</head>
<body>

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

</body>
</html>

<?php
$data_stmt->close();
$conn->close();
include 'include/footer.php';
?>
