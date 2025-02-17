<?php
// define('MEDIA_SERVER', 'http://schwarze-welle.de:7500/stream');
// define('MEDIA_SERVER_STATUS', 'http://schwarze-welle.de:7500/status-json.xsl');

$title = "Media";
include_once 'include/header.php';
$media1 = MEDIA_SERVER;
?>

<style>
html, body {font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;} 
main {width: 50%; margin: 2em auto; padding: 2em; background-color: #ffffff; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);} 
h2 {color: #333;} 
#mediaplayer {display: flex; flex-direction: column; align-items: center;}
#mediaplayer audio {width: 100%; margin-bottom: 10px;}
#mediaplayer button {padding: 5px 20px; background-color: #007BFF; color: #ffffff; border: none; border-radius: 4px; cursor: pointer; margin: 5px;}
#mediaplayer button:hover {background-color: #0056b3;}
#metadata {margin-top: 10px;}
</style>

<main>
    <h2><?php echo SITE_NAME; ?> Media Overview</h2>
    <div id="mediaplayer">
        <audio id="audioPlayer" src='<?php echo $media1; ?>' controls></audio>
        <button onclick="playAudio()">Play</button>
        <button onclick="stopAudio()">Stop</button>
        <div id="metadata">Metadata will be displayed here.</div>
    </div>
</main>

<script>
function playAudio() {
    var audio = document.getElementById("audioPlayer");
    audio.play();
}

function stopAudio() {
    var audio = document.getElementById("audioPlayer");
    audio.pause();
    audio.currentTime = 0;
}

function fetchMetadata() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'getMetadata.php', true); // PHP-Datei aufrufen
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText);
            document.getElementById('metadata').innerText = 'Now Playing: ' + data.title;
        }
    };
    xhr.send();
}

setInterval(fetchMetadata, 10000);
fetchMetadata(); // Initialer Aufruf
</script>

<?php include_once 'include/footer.php'; ?>