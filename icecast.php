<?php
$title = "Media";
include_once 'include/header.php';
?>

<style>
htmlBody {font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;} 
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
    <p>All information related to the Media can be found here.</p>
    <p>libshout Release 2.4.6</p>

    <div id="mediaplayer">
        <audio id="audioPlayer" src="http://localhost:8500/stream" controls></audio>
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

// Function to fetch and display metadata
function fetchMetadata() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://localhost:8500/status-json.xsl', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText);
            var metadata = data.icestats.source.title || 'No metadata available';
            document.getElementById('metadata').innerText = 'Now Playing: ' + metadata;
        }
    };
    xhr.send();
}

// Fetch metadata every 10 seconds
setInterval(fetchMetadata, 10000);
fetchMetadata(); // Initial fetch
</script>

<?php include_once 'include/footer.php'; ?>
