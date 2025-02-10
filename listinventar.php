<?php session_start(); ?>

<?php
$title = "Folder Service";
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

$vorname = $nachname = '';
$inventory = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_password = $_POST['input_password'] ?? '';
    $vorname = $_POST['vorname'] ?? '';
    $nachname = $_POST['nachname'] ?? '';

    // Überprüfen des Passworts
    if ($input_password === '#45218932ß') {
        $_SESSION['authenticated'] = true;

        if (!empty($vorname) && !empty($nachname)) {
            $inventory = listinventar($vorname, $nachname, DB_USERNAME, DB_PASSWORD, DB_NAME);
        }
    } else {
        $error_message = "Falsches Passwort. Bitte versuchen Sie es erneut.";
    }
} else {
    // Benutzer ist nicht authentifiziert
    $show_login_form = true;
}

function mariarest($username, $password, $databasename, $mariacommand) {
    if (!shell_exec('command -v mariadb')) {
        echo "Der MariaDB-Client ist nicht installiert. Bitte installieren Sie ihn zuerst.\n";
        return 1;
    }

    if (func_num_args() != 4 || empty($username) || empty($password) || empty($databasename) || empty($mariacommand)) {
        echo "All parameters must be provided and not empty.\n";
        return 1;
    }

    $result_mariarest = shell_exec("echo \"$mariacommand;\" | MYSQL_PWD=$password mariadb -u$username $databasename -N 2>/dev/null");
    return $result_mariarest;
}

function listinventar($vorname, $nachname, $db_username, $db_password, $db_name) {
    $query = "SELECT PrincipalID FROM UserAccounts WHERE FirstName='$vorname' AND LastName='$nachname'";
    $user_uuid = mariarest($db_username, $db_password, $db_name, $query);
    $user_uuid = explode("\n", $user_uuid)[0];

    if (empty($user_uuid)) {
        echo "Benutzer nicht gefunden.\n";
        return [];
    }

    $query = "SELECT folderName FROM inventoryfolders WHERE agentID='$user_uuid'";
    $inventory = mariarest($db_username, $db_password, $db_name, $query);
    $inventory = explode("\n", trim($inventory));

    if (empty($inventory)) {
        echo "Keine Inventarordner gefunden.\n";
        return [];
    }

    return $inventory;
}
?>

<style>
    body { font-family: Arial, sans-serif; background-color: #f0f0f0; color: black; margin: 0; padding: 0; display: flex; flex-direction: column; height: 100vh; }
    .containerlist { display: flex; flex-direction: column; flex: 1; }
    header, footer { flex-shrink: 0; }
    main { flex-grow: 1; display: flex; justify-content: center; align-items: center; }
    .form-containerlist { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 600px; width: 100%; }
    h1 { font-size: 24px; margin-bottom: 20px; text-align: center; }
    label { display: block; margin-bottom: 8px; font-weight: bold; }
    input[type="text"], input[type="password"] { width: calc(100% - 20px); padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
    input[type="submit"] { width: 100%; padding: 10px; border: none; border-radius: 4px; background-color: #007bff; color: #fff; font-size: 16px; cursor: pointer; margin-bottom: 10px; }
    input[type="submit"]:hover { background-color: #0056b3; }
    .inventory-list { list-style-type: none; padding: 0; }
    .inventory-list li { padding: 8px; background-color: #f9f9f9; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 4px; }
</style>

<div class="containerlist">
    <main>
        <div class="form-containerlist">
            <h1>Inventar Liste</h1>
            <form method="POST" action="listinventar.php">
                <label for="vorname">Vorname:</label>
                <input type="text" id="vorname" name="vorname" required><br>
                
                <label for="nachname">Nachname:</label>
                <input type="text" id="nachname" name="nachname" required><br>
                
                <label for="input_password">Passwort:</label>
                <input type="password" id="input_password" name="input_password" required><br>
                
                <input type="submit" value="Inventar anzeigen">
            </form>

            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>

            <?php if ($_SESSION['authenticated'] ?? false && !empty($inventory)): ?>
                <h2>Inventar von <?= htmlspecialchars($vorname) ?> <?= htmlspecialchars($nachname) ?></h2>
                <ul class="inventory-list">
                    <?php foreach ($inventory as $item): ?>
                        <li><?= htmlspecialchars($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </main>
    <?php include_once 'include/footer.php'; ?>
</div>



