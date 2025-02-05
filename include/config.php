<?php
// MySQL Verbindungsdaten
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'your_username');
define('DB_PASSWORD', 'your_password');
define('DB_NAME', 'your_database');

// Seitenadressen
define('BASE_URL', 'http://yourdomain.com');
define('SITE_NAME', 'Dein Grid Name');
define('WELCOME_PAGE', BASE_URL . '/welcomesplashpage.php');
define('ECONOMY_PAGE', BASE_URL . '/economycashbook.php');
define('ABOUT_PAGE', BASE_URL . '/aboutinformation.php');
define('REGISTER_PAGE', BASE_URL . '/registeruser.php');
define('HELP_PAGE', BASE_URL . '/help.php');
define('PASSWORD_PAGE', BASE_URL . '/passwordreset.php');

// Farben und Schriftart
//define('PRIMARY_COLOR', '#F5F5F5'); // Allgemeine Schriftfarbe Weiss
define('PRIMARY_COLOR', '#000000'); // Allgemeine Schriftfarbe Schwarz
define('SECONDARY_COLOR', '#F5F5F5'); // Hintergrundfarbe
define('HEADER_COLOR', '#00BFFF'); // Farbe des Headers
define('FOOTER_COLOR', '#00BFFF'); // Farbe des Footers
define('FONT_FAMILY', 'Arial, sans-serif');

// Hintergrund- und Vordergrundbilder
//define('BACKGROUND_IMAGE', 'pics/background.jpg'); // Relativer Pfad zum Hintergrundbild
define('BACKGROUND_IMAGE', 'pics/transparent.png'); // Kein Hintergrundbild
//define('FOREGROUND_IMAGE', 'pics/logo.png'); // Relativer Pfad zum Vordergrundbild
define('FOREGROUND_IMAGE', 'pics/transparent.png'); // Kein Vordergrundbild
define('BACKGROUND_OPACITY', 1.0); // Transparenz des Vordergrunds
define('FOREGROUND_OPACITY', 1.0); // Transparenz des Logos
?>
