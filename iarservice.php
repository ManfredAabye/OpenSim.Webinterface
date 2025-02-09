<?php
$title = "IAR Service";
include 'include/config.php';
include 'include/header.php';

// Fehlerberichterstattung aktivieren
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Verbindung zur Datenbank herstellen
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['upload'])) {
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $passwort = $_POST['passwort'];
        $archivpfad = '/opt/backup/inventar'; // Oder einen anderen Pfad angeben

        saveinventar($vorname, $nachname, $passwort, $archivpfad, DB_USERNAME, DB_PASSWORD, DB_NAME);
    } elseif (isset($_POST['load'])) {
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $passwort = $_POST['passwort'];
        $datei = $_FILES['iar_file']['tmp_name'];
        $dateiname = $_FILES['iar_file']['name'];

        loadiar($vorname, $nachname, $passwort, $datei, $dateiname);
    }
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
    echo $result_mariarest;
}

function saveinventar($vorname, $nachname, $passwort, $archivpfad, $db_username, $db_password, $db_name) {
    $SAVEINVSCREEN = "sim1";

    if (!file_exists($archivpfad)) {
        mkdir($archivpfad, 0777, true);
    }

    $query = "SELECT PrincipalID FROM UserAccounts WHERE FirstName='$vorname' AND LastName='$nachname'";
    $user_uuid = mariarest($db_username, $db_password, $db_name, $query);
    $user_uuid = explode("\n", $user_uuid)[0];

    if (empty($user_uuid)) {
        echo "Benutzer nicht gefunden.\n";
        return 1;
    }

    $query = "SELECT folderName FROM inventoryfolders WHERE agentID='$user_uuid'";
    $inventarpfad = mariarest($db_username, $db_password, $db_name, $query);
    $inventarpfad = explode("\n", trim($inventarpfad));

    if (empty($inventarpfad)) {
        echo "Keine Inventarordner gefunden.\n";
        return 1;
    }

    if (!shell_exec("screen -list | grep -q $SAVEINVSCREEN")) {
        echo "OSCOMMAND: Der Screen $SAVEINVSCREEN existiert nicht\n";
        return 1;
    }

    foreach ($inventarpfad as $verzeichnis) {
        $verzeichnis_escaped = '"' . $verzeichnis . '"';
        $datei_name = str_replace(' ', '_', $verzeichnis);
        $datei = "$archivpfad/{$vorname}_{$nachname}_{$datei_name}.iar";
        echo "[DEBUG] Speichere Verzeichnis: $verzeichnis_escaped -> Datei: $datei\n";
        shell_exec("screen -S $SAVEINVSCREEN -p 0 -X eval \"stuff 'save iar $vorname $nachname $verzeichnis_escaped $passwort $datei'^M\"");
        sleep(60);
    }

    return 0;
}

function loadiar($vorname, $nachname, $passwort, $datei, $dateiname) {
    $LOADINVSCREEN = "sim1";

    if (!shell_exec("screen -list | grep -q $LOADINVSCREEN")) {
        echo "OSCOMMAND: Der Screen $LOADINVSCREEN existiert nicht\n";
        return 1;
    }

    echo "[DEBUG] Lade Datei: $dateiname\n";
    shell_exec("screen -S $LOADINVSCREEN -p 0 -X eval \"stuff 'load iar $vorname $nachname $passwort $datei'^M\"");

    return 0;
}
?>

<style>
    .bodyiar { font-family: Arial, sans-serif; background-color: #f0f0f0; margin: 0; padding: 0; }
    .containeriar { display: flex; flex-direction: column; min-height: 80vh; }

    header, footer { flex-shrink: 0; }
    main { flex-grow: 1; display: flex; justify-content: center; align-items: center; padding: 20px; background-color: #fff; }
    .form-container { background-color: #fff; color: black; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 400px; width: 100%; }
    h1 { font-size: 24px; margin-bottom: 20px; text-align: center; }
    label { display: block; margin-bottom: 8px; font-weight: bold; }
    input[type="text"], input[type="password"], input[type="file"] { width: calc(100% - 20px); padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
    input[type="submit"] { width: 100%; padding: 10px; border: none; border-radius: 4px; background-color: #007bff; color: #fff; font-size: 16px; cursor: pointer; margin-bottom: 10px; }
    input[type="submit"]:hover { background-color: #0056b3; }
</style>

<div class="containeriar">
    <main>
        <div class="form-container">
            <h1>Inventar Speichern und Laden</h1>
            <form method="POST" action="index.php" enctype="multipart/form-data">
                <label for="vorname">Vorname:</label>
                <input type="text" id="vorname" name="vorname" required><br>
                
                <label for="nachname">Nachname:</label>
                <input type="text" id="nachname" name="nachname" required><br>
                
                <label for="passwort">Passwort:</label>
                <input type="password" id="passwort" name="passwort" required><br>

                <label for="iar_file">IAR Datei hochladen:</label>
                <input type="file" id="iar_file" name="iar_file"><br>
                
                <input type="submit" name="upload" value="Inventar Speichern">
                <input type="submit" name="load" value="IAR Datei Laden">
            </form>
        </div>
    </main>
    <?php include 'include/footer.php'; ?>
</div>
