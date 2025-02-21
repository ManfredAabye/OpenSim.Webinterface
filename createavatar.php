<?php
$title = "Register";
include_once 'include/header.php';

// UUID Generator Random UUID
function uuidv4() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

        // 32 bits
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits
        mt_rand(0, 0xffff),

        // 16 bits
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits - 8 bits
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}
// Generiere eine zufällige AntispamID
$oscaptchaid = uuidv4();
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>

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
    <h2>Avatar Registration</h2>

    <?php 
    if (!isset($_POST['postname'])):         
    ?>

    <form action="" method="post">
        <input type="hidden" name="postname" value="1" />
        <input type="hidden" name="oscaptchaid" value="<?php echo $oscaptchaid; ?>" />
        
        <div class="form-group">
            <label for="base">Vorname:</label>
            <input type="text" placeholder="John" name="osVorname" maxlength="40" />
        </div>
        
        <div class="form-group">
            <label for="base">Nachname:</label>
            <input type="text" placeholder="Doe" name="osNachname" maxlength="40" />
        </div>
        
        <div class="form-group">
            <label for="osEMail">E-Mail:</label>
            <input type="text" placeholder="john@doe.com" name="osEMail" maxlength="40" />
        </div>
        
        <div class="form-group">
            <label for="osPasswd1">Password:</label>
            <input type="password" placeholder="*********" name="osPasswd1" maxlength="40" />
        </div>
        
        <div class="form-group">
            <label for="osPasswd">Password wiederholung:</label>
            <input type="password" placeholder="*********" name="osPasswd" maxlength="40" />
        </div>
        
<!-- todo: AntispamID sollte gegen E-Mail Freischaltcode ausgetauscht werden oder wahlweise über config auswählbar gemacht werden. -->
        <div class="form-group">
            <label for="osPasswd">AntispamID bitte ohne leerzeichen kopieren: <?php echo $oscaptchaid; ?> : Ende</label>
            <input type="text" placeholder="AntispamID bitte hier einfügen" name="oscaptcha" maxlength="36" />
        </div>

        <div class="form-group">
            <input type="submit" name="submit" value="Registration">
        </div>
    </form>

    <?php endif ?>

</main>

<?php
// Salt erstellen
function ospswdsalt() {
    global $benutzeruuid;
    $randomuuid = $benutzeruuid;
    $strrep = str_replace("-", "", $randomuuid);
    return md5($strrep);
}

// Md5Hash(password) + ":" + passwordSalt
function ospswdhash($osPasswd, $osSalt) {
    return md5(md5($osPasswd) . ":" . $osSalt);
}

if (isset($_POST['postname']) && $_POST['postname'] == 1) {    
 
    // wir schaffen unsere Variablen und alle Leerzeichen beiläufig entfernen
    $benutzeruuid = uuidv4();
    $inventoryuuid = uuidv4();
    $neuparentFolderID = uuidv4();
    $neuHauptFolderID = uuidv4();
    $oscaptchaid = $_POST['oscaptchaid'];

    $osVorname = trim($_POST['osVorname']);
    $osNachname = trim($_POST['osNachname']);
    $osEMail = trim($_POST['osEMail']);

    $osDatum = time();    
    $osPasswd = trim($_POST['osPasswd']);
    $osPasswd1 = trim($_POST['osPasswd1']);
    $oscaptcha = trim($_POST['oscaptcha']);

    $osSalt = ospswdsalt();
    $osHash = ospswdhash($osPasswd, $osSalt);

    // Programmabbruch bei fehlenden Angaben
    if (empty($osVorname)) {
        echo 'Vorname nicht mit einem Wert belegt, oder nicht gesetzt<br>';
        exit;
    }
    if (empty($osNachname)) {
        echo 'Nachname nicht mit einem Wert belegt, oder nicht gesetzt<br>';
        exit;
    }
    if (empty($osEMail)) {
        echo 'E-Mail nicht mit einem Wert belegt, oder nicht gesetzt<br>';
        exit;
    }
    if (empty($osPasswd)) {
        echo 'Passwort oder Passwortwiederholung nicht mit einem Wert belegt, oder nicht gesetzt<br>';
        exit;
    }
    if (empty($osPasswd1)) {
        echo 'Passwort oder Passwortwiederholung nicht mit einem Wert belegt, oder nicht gesetzt<br>';
        exit;
    }
    if ($osPasswd != $osPasswd1) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        exit;
    }
    if ($oscaptcha != $oscaptchaid) {
        echo 'Captcha Fehler: ' . $oscaptcha . '   Richtig wäre: ' . $oscaptchaid;
        exit;
    }

    // Datenbank öffnen
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Avatar und Namen checken
    if (!$error) {
        $statement = $pdo->prepare("SELECT * FROM UserAccounts WHERE FirstName = :FirstName AND LastName = :LastName");
        $result = $statement->execute(array('FirstName' => $osVorname, 'LastName' => $osNachname));
        $user = $statement->fetch();
        if ($user !== false) {
            echo 'Der Name ist bereits vergeben<br>';
            exit;
        }
    }

    // E-Mail checken
    if (!filter_var($osEMail, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        exit;
    }
    // Überprüfe, ob die E-Mail-Adresse noch nicht registriert wurde
    if (!$error) {
        $statement = $pdo->prepare("SELECT * FROM UserAccounts WHERE Email = :Email");
        $result = $statement->execute(array('Email' => $osEMail));
        $user = $statement->fetch();
        if ($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            exit;
        }
    }

    // Die Datenbank zugriffe sind in der Datei createavatarfunc.php
    include_once("include/createavatarfunc.php");

    // Avatar Fertig Verbindung schließen
    $pdo = null;
}
?>
</body>
</html>
<?php include_once 'include/footer.php'; ?>
