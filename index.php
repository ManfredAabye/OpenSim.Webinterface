<?php include('include/config.php'); ?>
<?php $title = "Home"; ?>
<?php include('include/header.php'); ?>

<main class="container">
    <h2>Willkommen auf der <?php echo SITE_NAME; ?> Startseite</h2>
    <p>Nutze die folgenden Links, um die verschiedenen Seiten zu besuchen:</p>
    <ul>
        <li><a href="welcomesplashpage.php">Welcome Page</a></li>
        <li><a href="economycashbook.php">Economy Page</a></li>
        <li><a href="aboutinformation.php">About Page</a></li>
        <li><a href="registeruser.php">Register Page</a></li>
        <li><a href="help.php">Help Page</a></li>
        <li><a href="passwordreset.php">Password Page</a></li>
        <li><a href="gridstatus.php">GridStatus Page</a></li>
        <li><a href="gridstatusrss.php">GridStatusRSS Page</a></li>
    </ul>
</main>

<?php include('include/footer.php'); ?>
