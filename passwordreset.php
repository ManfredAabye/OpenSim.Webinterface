<?php
$title = "Password Help";
include_once 'include/header.php';
?>

<style>
htmlBody {font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;} 
main {width: 30%; margin: 2em auto; padding: 2em; background-color: #ffffff; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);} 
h2 {color: #333;} 
form label {display: block; margin-bottom: 0.5em; color: #333;} 
form input[type="text"], form input[type="password"] {width: 100%; padding: 5px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;} 
form input[type="submit"] {padding: 5px 20px; background-color: #007BFF; color: #ffffff; border: none; border-radius: 4px; cursor: pointer;} 
form input[type="submit"]:hover {background-color: #0056b3;}
</style>

<main>
    <h2><?php echo SITE_NAME; ?> Password Assistance</h2>
    <p>Find answers to Password Assistance.</p>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize user input
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);
        $reg_pass = filter_input(INPUT_POST, 'reg_pass', FILTER_SANITIZE_STRING);

        if ($email && $new_password && $reg_pass) {
            if (in_array($reg_pass, $registration_passwords_reset)) {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

                // Update the user's password in the database
                $stmt = $con->prepare("UPDATE UserAccounts SET PasswordHash = ? WHERE Email = ?");
                $stmt->bind_param("ss", $hashed_password, $email);

                if ($stmt->execute()) {
                    echo "<p>Password reset successfully!</p>";
                } else {
                    echo "<p>Error resetting password. Please try again.</p>";
                }

                $stmt->close();
                mysqli_close($con);
            } else {
                echo "<p>Invalid registration password.</p>";
            }
        } else {
            echo "<p>Please enter a valid email address, new password, and registration password.</p>";
        }
    }
    ?>

    <form method="post" action="">
        <label for="email">E-Mail:</label>
        <input type="text" id="email" name="email" required><br>
        <label for="new_password">Neues Passwort:</label>
        <input type="password" id="new_password" name="new_password" required><br>
        <label for="reg_pass">Registrierungspasswort: (Dies muss beim Admin beantragt werden.)</label>
        <input type="password" id="reg_pass" name="reg_pass" required><br>
        <input type="submit" value="Reset Password">
    </form>
</main>

<?php include_once 'include/footer.php'; ?>
