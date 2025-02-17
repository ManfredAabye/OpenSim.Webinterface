<?php
$title = "Inventory List";
include 'include/header.php';

// Database connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn_assets = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_ASSET_NAME);
if ($conn_assets->connect_error) {
    die("Connection failed: " . $conn_assets->connect_error);
}

// Function to get the icon based on asset type
function getIcon($assetType) {
    $icons = [
        -2 => 'folder', 57 => 'folder', 0 => 'texture', 1 => 'volume_up', 2 => 'contact_page',
        3 => 'place', 5 => 'checkroom', 6 => 'category', 7 => 'note', 10 => 'code', 13 => 'body',
        20 => 'animation', 21 => 'gesture', 49 => '3d_rotation', 56 => 'settings'
    ];
    return $icons[$assetType] ?? 'folder'; // Default to folder icon
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user input
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $reg_pass = filter_input(INPUT_POST, 'reg_pass', FILTER_SANITIZE_STRING);

    if ($firstName && $lastName && $reg_pass) {
        if (in_array($reg_pass, $registration_passwords_inventory)) {
            // Retrieve user information
            $stmt = $conn->prepare("SELECT PrincipalID FROM UserAccounts WHERE FirstName = ? AND LastName = ?");
            $stmt->bind_param("ss", $firstName, $lastName);
            $stmt->execute();
            $stmt->bind_result($userUUID);
            $stmt->fetch();
            $stmt->close();

            if ($userUUID) {
                // Retrieve folder structure for the specific agentID
                $stmt2 = $conn->prepare("SELECT * FROM inventoryfolders WHERE agentID = ? ORDER BY folderName ASC");
                $stmt2->bind_param("s", $userUUID);
                $stmt2->execute();
                $folders = $stmt2->get_result();
                $stmt2->close();
                
                echo "User UUID: " . $userUUID . "<br>"; // Debug-Ausgabe
                echo "Number of folders found: " . $folders->num_rows . "<br>"; // Debug-Ausgabe
            } else {
                echo "No user found with the given name.<br>"; // Debug-Ausgabe
            }
        } else {
            echo "Invalid registration password.<br>"; // Debug-Ausgabe
        }
    } else {
        echo "Please fill in all fields correctly.<br>"; // Debug-Ausgabe
    }
}
?>

<html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,-25&icon_names=folder" />
    <style>
        body { font-family: Arial, sans-serif; background-color: <?= SECONDARY_COLOR ?>; padding: 10px; color: <?= PRIMARY_COLOR ?>;}
        .inventory-container,.form-container,.inventory-list,.folder-content{display:flex; flex-direction:column; }

        .form-container{ background-color:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px rgba(0,0,0,0.1);max-width:800px;width:100%; }

        label{display:block;margin-bottom:8px;font-weight:bold;}
        input[type="text"],input[type="password"],input[type="number"],select,textarea{width:calc(100% - 20px);padding:8px;margin-bottom:15px;border:1px solid #ccc;border-radius:4px;}
        input[type="checkbox"]{margin-bottom:15px;}
        .button{background-color:#007bff;border:none;color:white;padding:12px 24px;text-align:center;text-decoration:none;display:inline-block;font-size:16px;border-radius:4px;cursor:pointer;transition:background-color 0.3s ease;}
        .button:hover{background-color:#0056b3;}
        .button-secondary{background-color:#6c757d;}
        .button-secondary:hover{background-color:#5a6268;}
        .button-success{background-color:#28a745;}
        .button-success:hover{background-color:#218838;}
        .button-danger{background-color:#dc3545;}
        .button-danger:hover{background-color:#c82333;}
        .inventory-list{margin-top:20px;}
        .folder,.item{display:flex;align-items:center;margin:10px 0;cursor:pointer;}
        .folder span,.item span{font-size:36px;margin-right:10px;}
        .folder-content{margin-left:36px;}
    </style>
    
    <script>
        function toggleFolderContent(folderID) {
            var folderContent = document.getElementById('folder-content-' + folderID);
            if (folderContent.style.display === 'none') {
                folderContent.style.display = 'block';
            } else {
                folderContent.style.display = 'none';
            }
        }
    </script>

<body>
    <div class="inventory-container" style="justify-content: center; align-items: center;">
        <div class="form-container">
            <h2><?php echo SITE_NAME; ?> Inventory List Overview</h2>
            <p>All information related to the Inventory List can be found here.</p>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required>
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required>
                <label for="reg_pass">Registrierungspasswort: (Dies muss beim Admin beantragt werden.)</label>
                <input type="password" id="reg_pass" name="reg_pass" required><br>
                <input type="submit" value="Submit" class="button">
            </form>
            <div class="inventory-list">
                <?php
                if (!empty($folders) && $folders->num_rows > 0) {
                    while($folder = $folders->fetch_assoc()) {
                        echo '<div class="folder">';
                        echo '<span class="material-symbols-outlined">folder</span>';
                        echo '<p>' . $folder['folderName'] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No folders found for this user.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
$conn_assets->close();
include 'include/footer.php';
?>