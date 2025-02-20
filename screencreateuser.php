<?php
$title = "Create User";
include_once 'include/header.php';
include_once 'include/config.php';
?>

<style>
htmlBody {font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;} 
main {width: 50%; margin: 2em auto; padding: 2em; background-color: #ffffff; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);} 
h2 {color: #333;} 
form label {display: block; margin-bottom: 0.5em; color: #333;} 
form input[type="text"], form input[type="password"], form input[type="email"] {width: 100%; padding: 0.5em; margin-bottom: 1em; border: 1px solid #ccc; border-radius: 4px;} 
form input[type="submit"] {padding: 0.7em 2em; background-color: #007BFF; color: #ffffff; border: none; border-radius: 4px; cursor: pointer;} 
form input[type="submit"]:hover {background-color: #0056b3;}
</style>

<main>
    <h2><?php echo SITE_NAME; ?> Create User</h2>
    <p>Create a new user on our grid.</p>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize user input
        $vorname = filter_input(INPUT_POST, 'vorname', FILTER_SANITIZE_STRING);
        $nachname = filter_input(INPUT_POST, 'nachname', FILTER_SANITIZE_STRING);
        $passw = filter_input(INPUT_POST, 'passw', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
        $adminPassword = filter_input(INPUT_POST, 'adminPassword', FILTER_SANITIZE_STRING);

        if ($vorname && $nachname && $passw && $email && $userid && $adminPassword) {
            // Überprüfen, ob das Admin-Passwort korrekt ist
            //if (in_array($adminPassword, $admin_passwords)) {
            if (in_array($reg_pass, $registration_passwords_register)) {
                createuser($vorname, $nachname, $passw, $email, $userid);
            } else {
                echo "<p>Invalid admin password.</p>";
            }
        } else {
            echo "<p>Please fill in all fields correctly.</p>";
        }
    }

    function createuser($vorname, $nachname, $passwort, $email, $userid) {
        // Überprüfen, ob alle erforderlichen Parameter vorhanden sind
        if (empty($vorname)) {
            echo "Der VORNAME fehlt!";
            return;
        }
        if (empty($nachname)) {
            echo "Der NACHNAME fehlt!";
            return;
        }
        if (empty($passwort)) {
            echo "Das PASSWORT fehlt!";
            return;
        }
        if (empty($email)) {
            echo "Die EMAIL Adresse fehlt!";
            return;
        }

        // Überprüfen, ob die Screen-Sitzung existiert
        $screen_list = shell_exec("screen -list");
        if (strpos($screen_list, "RO") !== false) {
            // Befehle für die Screen-Sitzung vorbereiten
            $commands = [
                "create user",
                $vorname,
                $nachname,
                $passwort,
                $email,
                $userid,
                "" // Bestätigung für Model name
            ];

            // Debugging: Befehl und Ergebnis ausgeben
            foreach ($commands as $command) {
                $escaped_command = escapeshellarg($command);
                $screen_command = "screen -S RO -p 0 -X stuff $escaped_command^M";
                echo "Befehl: $screen_command<br>";
                $result = shell_exec($screen_command);
                echo "Ergebnis: $result<br>";
                if ($result === null) {
                    echo "Fehler beim Ausführen des Befehls: $screen_command";
                    return;
                }
            }

            echo "Benutzer erfolgreich erstellt!";
        } else {
            echo "CREATEUSER: Robust existiert nicht";
        }
    }
    ?>

    <form method="post" action="">
        <label for="vorname">Vorname:</label>
        <input type="text" id="vorname" name="vorname" required><br>
        <label for="nachname">Nachname:</label>
        <input type="text" id="nachname" name="nachname" required><br>
        <label for="passw">Passwort:</label>
        <input type="password" id="passw" name="passw" required><br>
        <label for="email">E-Mail:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="userid">Benutzer-ID:</label>
        <input type="text" id="userid" name="userid" required><br>
        <label for="adminPassword">Admin Passwort:</label>
        <input type="password" id="adminPassword" name="adminPassword" required><br>
        <input type="submit" value="Create User">
    </form>
</main>

<?php include_once 'include/footer.php'; ?>
