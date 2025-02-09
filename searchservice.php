<?php
$title = "SearchService";
include 'include/config.php';
include 'include/header.php';
?>

<style>
htmlBody {font-family: Arial, sans-serif; background-color: #f4f4f4; color: black; margin: 0; padding: 0;} 
main {width: 75%; margin: 2em auto; padding: 2em; background-color: #ffffff; color: black; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);} 
h2 {color: #333;} 
form label {display: block; margin-bottom: 0.5em; color: #333;} 
form input[type="text"], form select {width: 100%; padding: 5px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;} 
form input[type="submit"] {padding: 5px 20px; background-color: #007BFF; color: #ffffff; border: none; border-radius: 4px; cursor: pointer;} 
form input[type="submit"]:hover {background-color: #0056b3;} 
table {width: 100%; border-collapse: collapse; font-size: 0.72em;} /* Schriftgröße um 10% reduziert */ 
table, th, td {border: 1px solid #ccc;} 
th, td {padding: 8px; text-align: left;}
</style>

<main>
    <h2><?php echo SITE_NAME; ?> SearchService Overview</h2>
    <p>All information related to the SearchService can be found here.</p>

    <form method="post" action="">
        <label for="search_type">Search Type:</label>
        <select id="search_type" name="search_type">
            <option value="inventoryitems">Inventory Items</option>
            <option value="inventoryfolders">Inventory Folders</option>
        </select>
        <label for="search_query">Search Query:</label>
        <input type="text" id="search_query" name="search_query" required>
        <input type="submit" value="Search">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $search_type = filter_input(INPUT_POST, 'search_type', FILTER_SANITIZE_STRING);
        $search_query = filter_input(INPUT_POST, 'search_query', FILTER_SANITIZE_STRING);

        $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($search_type === 'inventoryitems') {
            $query = "SELECT assetID, inventoryName, salePrice, avatarID FROM inventoryitems WHERE inventoryName LIKE '%$search_query%' OR inventoryDescription LIKE '%$search_query%'";
        } elseif ($search_type === 'inventoryfolders') {
            $query = "SELECT folderName, type, version, folderID, agentID FROM inventoryfolders WHERE folderName LIKE '%$search_query%'";
        } else {
            $query = "";
        }

        if ($query) {
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<h3>Search Results:</h3>";
                echo "<table>";
                echo "<tr>";
                foreach (mysqli_fetch_fields($result) as $field) {
                    echo "<th>" . htmlspecialchars($field->name) . "</th>";
                }
                echo "</tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No results found.</p>";
            }
        }
        mysqli_close($con);
    }
    ?>
</main>

<?php include 'include/footer.php'; ?>
