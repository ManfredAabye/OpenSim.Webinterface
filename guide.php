<?php
$title = "Guide";
include_once "include/config.php";
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Destination Guide</title>
    <style>
        .guidebody { font-family: Arial, sans-serif; margin: 0; padding: 10px; background-color: #b0c4de; white-space: nowrap; overflow-x: auto; overflow-y: hidden; height: 225px; }
        h1 { font-size: 12px; text-align: center; white-space: normal; }
        .card { display: inline-block; vertical-align: top; margin-right: 20px; width: 150px; height: 150px; box-sizing: border-box; }
        .card:hover { box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2); }
        .card img { width: 100%; height: 100%; }
        .card a { text-decoration: none; color: #0066cc; }
        .card h3 { font-size: 10px; }
        .card p { font-size: 8px; }
        .adventure { background-color: #ffcc99; }
        .culture { background-color: #99ffcc; }
        .nature { background-color: #cc99ff; }
        .container { padding: 2px 16px; }
        .region-container { display: flex; gap: 10px; padding: 10px; }
        .region-link { text-decoration: none; color: #333; background: #ddd; padding: 5px 10px; border-radius: 5px; }
        .region-link:hover { background: #bbb; }
    </style>
</head>
<body class="guidebody">
    <h1>Destination Guide</h1>

    <!-- Regionsliste JSON -->
    <?php
    if (GUIDE_DATA === 'JSON') {
        $json = file_get_contents('include/destinations.json');
        $data = json_decode($json, true);

        foreach ($data as $category => $destinations) {
            foreach ($destinations as $destination) {
                echo '<div class="card ' . htmlspecialchars($category) . '">';
                echo '<h3>' . htmlspecialchars($destination['name']) . '</h3>';
                echo '<a href="' . htmlspecialchars($destination['url']) . '">';
                echo '<img src="' . htmlspecialchars($destination['image']) . '" alt="' . htmlspecialchars($destination['name']) . '">';
                echo '</a>';
                echo '</div>';
            }
        }
    }
    ?>

    <!-- Regionsliste Database -->
    <div id='regionslist' class="guidebody">
        <fieldset>
            <legend>🌍 Regionen</legend>
            <div class="region-container">
                <?php
                $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                $sql = "SELECT regionName, serverIP, serverPort FROM regions ORDER BY last_seen DESC LIMIT 10";
                $resultregions = mysqli_query($con, $sql);

                while ($dsatz = mysqli_fetch_assoc($resultregions)) {
                    $region = htmlspecialchars($dsatz["regionName"]);
                    $ip = htmlspecialchars($dsatz["serverIP"]);
                    $port = htmlspecialchars($dsatz["serverPort"]);
                    $regionslink = "hop://$ip:$port/$region/103/113/23";

                    echo "<a class='region-link' href='$regionslink' target='_blank'>$region</a>";
                }

                mysqli_close($con);
                ?>
            </div>
        </fieldset>
    </div>
</body>
</html>
