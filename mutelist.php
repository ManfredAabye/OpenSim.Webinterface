<?php
session_start();

$title = "Stummschaltungs-Verwaltung";
include_once 'include/header.php';

// Fehlerberichterstattung aktivieren
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verbindung zur Datenbank herstellen
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Funktion zum Abrufen der Stummschaltungsliste
function get_mutelist($conn, $agentID) {
    $mutelist = [];
    $query = $conn->prepare("SELECT MuteID, MuteName, type, flags, Stamp FROM mutelist WHERE AgentID = ?");
    $query->bind_param("s", $agentID);
    $query->execute();
    $result = $query->get_result();
    while ($row = $result->fetch_assoc()) {
        $mutelist[] = $row;
    }
    return $mutelist;
}

// Funktion zum Hinzufügen eines stummgeschalteten Benutzers
function add_mute($conn, $agentID, $muteID, $muteName, $type, $flags) {
    $query = $conn->prepare("INSERT INTO mutelist (AgentID, MuteID, MuteName, type, flags) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("sssii", $agentID, $muteID, $muteName, $type, $flags);
    return $query->execute();
}

// Funktion zum Entfernen eines stummgeschalteten Benutzers
function remove_mute($conn, $agentID, $muteID) {
    $query = $conn->prepare("DELETE FROM mutelist WHERE AgentID = ? AND MuteID = ?");
    $query->bind_param("ss", $agentID, $muteID);
    return $query->execute();
}

// Verarbeiten der Formulardaten
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_password = $_POST['input_password'] ?? '';
    $agentID = $_POST['agentID'] ?? '';
    $muteID = $_POST['muteID'] ?? '';
    $muteName = $_POST['muteName'] ?? '';
    $type = $_POST['type'] ?? 0;
    $flags = $_POST['flags'] ?? 0;
    $action = $_POST['action'] ?? '';

    // Überprüfen des Passworts
    if (in_array($input_password, $registration_passwords_mutelist)) {
        $_SESSION['authenticated'] = true;

        if ($action === 'add' && !empty($agentID)) {
            if (add_mute($conn, $agentID, $muteID, $muteName, $type, $flags)) {
                $success_message = "Benutzer erfolgreich stummgeschaltet.";
            } else {
                $error_message = "Fehler beim Stummschalten des Benutzers.";
            }
        } elseif ($action === 'remove' && !empty($agentID)) {
            if (remove_mute($conn, $agentID, $muteID)) {
                $success_message = "Benutzer erfolgreich von der Stummschaltungsliste entfernt.";
            } else {
                $error_message = "Fehler beim Entfernen des Benutzers.";
            }
        }
    } else {
        $error_message = "Falsches Passwort. Bitte versuchen Sie es erneut.";
    }
}

// Stummschaltungsliste abrufen
$mutelist = [];
if ($_SESSION['authenticated'] ?? false) {
    $agentID = $_POST['agentID'] ?? '';
    if (!empty($agentID)) {
        $mutelist = get_mutelist($conn, $agentID);
    }
}
?>

<style>
    body { font-family: Arial, sans-serif; background-color: <?= SECONDARY_COLOR ?>; color: <?= PRIMARY_COLOR ?>; margin: 0; padding: 0; display: flex; flex-direction: column; height: 100vh; }
    /* body { font-family: Arial, sans-serif; background-color: <?= SECONDARY_COLOR ?>; padding: 10px; color: <?= PRIMARY_COLOR ?>; } */
    .containerlist { display: flex; flex-direction: column; flex: 1; }
    header, footer { flex-shrink: 0; }
    main { flex-grow: 1; display: flex; justify-content: center; align-items: center; }
    .form-containerlist { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 600px; width: 100%; }
    h1 { font-size: 24px; margin-bottom: 20px; text-align: center; }
    label { display: block; margin-bottom: 8px; font-weight: bold; }
    input[type="text"], input[type="password"] { width: calc(100% - 20px); padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
    input[type="submit"] { width: 100%; padding: 10px; border: none; border-radius: 4px; background-color: #007bff; color: #fff; font-size: 16px; cursor: pointer; margin-bottom: 10px; }
    input[type="submit"]:hover { background-color: #0056b3; }
    .mutelist { list-style-type: none; padding: 0; }
    .mutelist li { padding: 8px; background-color: #f9f9f9; margin-bottom: 5px; border: 1px solid #ccc; border-radius: 4px; }
</style>

<div class="containerlist">
    <main>
        <div class="form-containerlist">
            <h1>Stummschaltungs-Verwaltung</h1>
            <form method="POST" action="">
                <label for="agentID">AgentID:</label>
                <input type="text" id="agentID" name="agentID" required><br>
                
                <label for="muteID">MuteID:</label>
                <input type="text" id="muteID" name="muteID"><br>
                
                <label for="muteName">MuteName:</label>
                <input type="text" id="muteName" name="muteName"><br>
                
                <label for="type">Type:</label>
                <input type="number" id="type" name="type" value="0"><br>
                
                <label for="flags">Flags:</label>
                <input type="number" id="flags" name="flags" value="0"><br>
                
                <label for="input_password">Passwort:</label>
                <input type="password" id="input_password" name="input_password" required><br>
                
                <input type="submit" name="action" value="add">
                <input type="submit" name="action" value="remove">
            </form>

            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>
            <?php if (isset($success_message)): ?>
                <p style="color: green;"><?= htmlspecialchars($success_message) ?></p>
            <?php endif; ?>

            <?php if ($_SESSION['authenticated'] ?? false && !empty($mutelist)): ?>
                <h2>Stummschaltungsliste für <?= htmlspecialchars($agentID) ?></h2>
                <ul class="mutelist">
                    <?php foreach ($mutelist as $entry): ?>
                        <li>
                            MuteID: <?= htmlspecialchars($entry['MuteID']) ?><br>
                            MuteName: <?= htmlspecialchars($entry['MuteName']) ?><br>
                            Type: <?= htmlspecialchars($entry['type']) ?><br>
                            Flags: <?= htmlspecialchars($entry['flags']) ?><br>
                            Stamp: <?= htmlspecialchars($entry['Stamp']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </main>
</div>