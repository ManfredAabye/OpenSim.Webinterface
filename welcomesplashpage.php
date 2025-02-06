<?php
$title = "Welcome";
include 'include/config.php';
//include 'include/header.php';
?>

<?php
//
// Alle weiteren Einstellungen
//
// Logo anzeigen
$logoon = "OFF";
// Text anzeigen
$texton = "ON";
// Logo ladeort
$logo = "include/Metavers150.png";
//$logo = "include/OpenManniLand150V6.png";
// Breite des Logos
$breite = "50%";
// Hoehe des Logos
$hoehe = "25%";
// Anzeigetext - Leerzeichen am Anfang = &nbsp;
//$text = '<p> &nbsp; Willkommen im Metaversum! </p>';
$text = '<p> &nbsp; Willkommen im ' . SITE_NAME . '</p>';
// Zeit zwischen den Bildern 1000 = 1 Sekunde
$ptime = '9000';
// Alle Bilder aus einem Verzeichnis anzeigen
$ordner = "./images";
$bildgroesse = "width:100%;height:100%"; // "width:100%;height:100%" = Vollbilder.
?>

<html>

  <head>
    <meta charset="UTF-8">

<style>
.wspbody {margin: 0px;font-family: Arial, Verdana, sans-serif;font-size: 26px;background: #3A3A3A;}
p {margin: 0px;font-family: Arial, Verdana, sans-serif;color:rgb(189, 185, 173);font-size: 48px;font-weight: bold;}
a {color: #3A3A3A;}
a:hover {color: red;}
#main {width: 100%;height: 100%;position: relative;z-index: 1;}
#stats1 {position: absolute; right: 10px; top: 23px;text-align: left;height: 90px;width: 250px;z-index: 3;}
#stats2 {height:100%;margin: 0;padding: 0;font-family: Arial, Verdana, sans-serif;font-size: 14px;text-align: right;position: absolute;}
fieldset {padding: 10px;border-radius: 8px;-webkit-border-radius: 8px;-moz-border-radius: 8px;}
legend {color: FFF;}
fieldset.grey {padding: 10px;height: 100%;border:3px;}
fieldset.white {padding: 5px;height: 96%;border:3px solid #3A3A3A;}
fieldset.white2 {padding: 5px;height: 96%;border:3px solid #3A3A3A;}

.PictureSlider {  position: absolute;  width: 100%;  height: 100%;  opacity: 0;  transition: opacity 2s ease-in-out;}
.PictureSlider.active {  opacity: 1;}
html, body {  margin: 0;  padding: 0;  overflow: hidden;  width: 100%;  height: 100%;}
#background1 {  position: fixed;  top: 0;  left: 0;  width: 100vw;  height: 100vh;  margin: 0;  padding: 0;}
.PictureSlider {  width: 100vw;  height: 100vh;  object-fit: cover; }
ul {  list-style: none;  padding: 0;  margin: 0;}
</style>

<wspbody>
  <!-- PHP Script fuer alle Bilder aus einem Verzeichnis ANFANG -->
    <?php    
    $allebilder = scandir ( $ordner );
    ?>

  <div id="background1">

    <?php
    foreach ( $allebilder as $bild ) {
      $bildinfo = pathinfo ( $ordner . "/" . $bild );
      if (! ($bild == "." || $bild == ".." || $bild == "_notes" || $bildinfo ['basename'] == "Thumbs.db")) {
        $size = ceil ( filesize ( $ordner . "/" . $bild ) / 1024 );
        // PHP Script fuer alle Bilder aus einem Verzeichnis ENDE -->
        ?>
      <li><div id="background1"><img class="PictureSlider" src="<?php echo $ordner."/".$bild; ?>" style=<?php echo $bildgroesse ?> alt="slide 1" /></div></li><?php
      }
    };
    ?>

  </div>

  <!-- Logo oder Begruessungstext -->
    <div id='main'><br>
    <table border="0" width="100%" height="100%' cellspacing="0" cellpadding="0">

            <tr>
                    <!-- Das Logo Bild -->
                    <!-- <img border="0" src="./img/logo.png" width="40%" height="40%"> -->
                    <?php if ($logoon == "ON") { echo "<img border=\"0\" src= $logo width= $breite height= $hoehe >"; } ?>

                    <!-- Der Begruessungstext -->
                    <!-- <p>Welcome to the metaverse!</p> -->
                    <?php if ($texton == "ON") { echo "$text"; }?>
            </tr>

    </table>
    </div>

  <!-- Statistik rechts oben splash.css name stats1 -->
  <div id='stats1'>
  <fieldset class='grey'>

  <!-- Datenbankabfrage Statistik -->
      <?php        
      //$con = mysqli_connect($CONF_db_server,$CONF_db_user,$CONF_db_pass,$CONF_db_database);
      $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

      // Query the database and get the count
      $result1 = mysqli_query($con,"SELECT COUNT(*) FROM Presence") or die("Error: " . mysqli_error($con));
      list($totalUsers) = mysqli_fetch_row($result1);
      $result2 = mysqli_query($con,"SELECT COUNT(*) FROM regions") or die("Error: " . mysqli_error($con));
      list($totalRegions) = mysqli_fetch_row($result2);
      $result3 = mysqli_query($con,"SELECT COUNT(*) FROM UserAccounts") or die("Error: " . mysqli_error($con));
      list($totalAccounts) = mysqli_fetch_row($result3);
      $result4 = mysqli_query($con,"SELECT COUNT(*) FROM GridUser WHERE Login > (UNIX_TIMESTAMP() - (30*86400))") or die("Error: " . mysqli_error($con));
      list($activeUsers) = mysqli_fetch_row($result4);
      $result5 = mysqli_query($con,"SELECT COUNT(*) FROM GridUser") or die("Error: " . mysqli_error($con));
      list($totalGridAccounts) = mysqli_fetch_row($result5);

      // Display the results
      echo "<div id='stats2'><b><font color=#00FF00>Nutzer im Grid</font><font color=#FFFFFF> : ". $totalUsers ."<font color=#FFFFFF><br>";
      echo "<font color=#00FF00>Regionen</font> : ". $totalRegions ."<font #FFFFFF><br>";
      echo "<font color=#00FF00>Aktiv in den letzten 30 Tage</font> : ". $activeUsers ."<font color=#FFFFFF><br>";
      echo "<font color=#00FF00>InworldNutzer</font> : ". $totalAccounts ."<font color=#FFFFFF><br>";
      echo "<font color=#00FF00>HgGridNutzer</font> : ". $totalGridAccounts ."<font color=#FFFFFF><br>";
      echo "<font color=#00AA00>Grid is ONLINE</font></b><br></div>";
      ?>

  </fieldset>
  </div>

  <!-- Skript -->
  <script>
  var slideIndex = 0;
  var slides = document.getElementsByClassName("PictureSlider");
  
  function carousel() {
      for (var i = 0; i < slides.length; i++) {
          slides[i].classList.remove("active"); // Alle Bilder ausblenden
      }
      slideIndex++;
      if (slideIndex > slides.length) { slideIndex = 1 }
      slides[slideIndex - 1].classList.add("active"); // Nächstes Bild einblenden
      setTimeout(carousel, <?php echo $ptime; ?>); // Bildwechsel-Zeit
  }

  document.addEventListener("DOMContentLoaded", function() {
      if (slides.length > 0) {
          slides[0].classList.add("active"); // Erstes Bild sichtbar machen
      }
      setTimeout(carousel, <?php echo $ptime; ?>);
  });
</script>


</wspbody>
</html>

<?php //include 'include/footer.php'; ?>
