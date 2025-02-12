<?php
$title = "Password Service";
include_once 'header.php';
// Passwortgenerator-Funktion
function generatePassword($length = 16) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $password;
}

// Generiere Passwörter für das Register-Array
$registration_passwords_register = [generatePassword(), generatePassword(), generatePassword(), generatePassword(), generatePassword()];

// Generiere Passwörter für das Reset-Array
$registration_passwords_reset = [generatePassword(), generatePassword(), generatePassword(), generatePassword(), generatePassword()];

// Generiere Passwörter für das Partner-Array
$registration_passwords_partner = [generatePassword(), generatePassword(), generatePassword(), generatePassword(), generatePassword()];

// Generiere Passwörter für das inventory-Array
$registration_passwords_inventory = [generatePassword(), generatePassword(), generatePassword(), generatePassword(), generatePassword()];

// Generiere Passwörter für das datatable-Array
$registration_passwords_datatable = [generatePassword(), generatePassword(), generatePassword(), generatePassword(), generatePassword()];
?>

<!DOCTYPE html>
<html lang="de">
<body>
    <h1>Generierte Passwörter</h1>
    <pre>
<?php
echo '$registration_passwords_register = ["' . implode('", "', $registration_passwords_register) . '"];' . PHP_EOL;
echo '$registration_passwords_reset = ["' . implode('", "', $registration_passwords_reset) . '"];' . PHP_EOL;
echo '$registration_passwords_partner = ["' . implode('", "', $registration_passwords_partner) . '"];' . PHP_EOL;
echo '$registration_passwords_inventory = ["' . implode('", "', $registration_passwords_inventory) . '"];' . PHP_EOL;
echo '$registration_passwords_datatable = ["' . implode('", "', $registration_passwords_datatable) . '"];' . PHP_EOL;
?>
    </pre>
</body>
</html>
<?php include_once 'footer.php'; ?>
