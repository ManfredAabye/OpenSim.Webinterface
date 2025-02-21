<?php
$title = "New Password";
include_once 'include/header.php';

function generateActivationCode() {
    return bin2hex(random_bytes(16));
}

// UUID Generator - Zufällige UUID
function uuidv4() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

// Funktion zur Erstellung eines Salts
function ospswdsalt() {
    return md5(uniqid(mt_rand(), true));
}

// Funktion zur Erstellung des Passwort-Hashes
function ospswdhash($osPasswd, $osSalt) {
    return md5(md5($osPasswd) . ":" . $osSalt);
}

// Überprüfen, ob das Formular abgesendet wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["generateCode"])) {
        // Freischaltcode generieren und an die E-Mail-Adresse senden
        $osVorname = trim($_POST["osVorname"]);
        $osNachname = trim($_POST["osNachname"]);

        try {
            // Datenbankverbindung herstellen
            $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // E-Mail-Adresse anhand von Vorname und Nachname abrufen
            $statement = $pdo->prepare("SELECT Email FROM UserAccounts WHERE FirstName = :FirstName AND LastName = :LastName");
            $statement->execute(['FirstName' => $osVorname, 'LastName' => $osNachname]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                echo "Benutzer nicht gefunden.";
                exit;
            }

            $email = $user['Email'];
            $activationCode = generateActivationCode();

            // E-Mail an den Benutzer senden
            $subject = "Ihr Freischaltcode fuer " . SITE_NAME;
            $message = "Hallo $osVorname $osNachname,\n\n";
            $message .= "Ihr Freischaltcode lautet: $activationCode\n\n";
            $message .= "Bitte verwenden Sie diesen Code, um Ihr Passwort auf " . BASE_URL . " zu ändern.\n\n";
            $message .= "Mit freundlichen Grüßen,\n";
            $message .= SITE_NAME;

            // E-Mail senden
            $headers = "From: noreply@" . parse_url(BASE_URL, PHP_URL_HOST) . "\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            if (mail($email, $subject, $message, $headers)) {
                echo "Die E-Mail wurde an $email gesendet. Bitte schauen Sie in Ihren E-Mail-Account.";
            } else {
                echo "Fehler beim Senden der E-Mail.";
            }

        } catch (PDOException $e) {
            echo "Fehler: " . $e->getMessage();
        }
    } else {
        // Passwort ändern
        $osVorname = trim($_POST["osVorname"]);
        $osNachname = trim($_POST["osNachname"]);
        $activationCode = trim($_POST["activationCode"]);
        $newPassword = trim($_POST["newPassword"]);

        if (empty($osVorname) || empty($osNachname) || empty($activationCode) || empty($newPassword)) {
            echo "Bitte füllen Sie alle Felder aus.";
            exit;
        }

        try {
            // Datenbankverbindung herstellen
            $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Benutzer anhand des Vor- und Nachnamens suchen
            $statement = $pdo->prepare("SELECT * FROM UserAccounts WHERE FirstName = :FirstName AND LastName = :LastName");
            $statement->execute(['FirstName' => $osVorname, 'LastName' => $osNachname]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                echo "Benutzer nicht gefunden.";
                exit;
            }

            $principalID = $user['PrincipalID'];

            // Generiere ein neues Salt und Hash für das neue Passwort
            $newSalt = ospswdsalt();
            $newHash = ospswdhash($newPassword, $newSalt);

            // Passwort in der Datenbank aktualisieren
            $updateStatement = $pdo->prepare("UPDATE auth SET passwordHash = :passwordHash, passwordSalt = :passwordSalt WHERE UUID = :UUID");
            $updateStatement->execute([
                'passwordHash' => $newHash,
                'passwordSalt' => $newSalt,
                'UUID' => $principalID
            ]);

            echo "Passwort erfolgreich geändert.";

        } catch (PDOException $e) {
            echo "Fehler: " . $e->getMessage();
        }

        // Datenbankverbindung schließen
        $pdo = null;
    }
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Passwort ändern</title>
    <style>
        htmlBody {font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;} 
        main {width: 50%; margin: 2em auto; padding: 2em; background-color: #ffffff; border: 1px solid #ccc; border-radius: 15px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);} 
        h2 {color: #333;} 
        form label {display: block; margin-bottom: 0.5em; color: #333;} 
        form input[type="text"], form input[type="password"], form input[type="email"] {width: 100%; padding: 0.5em; margin-bottom: 1em; border: 1px solid #ccc; border-radius: 4px;} 
        form input[type="submit"] {padding: 0.7em 2em; background-color: #007BFF; color: #ffffff; border: none; border-radius: 4px; cursor: pointer;} 
        form input[type="submit"]:hover {background-color: #0056b3;}
    </style>
</head>
<body>
<main>
    <h2>New Password</h2>

    <form action="" method="post">
<!-- todo: Das sind die startfragen vorname nachname mehr nicht. -->
        <label for="osVorname">Vorname:</label>
        <input type="text" name="osVorname" required><br>
        <label for="osNachname">Nachname:</label>
        <input type="text" name="osNachname" required><br>
        <input type="submit" name="generateCode" value="Freischaltcode senden"><br><br>
    </form>

<!-- todo: Trennung der Eingaben hier -->

    <form action="" method="post">
<!-- todo: Nach dem Senden der E-Mail erhalten Sie einen Freischaltcode, dieser muss mit dem neuen Passwort eingetragen werden. Passwortwiedeholung fehlt hier noch samt vergleich. -->
        <label for="activationCode">Freischaltcode aus der gesendeten E-Mail:</label>
        <input type="text" name="activationCode" required><br>
        <label for="newPassword">Neues Passwort:</label>
        <input type="password" name="newPassword" required><br>
        <input type="submit" value="Passwort ändern">
    </form>
</main>
</body>
</html>
<?php include_once 'include/footer.php'; ?>
