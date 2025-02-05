<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Destination Guide</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
            background-color: #b0c4de; /* blue-gray Hintergrund */
            white-space: nowrap; /* Verhindern von Zeilenumbrüchen */
            overflow-x: auto; /* Horizontales Scrollen */
            overflow-y: hidden; /* Verhindern von vertikalem Scrollen */
            height: 225px; /* Begrenze Höhe auf 180 Pixel */
        }
        h1 {
            font-size: 12px; /* Kleinere Schriftgröße */
            text-align: center;
            white-space: normal; /* Erlaubt Zeilenumbrüche für die Überschrift */
        }
        .card {
            display: inline-block; /* Karten nebeneinander anordnen */
            vertical-align: top;
            margin-right: 20px; /* Abstand zwischen den Karten */
            width: 150px; /* Feste Breite für jede Karte */
            height: 150px; /* Feste Höhe für jede Karte */
            box-sizing: border-box;
        }
        .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }
        .card img {
            width: 100%; /* Bild passt sich der Breite des Containers an */
            height: 100%;
        }
        .card a {
            text-decoration: none;
            color: #0066cc;
        }
        .card h3 {
            font-size: 10px; /* Kleinere Schriftgröße */
        }
        .card p {
            font-size: 8px; /* Kleinere Textgröße */
        }
        .container {
        padding: 2px 16px;
        }
    </style>
</head>
<body>
    <?php
    // Lese die JSON-Datei ein
    $json = file_get_contents('include/destinations.json');
    $data = json_decode($json, true);

    // Durchlaufe die Kategorien und Ziele
    foreach ($data as $category => $destinations) {
        foreach ($destinations as $destination) {
            echo '<div class="card">';
            echo '<h3>' . $destination['name'] . '</h3>';
            echo '<a href="' . $destination['url'] . '">';
            echo '<img src="' . $destination['image'] . '" alt="' . $destination['name'] . '">';
            echo '</a>';
            echo '</div>';
        }
    }
    ?>
</body>
</html>
