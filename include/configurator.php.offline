<?php
$title = "Configurator";
include_once 'header.php';

// Überprüfen, ob config.php existiert, falls nicht, config.example.php kopieren
if (!file_exists('config.php')) {
    if (file_exists('config.example.php')) {
        copy('config.example.php', 'config.php');
    } else {
        die("Fehler: Weder config.php noch config.example.php gefunden!");
    }
}

// Überprüfen, ob das Formular abgeschickt wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Daten aus dem Formular holen
    $db_server = $_POST['db_server'];
    $db_username = $_POST['db_username'];
    $db_password = $_POST['db_password'];
    $db_name = $_POST['db_name'];
    $db_name = $_POST['db_asset_name'];
    $base_url = $_POST['base_url'];
    $site_name = $_POST['site_name'];
    $initial_color_scheme = $_POST['initial_color_scheme'];
    $show_color_buttons = isset($_POST['show_color_buttons']) ? 'true' : 'false';
    $conf_center_coord_x = $_POST['conf_center_coord_x'];
    $conf_center_coord_y = $_POST['conf_center_coord_y'];
    $font_family_stats = $_POST['font_family_stats'];
    $font_family = $_POST['font_family'];
    $base_font_size = $_POST['base_font_size'];
    $title_font_size = $_POST['title_font_size'];
    $stats_font_size = $_POST['stats_font_size'];
    $link_color = $_POST['link_color'];
    $link_hover_color = $_POST['link_hover_color'];
    $background_image = $_POST['background_image'];
    $foreground_image = $_POST['foreground_image'];
    $background_opacity = $_POST['background_opacity'];
    $foreground_opacity = $_POST['foreground_opacity'];
    $logo_on = $_POST['logo_on'];
    $text_on = $_POST['text_on'];
    $logo_path = $_POST['logo_path'];
    $logo_width = $_POST['logo_width'];
    $logo_height = $_POST['logo_height'];
    $primary_color_logo = $_POST['primary_color_logo'];
    $welcome_text = $_POST['welcome_text'];
    $welcome_text_width = $_POST['welcome_text_width'];
    $welcome_text_height = $_POST['welcome_text_height'];
    $welcome_text_color = $_POST['welcome_text_color'];
    $welcome_text_align = $_POST['welcome_text_align'];
    $welcome_text_font_size = $_POST['welcome_text_font_size'];
    $slideshow_folder = $_POST['slideshow_folder'];
    $image_size = $_POST['image_size'];
    $slideshow_delay = $_POST['slideshow_delay'];
    $frei_color = $_POST['frei_color'];
    $beschlagt_color = $_POST['beschlagt_color'];
    $varregion_color = $_POST['varregion_color'];
    $center_color = $_POST['center_color'];
    $tile_size = $_POST['tile_size'];
    $maps_x = $_POST['maps_x'];
    $maps_y = $_POST['maps_y'];

    // Sicherungskopie der aktuellen config.php erstellen
    $backup_filename = 'config_backup_' . date('Y-m-d_H-i-s') . '.php';
    if (!copy('config.php', $backup_filename)) {
        die("Fehler: Sicherungskopie konnte nicht erstellt werden!");
    }

    // Konfigurationsdatei aktualisieren
    $config_content = "<?php\n";
    $config_content .= "// MySQL Verbindungsdaten\n";
    $config_content .= "define('DB_SERVER', '$db_server');\n";
    $config_content .= "define('DB_USERNAME', '$db_username');\n";
    $config_content .= "define('DB_PASSWORD', '$db_password');\n";
    $config_content .= "define('DB_NAME', '$db_name');\n\n";
    $config_content .= "define('DB_ASSET_NAME', '$db_name');\n\n";
    $config_content .= "// Seitenadressen\n";
    $config_content .= "define('BASE_URL', '$base_url');\n";
    $config_content .= "define('SITE_NAME', '$site_name');\n\n";
    $config_content .= "// Farbschema\n";
    $config_content .= "define('SHOW_COLOR_BUTTONS', $show_color_buttons);\n";
    $config_content .= "define('INITIAL_COLOR_SCHEME', '$initial_color_scheme');\n\n";
    $config_content .= "// Farben und Schriftart\n";
    $config_content .= "define('FONT_FAMILY_STATS', '$font_family_stats');\n";
    $config_content .= "define('FONT_FAMILY', '$font_family');\n\n";
    $config_content .= "// Schriftgrößen\n";
    $config_content .= "define('BASE_FONT_SIZE', '$base_font_size');\n";
    $config_content .= "define('TITLE_FONT_SIZE', '$title_font_size');\n";
    $config_content .= "define('STATS_FONT_SIZE', '$stats_font_size');\n\n";
    $config_content .= "// Links\n";
    $config_content .= "define('LINK_COLOR', '$link_color');\n";
    $config_content .= "define('LINK_HOVER_COLOR', '$link_hover_color');\n\n";
    $config_content .= "// Hintergrund- und Vordergrundbilder\n";
    $config_content .= "define('BACKGROUND_IMAGE', '$background_image');\n";
    $config_content .= "define('FOREGROUND_IMAGE', '$foreground_image');\n";
    $config_content .= "define('BACKGROUND_OPACITY', $background_opacity);\n";
    $config_content .= "define('FOREGROUND_OPACITY', $foreground_opacity);\n\n";
    $config_content .= "// Anzeigeoptionen\n";
    $config_content .= "define('LOGO_ON', '$logo_on');\n";
    $config_content .= "define('TEXT_ON', '$text_on');\n";
    $config_content .= "define('LOGO_PATH', '$logo_path');\n";
    $config_content .= "define('LOGO_WIDTH', '$logo_width');\n";
    $config_content .= "define('LOGO_HEIGHT', '$logo_height');\n\n";
    $config_content .= "// Begrüßungstext\n";
    $config_content .= "define('PRIMARY_COLOR_LOGO', '$primary_color_logo');\n";
    $config_content .= "define('WELCOME_TEXT', '$welcome_text');\n";
    $config_content .= "define('WELCOME_TEXT_WIDTH', '$welcome_text_width');\n";
    $config_content .= "define('WELCOME_TEXT_HEIGHT', '$welcome_text_height');\n";
    $config_content .= "define('WELCOME_TEXT_COLOR', '$welcome_text_color');\n";
    $config_content .= "define('WELCOME_TEXT_ALIGN', '$welcome_text_align');\n";
    $config_content .= "define('WELCOME_TEXT_FONT_SIZE', '$welcome_text_font_size');\n\n";
    $config_content .= "// Bildanzeige-Einstellungen\n";
    $config_content .= "define('SLIDESHOW_FOLDER', '$slideshow_folder');\n";
    $config_content .= "define('IMAGE_SIZE', '$image_size');\n";
    $config_content .= "define('SLIDESHOW_DELAY', $slideshow_delay);\n\n";
    $config_content .= "// Einstellungen für Maptiles\n";
    $config_content .= "define('FREI_COLOR', '$frei_color');\n";
    $config_content .= "define('BESCHLAGT_COLOR', '$beschlagt_color');\n";
    $config_content .= "define('VARREGION_COLOR', '$varregion_color');\n";
    $config_content .= "define('CENTER_COLOR', '$center_color');\n";
    $config_content .= "define('TILE_SIZE', '$tile_size');\n\n";
    $config_content .= "// Zentrum des Grids\n";
    $config_content .= "define('CONF_CENTER_COORD_X', $conf_center_coord_x);\n";
    $config_content .= "define('CONF_CENTER_COORD_Y', $conf_center_coord_y);\n\n";
    $config_content .= "// Weitere Einstellungen\n";
    $config_content .= "define('MAPS_X', $maps_x);\n";
    $config_content .= "define('MAPS_Y', $maps_y);\n\n";
    $config_content .= "?>";

    // Konfigurationsdatei speichern
    if (file_put_contents('config.php', $config_content) === false) {
        die("Fehler: Konfigurationsdatei konnte nicht gespeichert werden!");
    }

    echo "<p>Konfiguration erfolgreich gespeichert! Eine Sicherungskopie wurde als $backup_filename erstellt.</p>";
}

// Aktuelle Konfiguration auslesen
include 'config.php';
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        color: black;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .containerconfig {
        display: flex;
        flex-direction: column;
    }

    .form-container {
        background-color: #fff;
        color: black;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        width: 100%;
    }

    header, footer {
        flex-shrink: 0;
    }

    main {
        flex-grow: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="password"],
    input[type="number"],
    select,
    textarea {
        width: calc(100% - 20px);
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="checkbox"] {
        margin-bottom: 15px;
    }

    .button {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 12px 24px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button:hover {
        background-color: #0056b3;
    }

    .button-secondary {
        background-color: #6c757d;
    }

    .button-secondary:hover {
        background-color: #5a6268;
    }

    .button-success {
        background-color: #28a745;
    }

    .button-success:hover {
        background-color: #218838;
    }

    .button-danger {
        background-color: #dc3545;
    }

    .button-danger:hover {
        background-color: #c82333;
    }
</style>

<div class="containerconfig">
    <main>
        <div class="form-container">
            <h2><?php echo SITE_NAME; ?> Configurator Overview</h2>
            <p>All information related to the Configurator can be found here.</p>

            <form method="post">
                <h3>Datenbank-Einstellungen</h3>
                <label for="db_server">DB Server:</label>
                <input type="text" id="db_server" name="db_server" value="<?php echo DB_SERVER; ?>" required>

                <label for="db_username">DB Benutzername:</label>
                <input type="text" id="db_username" name="db_username" value="<?php echo DB_USERNAME; ?>" required>

                <label for="db_password">DB Passwort:</label>
                <input type="password" id="db_password" name="db_password" value="<?php echo DB_PASSWORD; ?>" required>

                <label for="db_name">DB Name:</label>
                <input type="text" id="db_name" name="db_name" value="<?php echo DB_NAME; ?>" required>

                <label for="db_asset_name">DB Asset Name:</label>
                <input type="text" id="db_asset_name" name="db_asset_name" value="<?php echo DB_ASSET_NAME; ?>" required>

                <h3>Seiten-Einstellungen</h3>
                <label for="base_url">Base URL:</label>
                <input type="text" id="base_url" name="base_url" value="<?php echo BASE_URL; ?>" required>

                <label for="site_name">Site Name:</label>
                <input type="text" id="site_name" name="site_name" value="<?php echo SITE_NAME; ?>" required>

                <h3>Farbschema</h3>
                <label for="initial_color_scheme">Initiales Farbschema:</label>
                <select id="initial_color_scheme" name="initial_color_scheme">
                    <?php foreach ($colorSchemes as $key => $value): ?>
                        <option value="<?php echo $key; ?>" <?php echo $key === INITIAL_COLOR_SCHEME ? 'selected' : ''; ?>><?php echo $key; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="show_color_buttons">Farbschaltflächen anzeigen:</label>
                <input type="checkbox" id="show_color_buttons" name="show_color_buttons" <?php echo SHOW_COLOR_BUTTONS === 'true' ? 'checked' : ''; ?>>

                <h3>Schriftart und Schriftgrößen</h3>
                <label for="font_family_stats">Schriftart für Statistiken:</label>
                <input type="text" id="font_family_stats" name="font_family_stats" value="<?php echo FONT_FAMILY_STATS; ?>" required>

                <label for="font_family">Schriftart:</label>
                <input type="text" id="font_family" name="font_family" value="<?php echo FONT_FAMILY; ?>" required>

                <label for="base_font_size">Standard-Schriftgröße:</label>
                <input type="text" id="base_font_size" name="base_font_size" value="<?php echo BASE_FONT_SIZE; ?>" required>

                <label for="title_font_size">Schriftgröße für Überschriften:</label>
                <input type="text" id="title_font_size" name="title_font_size" value="<?php echo TITLE_FONT_SIZE; ?>" required>

                <label for="stats_font_size">Schriftgröße für Statistiken:</label>
                <input type="text" id="stats_font_size" name="stats_font_size" value="<?php echo STATS_FONT_SIZE; ?>" required>

                <h3>Links</h3>
                <label for="link_color">Standard-Link-Farbe:</label>
                <input type="text" id="link_color" name="link_color" value="<?php echo LINK_COLOR; ?>" required>

                <label for="link_hover_color">Link-Farbe beim Hover:</label>
                <input type="text" id="link_hover_color" name="link_hover_color" value="<?php echo LINK_HOVER_COLOR; ?>" required>

                <h3>Hintergrund- und Vordergrundbilder</h3>
                <label for="background_image">Hintergrundbild:</label>
                <input type="text" id="background_image" name="background_image" value="<?php echo BACKGROUND_IMAGE; ?>" required>

                <label for="foreground_image">Vordergrundbild:</label>
                <input type="text" id="foreground_image" name="foreground_image" value="<?php echo FOREGROUND_IMAGE; ?>" required>

                <label for="background_opacity">Hintergrund-Transparenz:</label>
                <input type="number" step="0.1" id="background_opacity" name="background_opacity" value="<?php echo BACKGROUND_OPACITY; ?>" required>

                <label for="foreground_opacity">Vordergrund-Transparenz:</label>
                <input type="number" step="0.1" id="foreground_opacity" name="foreground_opacity" value="<?php echo FOREGROUND_OPACITY; ?>" required>

                <h3>Anzeigeoptionen</h3>
                <label for="logo_on">Logo anzeigen:</label>
                <select id="logo_on" name="logo_on">
                    <option value="ON" <?php echo LOGO_ON === 'ON' ? 'selected' : ''; ?>>ON</option>
                    <option value="OFF" <?php echo LOGO_ON === 'OFF' ? 'selected' : ''; ?>>OFF</option>
                </select>

                <label for="text_on">Begrüßungstext anzeigen:</label>
                <select id="text_on" name="text_on">
                    <option value="ON" <?php echo TEXT_ON === 'ON' ? 'selected' : ''; ?>>ON</option>
                    <option value="OFF" <?php echo TEXT_ON === 'OFF' ? 'selected' : ''; ?>>OFF</option>
                </select>

                <label for="logo_path">Pfad zum Logo:</label>
                <input type="text" id="logo_path" name="logo_path" value="<?php echo LOGO_PATH; ?>" required>

                <label for="logo_width">Logo-Breite:</label>
                <input type="text" id="logo_width" name="logo_width" value="<?php echo LOGO_WIDTH; ?>" required>

                <label for="logo_height">Logo-Höhe:</label>
                <input type="text" id="logo_height" name="logo_height" value="<?php echo LOGO_HEIGHT; ?>" required>

                <h3>Begrüßungstext</h3>
                <label for="primary_color_logo">Schriftfarbe für Logo:</label>
                <input type="text" id="primary_color_logo" name="primary_color_logo" value="<?php echo PRIMARY_COLOR_LOGO; ?>" required>

                <label for="welcome_text">Begrüßungstext:</label>
                <textarea id="welcome_text" name="welcome_text" required><?php echo WELCOME_TEXT; ?></textarea>

                <label for="welcome_text_width">Breite des Begrüßungstexts:</label>
                <input type="text" id="welcome_text_width" name="welcome_text_width" value="<?php echo WELCOME_TEXT_WIDTH; ?>" required>

                <label for="welcome_text_height">Höhe des Begrüßungstexts:</label>
                <input type="text" id="welcome_text_height" name="welcome_text_height" value="<?php echo WELCOME_TEXT_HEIGHT; ?>" required>

                <label for="welcome_text_color">Farbe des Begrüßungstexts:</label>
                <input type="text" id="welcome_text_color" name="welcome_text_color" value="<?php echo WELCOME_TEXT_COLOR; ?>" required>

                <label for="welcome_text_align">Ausrichtung des Begrüßungstexts:</label>
                <select id="welcome_text_align" name="welcome_text_align">
                    <option value="left" <?php echo WELCOME_TEXT_ALIGN === 'left' ? 'selected' : ''; ?>>Links</option>
                    <option value="center" <?php echo WELCOME_TEXT_ALIGN === 'center' ? 'selected' : ''; ?>>Zentriert</option>
                    <option value="right" <?php echo WELCOME_TEXT_ALIGN === 'right' ? 'selected' : ''; ?>>Rechts</option>
                </select>

                <label for="welcome_text_font_size">Schriftgröße des Begrüßungstexts:</label>
                <input type="text" id="welcome_text_font_size" name="welcome_text_font_size" value="<?php echo WELCOME_TEXT_FONT_SIZE; ?>" required>

                <h3>Bildanzeige-Einstellungen</h3>
                <label for="slideshow_folder">Verzeichnis für die Bilder:</label>
                <input type="text" id="slideshow_folder" name="slideshow_folder" value="<?php echo SLIDESHOW_FOLDER; ?>" required>

                <label for="image_size">Größe der Bilder:</label>
                <input type="text" id="image_size" name="image_size" value="<?php echo IMAGE_SIZE; ?>" required>

                <label for="slideshow_delay">Zeit zwischen Bildern (in ms):</label>
                <input type="number" id="slideshow_delay" name="slideshow_delay" value="<?php echo SLIDESHOW_DELAY; ?>" required>

                <h3>Einstellungen für Maptiles</h3>
                <label for="frei_color">Farbe für freie Koordinaten:</label>
                <input type="text" id="frei_color" name="frei_color" value="<?php echo FREI_COLOR; ?>" required>

                <label for="beschlagt_color">Farbe für SingleRegion:</label>
                <input type="text" id="beschlagt_color" name="beschlagt_color" value="<?php echo BESCHLAGT_COLOR; ?>" required>

                <label for="varregion_color">Farbe für VarRegion:</label>
                <input type="text" id="varregion_color" name="varregion_color" value="<?php echo VARREGION_COLOR; ?>" required>

                <label for="center_color">Farbe für Zentrum:</label>
                <input type="text" id="center_color" name="center_color" value="<?php echo CENTER_COLOR; ?>" required>

                <label for="tile_size">Größe der Farbfelder:</label>
                <input type="text" id="tile_size" name="tile_size" value="<?php echo TILE_SIZE; ?>" required>

                <h3>Zentrum des Grids</h3>
                <label for="conf_center_coord_x">X-Koordinate des Zentrums:</label>
                <input type="number" id="conf_center_coord_x" name="conf_center_coord_x" value="<?php echo CONF_CENTER_COORD_X; ?>" required>

                <label for="conf_center_coord_y">Y-Koordinate des Zentrums:</label>
                <input type="number" id="conf_center_coord_y" name="conf_center_coord_y" value="<?php echo CONF_CENTER_COORD_Y; ?>" required>

                <h3>Weitere Einstellungen</h3>
                <label for="maps_x">Anzahl der Karten in X-Richtung:</label>
                <input type="number" id="maps_x" name="maps_x" value="<?php echo MAPS_X; ?>" required>

                <label for="maps_y">Anzahl der Karten in Y-Richtung:</label>
                <input type="number" id="maps_y" name="maps_y" value="<?php echo MAPS_Y; ?>" required>

                <button type="submit" class="button button-success">Speichern</button>
            </form>
        </div>
    </main>
</div>

<?php include_once 'include/footer.php'; ?>