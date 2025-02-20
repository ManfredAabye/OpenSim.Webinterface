<?php
// offlinemessages.php
$title = "Offline Nachrichten";
include_once "include/header.php"; // Stellt sicher, dass das HTML-Grundgerüst bereits vorhanden ist
include_once "include/config.php";
?>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .message {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fafafa;
    }
    .message b {
        color: #333;
    }
    .status {
        font-weight: bold;
        margin-bottom: 20px;
    }
    .status.online {
        color: green;
    }
    .status.offline {
        color: red;
    }
</style>

<div class="container">
    <h1><?php echo $title; ?></h1>
    <?php
    $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$con) {
        echo "<div class='status offline'>❌ Datenbankverbindung fehlgeschlagen</div>";
    } else {
        // Abfrage der Offline-Nachrichten
        $sql = "SELECT * FROM im_offline ORDER BY TMStamp DESC";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $messageXml = $row['Message'];
                $timestamp = $row['TMStamp'];

                // XML mit SimpleXML parsen
                try {
                    $xml = new SimpleXMLElement($messageXml);

                    // Extrahieren der relevanten Daten
                    $fromAgentName = htmlspecialchars((string)$xml->fromAgentName);
                    $messageText = htmlspecialchars((string)$xml->message);
                    $timestampFormatted = date("d.m.Y H:i:s", strtotime($timestamp));

                    // Nachricht anzeigen
                    echo "<div class='message'>";
                    echo "<b>Von:</b> $fromAgentName<br>";
                    echo "<b>Nachricht:</b> $messageText<br>";
                    echo "<b>Datum/Uhrzeit:</b> $timestampFormatted<br>";
                    echo "</div>";
                } catch (Exception $e) {
                    echo "<div class='status'>Fehler beim Parsen der Nachricht (ID: {$row['ID']}).</div>";
                }
            }
        } else {
            echo "<div class='status'>Keine Offline-Nachrichten gefunden.</div>";
        }

        mysqli_close($con);
    }
    ?>
</div>

<?php
include_once "include/footer.php"; // Falls ein Footer vorhanden ist
?>