<?php
session_start();
$title = "Bilder Service";
include_once 'include/header.php';

function getAsset(string $asset_uuid): string {
    if (empty($asset_uuid) || $asset_uuid === '00000000-0000-0000-0000-000000000000') {
        $bild = ASSET_FEHLT . '.png';
        return is_file($bild) ? file_get_contents($bild) : '';
    }

    $zielFormat = 'png';
    $cachePfadPNG = ASSETPFAD . $asset_uuid . '.' . $zielFormat;
    $cachePfadJP2 = ASSETPFAD . $asset_uuid . '.jp2';

    if (!file_exists($cachePfadJP2) || filesize($cachePfadJP2) === 0 || filemtime($cachePfadJP2) < (time() - 3600)) {
        $asset_url = GRID_ASSETS_SERVER . $asset_uuid;
        $dateiInhalt = @file_get_contents($asset_url, false, stream_context_create(['http' => ['timeout' => 10]]));
        if ($dateiInhalt === false) {
            $bild = ASSET_FEHLT . '.png';
            return is_file($bild) ? file_get_contents($bild) : '';
        }

        try {
            $xml = new SimpleXMLElement($dateiInhalt);
            $daten = base64_decode((string) $xml->Data, true);
            if ($daten === false) {
                $bild = ASSET_FEHLT . '.png';
                return is_file($bild) ? file_get_contents($bild) : '';
            }
        } catch (Exception) {
            $bild = ASSET_FEHLT . '.png';
            return is_file($bild) ? file_get_contents($bild) : '';
        }

        file_put_contents($cachePfadJP2, $daten);
    } else {
        $daten = file_get_contents($cachePfadJP2) ?: '';
    }

    try {
        $_Bild = new Imagick();
        $_Bild->readImageBlob($daten);
        $_Bild->setImageFormat($zielFormat);
        $ausgabe = $_Bild->getImageBlob();
    } catch (ImagickException) {
        $bild = ASSET_FEHLT . '.png';
        return is_file($bild) ? file_get_contents($bild) : '';
    }

    file_put_contents($cachePfadPNG, $ausgabe);
    return $cachePfadPNG; // Pfad zur Bilddatei zurückgeben
}

$bildPfad = ''; // Standardwert für den Bildpfad

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asset_uuid = $_POST['uuid'];
    $passwort = $_POST['passwort'];
    $_SESSION[$asset_uuid] = 'uuid';
    $_SESSION[$passwort] = 'passwort';

    // Passwortüberprüfung
    if (in_array($passwort, $registration_passwords_picreader)) {
        $bildPfad = getAsset($asset_uuid); // Bildpfad basierend auf der eingegebenen UUID
    } else {
        echo 'Ungültiges Passwort!';
    }
}
?>

<style>
    .bodyiar { font-family: Arial, sans-serif; background-color: #f0f0f0; margin: 0; padding: 0; }
    .containeriar { display: flex; flex-direction: column; min-height: 80vh; }
    header, footer { flex-shrink: 0; }
    main { flex-grow: 1; display: flex; justify-content: center; align-items: center; padding: 20px; background-color: #fff; }
    .form-container { background-color: #fff; color: black; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 400px; width: 100%; }
    .image-card { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: center; margin-top: 20px; }
    .image-card img { max-width: 100%; height: auto; border-radius: 8px; }
    .image-card a { display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 4px; }
    .image-card a:hover { background-color: #0056b3; }
    h1 { font-size: 24px; margin-bottom: 20px; text-align: center; }
    label { display: block; margin-bottom: 8px; font-weight: bold; }
    input[type="text"], input[type="password"], input[type="file"] { width: calc(100% - 20px); padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
    input[type="submit"] { width: 100%; padding: 10px; border: none; border-radius: 4px; background-color: #007bff; color: #fff; font-size: 16px; cursor: pointer; margin-bottom: 10px; }
    input[type="submit"]:hover { background-color: #0056b3; }
</style>

<html>
<body>
    <div class="containeriar">
        <main>
            <div class="form-container">
                <h1>Bilder Service</h1>
                <form method="POST" action="picreader.php" enctype="multipart/form-data">
                    <label for="uuid">UUID:</label>
                    <input type="text" id="uuid" name="uuid" required><br>
                    
                    <label for="passwort">Passwort:</label>
                    <input type="password" id="passwort" name="passwort" required><br>
                    
                    <input type="submit" name="submit" value="Bild Anzeigen">
                </form>
                <?php if ($bildPfad) : ?>
                    <div class="image-card">
                        <img src="<?php echo $bildPfad; ?>" alt="Asset Bild">
                        <a href="<?php echo $bildPfad; ?>" download>Bild herunterladen</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
        <?php include_once 'include/footer.php'; ?>
    </div>
</body>
</html>

<?php
// to change a session variable, just overwrite it
?>