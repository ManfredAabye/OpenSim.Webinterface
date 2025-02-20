<?php $title = "Home"; ?>
<?php include_once('include/header.php'); ?>

<style>
   .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      Color:rgb(31, 31, 31);
      background-color:rgb(238, 241, 241);
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
   }
</style>

<main class="container">
    <h2>Willkommen auf der <?php echo SITE_NAME; ?> Startseite</h2>
    <p>Nutze die folgenden Links, um die verschiedenen Seiten zu besuchen:</p>
    <ul>
        <li><a href="aboutinformation.php">About Page</a></li>
        <li><a href="avatarpicker.php">Avatar Picker Page</a></li>
        <li><a href="cashbook.php">Economy cashbook Page</a></li>
        <li><a href="gridlist.php">Gridlist Page</a></li>
        <li><a href="gridstatus.php">GridStatus Page</a></li>
        <li><a href="gridstatusrss.php">GridStatusRSS Page</a></li>
        <li><a href="guide.php">Destination Guide Page</a></li>
        <li><a href="help.php">Help Page</a></li>
        <li><a href="icecast.php">Icecast Page</a></li>
        <li><a href="include/paswd_generator.php">password generator Page</a></li>
        <li><a href="inventory.php">Inventory Page</a></li>
        <li><a href="iarservice.php">IAR Service Page</a></li>
        <li><a href="listinventar.php">List Inventar Page</a></li>
        <li><a href="maptile.php">Maptile Page</a></li>
        <li><a href="mutelist.php">Mute Page</a></li>
        <li><a href="partner.php">Partner Page</a></li>
        <li><a href="passwordreset.php">Password Page</a></li>
        <li><a href="picreader.php">Picreader Page</a></li>
        <li><a href="registeruser.php">Register Page</a></li>
        <li><a href="searchservice.php">Search Page</a></li>
        <li><a href="tabledata.php">Tabledata Page</a></li>
        <li><a href="welcomesplashpage.php">Welcome Page</a></li>
        <li><a href="include/tos.php">TOS Page</a></li>
        <li><a href="include/dmca.php">DMCA Page</a></li>
    </ul>
</main>

<?php include_once('include/footer.php'); ?>
