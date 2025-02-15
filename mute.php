<?php
$title = "MMuteList Service";
include 'include/header.php';

// falseInvalid request das ganze scheint nicht mehr benötigt zu werden.

$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($db->connect_error) {
    die(json_encode([
        'success' => false,
        'errorMessage' => 'Error connecting to the database: ' . $db->connect_error
    ]));
}

// Set charset to utf8
$db->set_charset("utf8");

function get_error_message($result)
{
    global $db;
    if (!$result)
        return $db->error;
    return "";
}

// Helper function to send XML response
function xml_response($success, $errorMessage = "", $data = [])
{
    header('Content-Type: application/xml');
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<response>';
    $xml .= '<success>' . ($success ? 'true' : 'false') . '</success>';
    $xml .= '<errorMessage>' . htmlspecialchars($errorMessage) . '</errorMessage>';

    if (!empty($data)) {
        $xml .= '<mutelist>';
        foreach ($data as $item) {
            $xml .= '<entry>';
            $xml .= '<AgentID>' . htmlspecialchars($item['AgentID']) . '</AgentID>';
            $xml .= '<MuteID>' . htmlspecialchars($item['MuteID']) . '</MuteID>';
            $xml .= '<MuteName>' . htmlspecialchars($item['MuteName']) . '</MuteName>';
            $xml .= '<type>' . htmlspecialchars($item['type']) . '</type>';
            $xml .= '<flags>' . htmlspecialchars($item['flags']) . '</flags>';
            $xml .= '<Stamp>' . htmlspecialchars($item['Stamp']) . '</Stamp>';
            $xml .= '</entry>';
        }
        $xml .= '</mutelist>';
    }

    $xml .= '</response>';
    echo $xml;
    exit;
}

// Handle mutelist request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'mutelist_request') {
    if (!isset($_GET['avataruuid'])) {
        xml_response(false, 'Missing avataruuid parameter');
    }

    $avatarUUID = $_GET['avataruuid'];
    $query = $db->prepare("SELECT AgentID, MuteID, MuteName, type, flags, Stamp FROM mutelist WHERE AgentID = ?");
    $query->bind_param("s", $avatarUUID);
    $result = $query->execute();

    if (!$result) {
        xml_response(false, get_error_message($result));
    }

    $query->store_result();
    $query->bind_result($agentID, $muteID, $muteName, $type, $flags, $stamp);

    $mutelist = [];
    while ($query->fetch()) {
        $mutelist[] = [
            'AgentID' => $agentID,
            'MuteID' => $muteID,
            'MuteName' => $muteName,
            'type' => $type,
            'flags' => $flags,
            'Stamp' => $stamp
        ];
    }

    xml_response(true, '', $mutelist);
}

// Handle mutelist update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mutelist_update') {
    $requiredParams = ['avataruuid', 'muteuuid', 'name', 'type', 'flags'];
    foreach ($requiredParams as $param) {
        if (!isset($_POST[$param])) {
            xml_response(false, "Missing parameter: $param");
        }
    }

    $avatarUUID = $_POST['avataruuid'];
    $muteUUID   = $_POST['muteuuid'];
    $name       = $_POST['name'];
    $type       = $_POST['type'];
    $flags      = $_POST['flags'];

    $query = $db->prepare("INSERT INTO mutelist (AgentID, MuteID, MuteName, type, flags) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("sssii", $avatarUUID, $muteUUID, $name, $type, $flags);
    $result = $query->execute();

    if (!$result) {
        xml_response(false, get_error_message($result));
    }

    xml_response(true);
}

// Handle mutelist remove
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mutelist_remove') {
    $requiredParams = ['avataruuid', 'muteuuid'];
    foreach ($requiredParams as $param) {
        if (!isset($_POST[$param])) {
            xml_response(false, "Missing parameter: $param");
        }
    }

    $avatarUUID = $_POST['avataruuid'];
    $muteUUID   = $_POST['muteuuid'];

    $query = $db->prepare("DELETE FROM mutelist WHERE AgentID = ? AND MuteID = ?");
    $query->bind_param("ss", $avatarUUID, $muteUUID);
    $result = $query->execute();

    if (!$result) {
        xml_response(false, get_error_message($result));
    }

    xml_response(true);
}

// Invalid request
xml_response(false, 'Invalid request');