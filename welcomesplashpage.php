<?php
$title = "Welcome";
include "include/config.php";
?>

<html>

<head>
    <meta charset="UTF-8">

    <style>
        #main {
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 1;
        }

        #stats1 {
            position: absolute;
            right: 10px;
            top: 23px;
            text-align: left;
            height: 90px;
            width: 250px;
            z-index: 3;
            color: <?php echo PRIMARY_COLOR_LOGO; ?>;
        }

        fieldset {
            padding: 10px;
            border-radius: 8px;
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
        }

        legend {
            color: #FFF;
        }

        fieldset.white,
        fieldset.white2 {
            padding: 5px;
            height: 96%;
            border: 3px solid <?php echo LINK_COLOR; ?>;
        }

        .PictureSlider {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 2s ease-in-out;
        }

        .PictureSlider.active {
            opacity: 1;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            width: 100%;
            height: 100%;
        }

        #background1 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .wspbody {
            margin: 0px;
            font-family: <?php echo FONT_FAMILY; ?>;
            font-size: <?php echo BASE_FONT_SIZE; ?>;
            background: <?php echo SECONDARY_COLOR; ?>;
        }

        p {
            margin: 0px;
            font-family: <?php echo FONT_FAMILY; ?>;
            color: <?php echo PRIMARY_COLOR_LOGO; ?>;
            font-size: <?php echo TITLE_FONT_SIZE; ?>;
            font-weight: bold;
        }

        a {
            color: <?php echo LINK_COLOR; ?>;
        }

        a:hover {
            color: <?php echo LINK_HOVER_COLOR; ?>;
        }

        #stats2 {
            font-family: <?php echo FONT_FAMILY; ?>;
            font-size: <?php echo STATS_FONT_SIZE; ?>;
        }
    </style>
</head>

<body class="wspbody">

    <!-- PHP Script für alle Bilder aus einem Verzeichnis -->
    <?php
    $allebilder = scandir(SLIDESHOW_FOLDER);
    ?>

    <div id="background1">
        <?php
        foreach ($allebilder as $bild) {
            $bildinfo = pathinfo(SLIDESHOW_FOLDER . "/" . $bild);
            if (!in_array($bild, [".", "..", "_notes"]) && $bildinfo['basename'] !== "Thumbs.db") {
                ?>
                <li>
                    <div id="background1">
                        <img class="PictureSlider" src="<?php echo SLIDESHOW_FOLDER . "/" . $bild; ?>"
                            style="<?php echo IMAGE_SIZE; ?>" alt="slide">
                    </div>
                </li>
                <?php
            }
        }
        ?>
    </div>

    <!-- Logo oder Begrüßungstext -->
    <div id='main'><br>
        <table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
            <tr>
                <?php
                if (LOGO_ON === 'ON') {
                    echo "<img border='0' src='" . LOGO_PATH . "' width='" . LOGO_WIDTH . "' height='" . LOGO_HEIGHT . "'>";
                }?>

                <?php if (TEXT_ON === 'ON') { ?>
                  <div style="
                      width: <?php echo WELCOME_TEXT_WIDTH; ?>;
                      height: <?php echo WELCOME_TEXT_HEIGHT; ?>;
                      color: <?php echo WELCOME_TEXT_COLOR; ?>;
                      text-align: <?php echo WELCOME_TEXT_ALIGN; ?>;
                      font-size: <?php echo WELCOME_TEXT_FONT_SIZE; ?>;
                      margin: 0; /* Kein automatisches Zentrieren */
                      display: block; /* Sicherstellen, dass es sich wie ein Block verhält */
                  ">
                      <?php echo WELCOME_TEXT; ?>
                  </div>
              <?php } ?>
              
              
            </tr>
        </table>
    </div>

    <!-- Statistik -->
    <div id='stats1'>
        <fieldset class='grey'>
            <?php
            $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

            $result1 = mysqli_query($con, "SELECT COUNT(*) FROM Presence");
            list($totalUsers) = mysqli_fetch_row($result1);

            $result2 = mysqli_query($con, "SELECT COUNT(*) FROM regions");
            list($totalRegions) = mysqli_fetch_row($result2);

            $result3 = mysqli_query($con, "SELECT COUNT(*) FROM UserAccounts");
            list($totalAccounts) = mysqli_fetch_row($result3);

            $result4 = mysqli_query($con, "SELECT COUNT(*) FROM GridUser WHERE Login > (UNIX_TIMESTAMP() - (30*86400))");
            list($activeUsers) = mysqli_fetch_row($result4);

            $result5 = mysqli_query($con, "SELECT COUNT(*) FROM GridUser");
            list($totalGridAccounts) = mysqli_fetch_row($result5);

            echo "<div id='stats2'>";
            echo "<b><font color=#00FF00>Nutzer im Grid</font>: " . $totalUsers . "<br>";
            echo "<font color=#00FF00>Regionen</font>: " . $totalRegions . "<br>";
            echo "<font color=#00FF00>Aktiv in den letzten 30 Tagen</font>: " . $activeUsers . "<br>";
            echo "<font color=#00FF00>Inworld Nutzer</font>: " . $totalAccounts . "<br>";
            echo "<font color=#00FF00>HG Grid Nutzer</font>: " . $totalGridAccounts . "<br>";
            echo "<font color=#00AA00>Grid is ONLINE</font></b><br></div>";
            ?>
        </fieldset>
    </div>

    <!-- Skript für Slideshow -->
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
            setTimeout(carousel, <?php echo SLIDESHOW_DELAY; ?>);
        }

        document.addEventListener("DOMContentLoaded", function () {
            if (slides.length > 0) {
                slides[0].classList.add("active");
            }
            setTimeout(carousel, <?php echo SLIDESHOW_DELAY; ?>);
        });
    </script>
</body>
</html>
