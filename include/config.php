<?php
// MySQL Verbindungsdaten
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'your_username');
define('DB_PASSWORD', 'your_password');
define('DB_NAME', 'your_database');

// Seitenadressen
define('BASE_URL', 'https://de.pinterest.com');
define('SITE_NAME', 'Metaversum');

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

// Farben und Schriftart
define('PRIMARY_COLOR', '#000000'); // Allgemeine Schriftfarbe Schwarz
define('SECONDARY_COLOR', '#F5F5F5'); // Hintergrundfarbe
define('HEADER_COLOR', '#00BFFF'); // Farbe des Headers
define('FOOTER_COLOR', '#00BFFF'); // Farbe des Footers
define('FONT_FAMILY', 'Arial, Verdana, sans-serif');

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
?>
