<?php
$title = "Avatar Rename";
include_once 'include/header.php';
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
    <h2><?php echo SITE_NAME; ?> Rename Avatar</h2>
    <p>Rename an existing avatar on our grid.</p>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize user input
        $avatarUUID = filter_input(INPUT_POST, 'avatarUUID', FILTER_SANITIZE_STRING);
        $oldFirstName = filter_input(INPUT_POST, 'oldFirstName', FILTER_SANITIZE_STRING);
        $oldLastName = filter_input(INPUT_POST, 'oldLastName', FILTER_SANITIZE_STRING);
        $newFirstName = filter_input(INPUT_POST, 'newFirstName', FILTER_SANITIZE_STRING);
        $newLastName = filter_input(INPUT_POST, 'newLastName', FILTER_SANITIZE_STRING);
        $adminPassword = filter_input(INPUT_POST, 'adminPassword', FILTER_SANITIZE_STRING);

        if ($avatarUUID && $oldFirstName && $oldLastName && $newFirstName && $newLastName && $adminPassword) {
            // Überprüfen, ob das Admin-Passwort korrekt ist
            if (in_array($adminPassword, $registration_passwords_rename)) {

                // Avatar-Daten überprüfen
                $sql_check = "SELECT * FROM avatars WHERE uuid='$avatarUUID' AND firstName='$oldFirstName' AND lastName='$oldLastName'";
                $result_check = mysqli_query($conn, $sql_check);

                if (mysqli_num_rows($result_check) > 0) {
                    // Beginne eine Transaktion
                    mysqli_begin_transaction($conn);

                    try {
                        // Avatar-Daten aktualisieren
                        $sql_update = "UPDATE avatars SET firstName='$newFirstName', lastName='$newLastName' WHERE uuid='$avatarUUID'";
                        if (!mysqli_query($conn, $sql_update)) {
                            throw new Exception("Fehler: " . mysqli_error($conn));
                        }

                        // Transaktion abschließen
                        mysqli_commit($conn);
                        echo "<p>Avatar erfolgreich umbenannt!</p>";

                    } catch (Exception $e) {
                        mysqli_rollback($conn);
                        echo "<p>Transaktion fehlgeschlagen: " . $e->getMessage() . "</p>";
                    }

                    mysqli_close($conn);
                } else {
                    echo "<p>Alter Vorname oder Nachname ist nicht korrekt.</p>";
                }
            } else {
                echo "<p>Invalid admin password.</p>";
            }
        } else {
            echo "<p>Please fill in all fields correctly.</p>";
        }
    }
    ?>

    <form method="post" action="">
        <label for="avatarUUID">Avatar UUID:</label>
        <input type="text" id="avatarUUID" name="avatarUUID" required><br>
        <label for="oldFirstName">Alter Vorname:</label>
        <input type="text" id="oldFirstName" name="oldFirstName" required><br>
        <label for="oldLastName">Alter Nachname:</label>
        <input type="text" id="oldLastName" name="oldLastName" required><br>
        <label for="newFirstName">Neuer Vorname:</label>
        <input type="text" id="newFirstName" name="newFirstName" required><br>
        <label for="newLastName">Neuer Nachname:</label>
        <input type="text" id="newLastName" name="newLastName" required><br>
        <label for="adminPassword">Admin Passwort:</label>
        <input type="password" id="adminPassword" name="adminPassword" required><br>
        <input type="submit" value="Rename Avatar">
    </form>
</main>

<?php include_once 'include/footer.php'; ?>
