<?php
// MySQL Verbindungsdaten
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'your_username');
define('DB_PASSWORD', 'your_password');
define('DB_NAME', 'your_database');

// Seitenadressen
define('BASE_URL', 'http://yourdomain.com');
define('SITE_NAME', 'Dein Grid Name');

// ACHTUNG!!! Bitte folgende Passwörter unbedingt austauschen!
// Define the list of admin-provided registration passwords
$registration_passwords_register = ["rUKBGMhZghjPEwps454", "bXWfgdfgCwbjDCE6Z", "rksYwereraHJfkFvavLE"];
// List of valid registration passwords for password reset
$registration_passwords_reset = ["aTzWGY8ddfggdH4jNxC9", "nrUFDfxrtrtZGP8NBj8", "YMXkhjkhNg2eWXVNqp"];
// List of valid registration passwords for partner
$registration_passwords_partner = ["enqkUfghfgNawDec6pU", "9ETrW2ertertkgcr6bS", "JaJccasdasddfTxzFUTjWy"];

// Weitere Seitenadressen
define('WELCOME_PAGE', BASE_URL . '/welcomesplashpage.php');
define('ECONOMY_PAGE', BASE_URL . '/economycashbook.php');
define('ABOUT_PAGE', BASE_URL . '/aboutinformation.php');
define('REGISTER_PAGE', BASE_URL . '/registeruser.php');
define('HELP_PAGE', BASE_URL . '/help.php');
define('PASSWORD_PAGE', BASE_URL . '/passwordreset.php');
define('AVATAR_PAGE', BASE_URL . '/avatarpicker.php');
define('GRIDSTATUS_PAGE', BASE_URL . '/gridstatus.php');
define('GRIDSTATUSRSS_PAGE', BASE_URL . '/gridstatusrss.php');
define('GUIDE_PAGE', BASE_URL . '/guide.php');
define('MAPTILE_PAGE', BASE_URL . '/maptile.php');
define('PARTNER_PAGE', BASE_URL . '/partner.php');
define('SEARCHSERVICE_PAGE', BASE_URL . '/searchservice.php');

// Color Scheme:
// Green
// #008453 #FFC1FF #ECF6FF
// Red
// #008453 #FFC1FF #ECF6FF
// OlivBlack
// #141309 #ffffff #f4c00c
// PastelPink
// #fdc5f6 #15ffbc #0e1017
// LimonGreen
// #86C232 #474b4f #222629 #ffffff
// Beige
// #FDF5DF #5EBEC4 #F92C85
// Orange
// #FF6C28 #C29282 #1F1F21 #ffffff
// RedWine
// #CF1C18 #0A0A0A #FBFBFB
// HdOrange
// #FFAB00 #DD2E18 #ffffff #000000
// SteelBlue
// #151923 #202833 #66FCF1 #45A29F
// Kobald
// 0C44E3 #BD8886 #ffffff

// Color Schemes
$colorSchemes = [
    'green' => ['#008453', '#FFC1FF', '#ECF6FF'],
    'red' => ['#FF0000', '#FFC1FF', '#ECF6FF'],
    'oliveBlack' => ['#141309', '#ffffff', '#f4c00c'],
    'pastelPink' => ['#fdc5f6', '#15ffbc', '#0e1017'],
    'limonGreen' => ['#86C232', '#474b4f', '#222629', '#ffffff'],
    'beige' => ['#FDF5DF', '#5EBEC4', '#F92C85'],
    'orange' => ['#FF6C28', '#C29282', '#1F1F21', '#ffffff'],
    'redWine' => ['#CF1C18', '#0A0A0A', '#FBFBFB'],
    'hdOrange' => ['#FFAB00', '#DD2E18', '#ffffff', '#000000'],
    'steelBlue' => ['#151923', '#202833', '#66FCF1', '#45A29F'],
    'kobald' => ['#0C44E3', '#BD8886', '#ffffff']
];

// Wählen Sie das Farbschema, das Sie verwenden möchten
$currentColorScheme = $colorSchemes['oliveBlack']; // Beispiel: Grün

// Farben und Schriftart
define('HEADER_COLOR', $currentColorScheme[0]); // Farbe des Headers
define('FOOTER_COLOR', $currentColorScheme[0]); // Farbe des Footers
define('SECONDARY_COLOR', $currentColorScheme[1]); // Hintergrundfarbe
define('PRIMARY_COLOR', $currentColorScheme[2]); // Allgemeine Schriftfarbe
define('FONT_FAMILY_STATS', 'Arial, Verdana, sans-serif');
define('FONT_FAMILY', 'Pacifico, normal, serif');

// Schriftgrößen
define('BASE_FONT_SIZE', '26px'); // Standardgröße für Text
define('TITLE_FONT_SIZE', '48px'); // Größe für Überschriften
define('STATS_FONT_SIZE', '14px'); // Größe für Statistik-Text

// Links
define('LINK_COLOR', '#3A3A3A'); // Standard Link-Farbe
define('LINK_HOVER_COLOR', 'red'); // Link-Farbe beim Hover

// Hintergrund- und Vordergrundbilder
define('BACKGROUND_IMAGE', 'pics/transparent.png'); // Hintergrundbild
define('FOREGROUND_IMAGE', 'pics/transparent.png'); // Logo oder Vordergrundbild
define('BACKGROUND_OPACITY', 1.0); // Transparenz des Hintergrunds
define('FOREGROUND_OPACITY', 1.0); // Transparenz des Logos

// Anzeigeoptionen
define('LOGO_ON', 'OFF'); // Logo anzeigen: ON / OFF
define('TEXT_ON', 'ON'); // Begrüßungstext anzeigen: ON / OFF
define('LOGO_PATH', 'include/Metavers150.png'); // Pfad zum Logo
define('LOGO_WIDTH', '50%'); // Logo-Breite
define('LOGO_HEIGHT', '25%'); // Logo-Höhe

// Begrüßungstext
define('PRIMARY_COLOR_LOGO', '#FFFFFF'); // Allgemeine Schriftfarbe Schwarz
define('WELCOME_TEXT', '<p> &nbsp; Willkommen im ' . SITE_NAME . '</p>');
define('WELCOME_TEXT_WIDTH', '50%');  // Standardbreite (z. B. 50%)
define('WELCOME_TEXT_HEIGHT', 'auto');  // Standardhöhe (auto für flexible Höhe)
define('WELCOME_TEXT_COLOR', PRIMARY_COLOR);  // Farbe des Textes
define('WELCOME_TEXT_ALIGN', 'left');  // Zentriert, links oder rechts
define('WELCOME_TEXT_FONT_SIZE', '24px');  // Schriftgröße des Textes

// Bildanzeige-Einstellungen
define('SLIDESHOW_FOLDER', './images'); // Verzeichnis für die Bilder
define('IMAGE_SIZE', 'width:100%;height:100%'); // Größe der Bilder (100% für Vollbild)
define('SLIDESHOW_DELAY', 9000); // Zeit zwischen Bildern (in ms, 9000 = 9 Sekunden)

// Einstellungen für Maptiles
// #0088FF #55C155 #006400 #FF0000
define('FREI_COLOR', '#0088FF'); // Farbe für freie Koordinaten
define('BESCHLAGT_COLOR', '#55C155'); // Farbe für SingleRegion
define('VARREGION_COLOR', '#006400'); // Farbe für VarRegion
define('CENTER_COLOR', '#FF0000'); // Farbe für Zentrum
define('TILE_SIZE', '25px'); // Größe der Farbfelder

// Zentrum des Grids
DEFINE('CONF_CENTER_COORD_X', 5100); // X-KOORDINATE DES ZENTRUMS
DEFINE('CONF_CENTER_COORD_Y', 5100); // Y-KOORDINATE DES ZENTRUMS

DEFINE('MAPS_X', 32);
DEFINE('MAPS_Y', 32);
?>
