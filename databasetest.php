
<?php
$title = "Datenbank Test";
include 'include/header.php';

// Database connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$agentID='134e495d-0b1e-48b5-b10b-b009a600cdca';

//$sql = "SELECT * FROM `inventoryfolders` ORDER BY `inventoryfolders`.`$agentID` ASC, `inventoryfolders`.`type` ASC";
$sql = "SELECT * FROM `inventoryfolders`";

$result = $conn->query($sql);
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,-25&icon_names=folder" />

<?php

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        //echo "<span class="material-symbols-outlined">folder</span>" . $row["folderName"]. " - Type: " . $row["type"]. "<br>";
        echo '<span class="material-symbols-outlined">folder</span>' . $row["folderName"] . '<br>';
    }
} else {
    echo "0 results";
}


$conn->close();

include 'include/footer.php'; 
?>