<?php
$title = "Create User";
include "include/header.php";
//include "include/config.php";

// Funktion zum Senden des Befehls
function SendCommand($host, $port, $password, $command, $params=array())
{
    $paramsNames = array_keys($params);
    $paramsValues = array_values($params);

    $xml = '
    <methodCall>
    <methodName>'.htmlspecialchars($command).'</methodName>
        <params>
            <param>
                <value>
                    <struct>
                        <member>
                            <name>password</name>
                            <value><string>'.htmlspecialchars($password).'</string></value>
                        </member>';
                        if (count($params) != 0)
                        {
                            for ($p = 0; $p < count($params); $p++)
                            {
                                $xml .= '<member><name>'.htmlspecialchars($paramsNames[$p]).'</name>';
                                $xml .= is_int($paramsValues[$p]) ? '<value><int>'.$paramsValues[$p].'</int></value></member>' : '<value><string>'.htmlspecialchars($paramsValues[$p]).'</string></value></member>';
                            }
                        }
                    $xml .= '</struct>
                </value>
            </param>
        </params>
    </methodCall>';

    $timeout = 5;
    error_reporting(0);
    $fp = fsockopen($host, $port, $errno, $errstr, $timeout);

    if (!$fp)
    {
        return FALSE;
    }

    fputs($fp, "POST / HTTP/1.1\r\n");
    fputs($fp, "Host: $host\r\n");
    fputs($fp, "Content-type: text/xml\r\n");
    fputs($fp, "Content-length: ". strlen($xml) ."\r\n");
    fputs($fp, "Connection: close\r\n\r\n");
    fputs($fp, $xml);
    $res = "";

    while(!feof($fp))
    {
        $res .= fgets($fp, 128);
    }

    fclose($fp);
    $response = substr($res, strpos($res, "\r\n\r\n"));
    $result = array();

    if (preg_match_all('#<name>(.+)</name><value><(string|int|boolean|i4)>(.*)</\2></value>#U', $response, $regs, PREG_SET_ORDER))
    {
        foreach($regs as $key => $val)
        {
            $result[$val[1]] = $val[3];
        }
    }
    return $result;
}

// Eingaben filtern
$vorname = filter_input(INPUT_POST, 'vorname', FILTER_SANITIZE_STRING);
$nachname = filter_input(INPUT_POST, 'nachname', FILTER_SANITIZE_STRING);
$passw = filter_input(INPUT_POST, 'passw', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
$adminPassword = filter_input(INPUT_POST, 'adminPassword', FILTER_SANITIZE_STRING);

// Weboberfläche zur Eingabe
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $parameters = array(
        'user_firstname' => $vorname,
        'user_lastname' => $nachname,
        'user_password' => $passw,
        'user_email' => $email,
        'user_id' => $userid
    );

    $result = SendCommand(REMOTEADMIN_URL, GRID_PORT, REMOTEADMIN_HTTPAUTHPASSWORD, 'admin_create_user', $parameters);

    if ($result) {
        echo 'Benutzer erfolgreich erstellt.';
    } else {
        echo 'Fehler beim Erstellen des Benutzers.';
    }
}
?>

<!-- HTML-Formular zur Eingabe der Benutzerdaten -->
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Benutzerverwaltung</title>
</head>
<body>
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

        <button type="submit">Benutzer erstellen</button>
    </form>
</body>
</html>

<?php
include "include/footer.php";
?>  
