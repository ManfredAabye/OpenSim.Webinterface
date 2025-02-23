<?php
// visitorlist.php
$title = "Visitor List Service";
include_once "include/header.php";
?>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        background: #ffffff;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .visitor {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #dddddd;
        border-radius: 5px;
        background-color: #fafafa;
    }
    .visitor b {
        color: #333333;
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
        echo "<div class='status offline'>❌ Grid ist OFFLINE</div>";
    } else {
        $sql = "SELECT * FROM userinfo ORDER BY userinfo.avatar, userinfo.user, userinfo.serverurl";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($dsatz = mysqli_fetch_assoc($result)) {
                $avatar = htmlspecialchars($dsatz["avatar"]);
                $serverurl = htmlspecialchars($dsatz["serverurl"]);
                $user = htmlspecialchars($dsatz["user"]);

                echo "<div class='visitor'>";
                echo "<b>Besuchername:</b> $avatar<br>";
                echo "<b>Server:</b> $serverurl<br>";
                echo "<b>Username:</b> $user<br>";
                echo "</div>";
            }
        } else {
            echo "<div class='status'>Keine Besucher gefunden.</div>";
        }

        mysqli_close($con);
    }
    ?>
</div>
