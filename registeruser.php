<?php
$title = "Register";
include 'include/config.php';
include 'include/header.php';

// Define the list of admin-provided registration passwords
$registration_passwords = ["rUKBGMhZghjghjPEwps454", "bXWpdm8dfgdfgCwbjDCE6Z", "rksYwereraHJfkFvavLE"];
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
    <h2><?php echo SITE_NAME; ?> Register a New Account</h2>
    <p>Sign up to become a member of our grid.</p>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize user input
        $vorname = filter_input(INPUT_POST, 'vorname', FILTER_SANITIZE_STRING);
        $nachname = filter_input(INPUT_POST, 'nachname', FILTER_SANITIZE_STRING);
        $passw = filter_input(INPUT_POST, 'passw', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $prim_uuid = filter_input(INPUT_POST, 'prim_uuid', FILTER_SANITIZE_STRING);
        $modell = filter_input(INPUT_POST, 'modell', FILTER_SANITIZE_STRING);
        $reg_pass = filter_input(INPUT_POST, 'reg_pass', FILTER_SANITIZE_STRING);

        if ($vorname && $nachname && $passw && $email && $prim_uuid && $modell && $reg_pass) {
            if (in_array($reg_pass, $registration_passwords)) {
                // Command to create a new user
                $command = "screen -S RO -p 0 -X eval \"stuff 'create user $vorname $nachname $passw $email $prim_uuid $modell'^M\"";

                // Use proc_open for more control over the command execution
                $descriptorspec = array(
                    0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
                    1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
                    2 => array("pipe", "w")   // stderr is a pipe that the child will write to
                );

                $process = proc_open($command, $descriptorspec, $pipes, null, null);

                if (is_resource($process)) {
                    // Close the pipes to free up resources
                    fclose($pipes[0]);

                    // Read the output from the command
                    $output = stream_get_contents($pipes[1]);
                    fclose($pipes[1]);

                    // Read any errors
                    $errors = stream_get_contents($pipes[2]);
                    fclose($pipes[2]);

                    // Close the process
                    $return_value = proc_close($process);

                    // Handle the output and errors
                    if ($return_value === 0) {
                        echo "<p>User created successfully!</p>";
                    } else {
                        echo "<p>Error creating user: $errors</p>";
                    }
                } else {
                    echo "<p>Failed to execute command.</p>";
                }
            } else {
                echo "<p>Invalid registration password.</p>";
            }
        } else {
            echo "<p>Please fill in all fields correctly.</p>";
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
        <label for="prim_uuid">Primäre UUID:</label>
        <input type="text" id="prim_uuid" name="prim_uuid" required><br>
        <label for="modell">Modell:</label>
        <input type="text" id="modell" name="modell" required><br>
        <label for="reg_pass">Registrierungspasswort: (Dies muss beim Admin beantragt werden.)</label>
        <input type="password" id="reg_pass" name="reg_pass" required><br>
        <input type="submit" value="Register">
    </form>
</main>

<?php include 'include/footer.php'; ?>
