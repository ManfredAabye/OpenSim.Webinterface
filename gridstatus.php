<?php
$title = "GridStatus";
include 'include/config.php';
include 'include/header.php';
?>

<main>
    
    <style>
        h2 {font-family: <?php echo FONT_FAMILY; ?>;font-size: <?php echo TITLE_FONT_SIZE; ?>;}
        #statitstics {font-family: <?php echo FONT_FAMILY; ?>;font-size: <?php echo TITLE_FONT_SIZE; ?>;}
        .pacifico-regular {font-family: "Pacifico", serif; font-weight: 400; font-style: normal;}
        .material-symbols-outlined {font-variation-settings:'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24 } 
    </style>

    <h2><?php echo SITE_NAME; ?> GridStatus Overview</h2>
    <p>All information related to the GridStatus can be found here.</p>

</main>

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
    
    echo "<div id='statitstics'>";
    echo "<b>Nutzer im Grid</font>: " . $totalUsers . "<br>";
    echo "Regionen</font>: " . $totalRegions . "<br>";
    echo "Aktiv in den letzten 30 Tagen</font>: " . $activeUsers . "<br>";
    echo "Inworld Nutzer</font>: " . $totalAccounts . "<br>";
    echo "HG Grid Nutzer</font>: " . $totalGridAccounts . "<br>";

?>

<?php include 'include/footer.php'; ?>