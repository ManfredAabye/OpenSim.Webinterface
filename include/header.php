<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: <?php echo FONT_FAMILY; ?>;
            background-color: var(--secondary-color);
            color: var(--primary-color);
            background-image: url(<?php echo BACKGROUND_IMAGE; ?>);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            width: 100vw;
            opacity: <?php echo defined('BACKGROUND_OPACITY') ? BACKGROUND_OPACITY : 1; ?>;
        }
        header {
            background-color: var(--header-color);
            padding: 10px;
            text-align: center;
            color: white;
        }
        footer {
            background-color: var(--footer-color);
            margin: 0;
            padding: 0;
            text-align: center;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
            line-height: 0;
        }
        nav a {
            margin: 0 10px;
            color: white;
            text-decoration: none;
        }
        .container {
            background-image: url(<?php echo FOREGROUND_IMAGE; ?>);
            background-size: 50%;
            background-repeat: no-repeat;
            background-position: center;
            padding: 20px;
            border-radius: 8px;
            opacity: <?php echo defined('FOREGROUND_OPACITY') ? FOREGROUND_OPACITY : 1; ?>;
        }
        .color-button {
            margin: 1px;
            padding: 1px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 10px;
            color: white;
        }
    </style>
    <script>
        const colorSchemes = {
            oceanBreeze: {header: '#2E8BC0', footer: '#2E8BC0', secondary: '#B1D4E0', primary: '#3B3B98'},
            sunsetGlow: {header: '#FF6F61', footer: '#FF6F61', secondary: '#FFD54F', primary: '#2C3E50'},
            forestHaven: {header: '#2F5233', footer: '#2F5233', secondary: '#A4DE02', primary: '#FFAE03'},
            lavenderBliss: {header: '#6A0572', footer: '#6A0572', secondary: '#D2B4DE', primary: '#F5B7B1'},
            fierySunset: {header: '#D32F2F', footer: '#D32F2F', secondary: '#FFCDD2', primary: '#B71C1C'},
            coolMint: {header: '#009688', footer: '#009688', secondary: '#B2DFDB', primary: '#004D40'},
            royalBlue: {header: '#3F51B5', footer: '#3F51B5', secondary: '#C5CAE9', primary: '#1A237E'},
            autumnHarvest: {header: '#8D6E63', footer: '#8D6E63', secondary: '#FFCCBC', primary: '#3E2723'},
            goldenHour: {header: '#FFEB3B', footer: '#FFEB3B', secondary: '#FFF9C4', primary: '#FBC02D'},
            mintChocolate: {header: '#4CAF50', footer: '#4CAF50', secondary: '#CDDC39', primary: '#795548'},
            berryBurst: {header: '#E91E63', footer: '#E91E63', secondary: '#F8BBD0', primary: '#880E4F'},
            midnightBlue: {header: '#0D47A1', footer: '#0D47A1', secondary: '#BBDEFB', primary: '#1E88E5'},
            grayscale1: {header: '#333333', footer: '#333333', secondary: '#666666', primary: '#E0E0E0'},
            grayscale2: {header: '#4F4F4F', footer: '#4F4F4F', secondary: '#A0A0A0', primary: '#FFFFFF'},
            grayscale3: {header: '#2B2B2B', footer: '#2B2B2B', secondary: '#858585', primary: '#D9D9D9'}
        };

        function setColorScheme(scheme) {
            document.documentElement.style.setProperty('--header-color', colorSchemes[scheme].header);
            document.documentElement.style.setProperty('--footer-color', colorSchemes[scheme].footer);
            document.documentElement.style.setProperty('--secondary-color', colorSchemes[scheme].secondary);
            document.documentElement.style.setProperty('--primary-color', colorSchemes[scheme].primary);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.color-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    setColorScheme(this.dataset.scheme);
                });
            });
            // Set the initial color scheme
            setColorScheme('grayscale2');
        });
    </script>
</head>
<body>
<header>
    <h1>Welcome to <?php echo SITE_NAME; ?></h1>
</header>
<nav>
    <div>
        <button class="color-button" data-scheme="oceanBreeze" style="background-color: #2E8BC0;">Ocean Breeze</button>
        <button class="color-button" data-scheme="sunsetGlow" style="background-color: #FF6F61;">Sunset Glow</button>
        <button class="color-button" data-scheme="forestHaven" style="background-color: #2F5233;">Forest Haven</button>
        <button class="color-button" data-scheme="lavenderBliss" style="background-color: #6A0572;">Lavender Bliss</button>
        <button class="color-button" data-scheme="fierySunset" style="background-color: #D32F2F;">Fiery Sunset</button>
        <button class="color-button" data-scheme="coolMint" style="background-color: #009688;">Cool Mint</button>
        <button class="color-button" data-scheme="royalBlue" style="background-color: #3F51B5;">Royal Blue</button>
        <button class="color-button" data-scheme="autumnHarvest" style="background-color: #8D6E63;">Autumn Harvest</button>
        <button class="color-button" data-scheme="goldenHour" style="background-color: #FFEB3B;">Golden Hour</button>
        <button class="color-button" data-scheme="mintChocolate" style="background-color: #4CAF50;">Mint Chocolate</button>
        <button class="color-button" data-scheme="berryBurst" style="background-color: #E91E63;">Berry Burst</button>
        <button class="color-button" data-scheme="midnightBlue" style="background-color: #0D47A1;">Midnight Blue</button>
        <button class="color-button" data-scheme="grayscale1" style="background-color: #333333;">Graustufen 1</button>
        <button class="color-button" data-scheme="grayscale2" style="background-color: #4F4F4F;">Graustufen 2</button>
        <button class="color-button" data-scheme="grayscale3" style="background-color: #2B2B2B;">Graustufen 3</button>
    </div>
</nav>
<div class="container">
    <!-- Inhalt der Seite -->
</div>

</body>
</html>
