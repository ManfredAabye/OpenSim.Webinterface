<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: <?php echo FONT_FAMILY; ?>;
            background-color: <?php echo SECONDARY_COLOR; ?>;
            color: <?php echo PRIMARY_COLOR; ?>;
            background-image: url(<?php echo BACKGROUND_IMAGE; ?>);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            width: 100vw;
            opacity: <?php echo defined('BACKGROUND_OPACITY') ? BACKGROUND_OPACITY : 1; ?>;
        }
        header {
            background-color: <?php echo HEADER_COLOR; ?>;
            padding: 10px;
            text-align: center;
            color: white;
        }
        footer {
            background-color: <?php echo FOOTER_COLOR; ?>;
            padding: 10px;
            text-align: center;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
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
    </style>
</head>
<body>
<header>
    <h1>Welcome to Our Grid</h1>
</header>
